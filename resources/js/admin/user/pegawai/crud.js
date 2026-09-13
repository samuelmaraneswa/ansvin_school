import { navigateAdmin } from "../../../sidebar"
import { showAlert } from "../../../utility/sweetAlert"

export function initCRUDPegawai(){
  handleCreate()
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
      // console.log(data)

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