import { navigateAdmin } from "../../../sidebar"
import { showAlert, showConfirm } from "../../../utility/sweetAlert"
import { loadPegawai } from "./loadData"
import { getReturnURL } from "./urlState"

export function initCRUDPegawai(){
  handleAvatarPreview()
  handleCreate()
  handleUpdate()
  handleDestroy()
}

function handleAvatarPreview(){
  const input = document.querySelector('[data-user-avatar]')
  const preview = document.querySelector('[data-avatar-user-preview]')

  if(!input || !preview) return

  input.addEventListener('change', () => {
    const file = input.files[0]

    if(!file) return

    preview.src = URL.createObjectURL(file)
  })
}

function clearValidation(){
  const form = document.querySelector('[data-form-pegawai]')
  if(!form) return

  form.querySelectorAll('[data-error-field]').forEach(el => {
    el.textContent = ''
  })
}

function showValidation(errors){
  const form = document.querySelector('[data-form-pegawai]')
  if(!form) return

  Object.entries(errors).forEach(([field, messages]) => {
    const el = form.querySelector(`[data-error-field="${field}"]`)
    if(el){
      const message = messages[0]

      el.textContent = message.charAt(0).toUpperCase() + message.slice(1)
    }
  });
}

async function handleCreate(){
  const form = document.querySelector('[data-form-pegawai]')
  if(!form) return
  // console.log(form)

  const id = form.querySelector('[data-pegawai-id]')
  if(id && id.value.trim()) return

  const urlKode = form.dataset.generateKode
  
  async function generateCode(){
    const res = await fetch(urlKode)
    return await res.json()
  }

  const kode = await generateCode()

  const login_id = form.querySelector('[data-user-login_id]')
  const kode_pegawai = form.querySelector('[data-user-kode_pegawai]')

  if(!login_id || !kode_pegawai) return

  login_id.value = kode.kode_pegawai
  kode_pegawai.value = kode.kode_pegawai

  const name = form.querySelector('[data-user-name]')
  const role = form.querySelector('[data-user-role]')

  if(!name || !role) return

  form.addEventListener('submit', async (e) => {
    e.preventDefault()

    clearValidation()

    const errors = {}

    if(!name.value.trim()) errors.name = ["Nama wajib diisi!"]
    if(!role.value.trim()) errors.role = ["Role wajib diisi!"]

    if(Object.keys(errors).length){
      showValidation(errors)
      return
    }

    const formData = new FormData(form)
    const url = form.dataset.storeUrl

    try{
      const res = await fetch(url, {
        method: "POST",
        body: formData
      })

      const data = await res.json()
      console.log(data.errors)

      if(!res.ok){
        if(data.errors){
          showValidation(data.errors)
        }
        return
      }

      showAlert('success', 'Berhasil', data.message, () => {
        navigateAdmin(form.dataset.indexUrl)
      })
    }catch(err){
      console.error(err)
    }
  })
}

function handleUpdate(){
  const form = document.querySelector('[data-form-pegawai]')
  if (!form) return

  const id = form.querySelector('[data-pegawai-id]')
  if(!id || !id.value.trim()) return;

  const login_id = form.querySelector('[data-user-login_id]')
  const kode_pegawai = form.querySelector('[data-user-kode_pegawai]')
  if(!kode_pegawai || !login_id) return 

  const name = form.querySelector('[data-user-name]')
  const role = form.querySelector('[data-user-role]')
  if(!name || !role) return

  form.addEventListener('submit', async (e) => {
    e.preventDefault()

    clearValidation()

    const errors = {}
    if(!name.value.trim()) errors.name = ["Nama wajib diisi!"]
    if(!role.value.trim()) errors.role = ["Role wajib diisi!"]

    if(Object.keys(errors).length){
      showValidation(errors)
      return
    }

    const formData = new FormData(form)
    // console.log([...formData.entries()]);
    const url = form.dataset.updateUrl
    
    try{
      const res = await fetch(url, {
        method: "PUT",
        body: formData
      })

      const data = await res.json()
      // console.log(data)
      if(!res.ok){
        if(data.errors){
          showValidation(data.errors)
        }
        return
      }

      showAlert('success', 'Berhasil', data.message, () => {
        navigateAdmin(getReturnURL())
      })
    }catch(err){
      console.error(err)

      showAlert('error', 'Gagal', 'Terjadi kesalahan server.' )
    }
  })
}

function handleDestroy(){
  const tbody = document.querySelector('[data-admin-pegawai-table]')
  if(!tbody) return

  tbody.addEventListener('click', async (e) => {
    const button = e.target.closest('[data-delete-pegawai]')
    if(!button) return

    showConfirm(
      'Nonaktifkan Data?',
      'Data akan di nonaktifkan.',
      async () => {
        try{
          const res = await fetch(button.dataset.deleteUrl, {
            method: "DELETE",
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          })

          const data = await res.json()
          // console.log(data)
          if(!res.ok){
            showAlert('Error', 'Gagal', data.message)
          }

          showAlert('success', 'Berhasil', data.message, () => loadPegawai())
        }catch(err){
          console.error(err)
          showAlert('error', 'Gagal', 'Terjadi kesalah pada server.');
        }
      }
    )
  })
}