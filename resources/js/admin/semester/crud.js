import { showAlert, showConfirm } from "../../utility/sweetAlert"
import { clearValidation, showValidation, toggleBtn } from "../../utility/validation"
import { initTableSemester } from "./table"

export function initCRUDSemester(){
  handleSubmit()
  toggleActivation()
}

function handleSubmit(){
  const btnTambah = document.querySelector('[action="admin-tambah-semester"]')
  const tbody = document.querySelector('[table-admin-semester]')
  if(!btnTambah || !tbody) return

  const modal = document.querySelector('[modal-admin-semester]')
  if(!modal) return

  const modalContent = modal.querySelector('[modal-content]')
  const iconX = modal.querySelector('[action="close-modal-semester"]')
  if(!modalContent || !iconX) return

  const title = modalContent.querySelector('[title-semester]')  
  const form = modalContent.querySelector('[form-semester]')
  if(!title || !form) return

  const idEl = form.querySelector('[name="id"]')
  const tahun_ajaran_id = form.querySelector('[name="tahun_ajaran_id"]')
  const nama = form.querySelector('[name="nama"]')
  const tanggal_mulai = form.querySelector('[name="tanggal_mulai"]')
  const tanggal_selesai = form.querySelector('[name="tanggal_selesai"]')
  const btnSimpan = form.querySelector('#btnSimpan')
  if(!idEl || !tahun_ajaran_id || !nama || !tanggal_mulai || !tanggal_selesai || !btnSimpan) return

  function openModal(){
    modal.classList.remove('opacity-0', 'invisible')
    modalContent.classList.remove('translate-y-[3.75]')
  }

  function closeModal(){
    modal.classList.add('opacity-0', 'invisible')
    modalContent.classList.add('translate-y-[3.75]') 

    form.reset()
  }

  btnTambah.addEventListener('click', () => {
    title.textContent = 'Tambah'

    openModal()
  })

  tbody.addEventListener('click', async (e) => {
    const btnEdit = e.target.closest('[action="edit-admin-semester"]')
    if(!btnEdit) return

    const id = btnEdit.dataset.id

    const url = semesterRoutes.show.replace('__ID__', id)
    try{
      const res = await fetch(url,{
        headers: {'Accept': 'application/json'},
      })
      const data = await res.json()
      // console.log(data)

      if(!res.ok){
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: data.message || 'Data tidak di temukan.'
        })
        return
      }

      title.textContent = "Edit"

      idEl.value = data.semester.id
      tahun_ajaran_id.value = data.semester.tahun_ajaran_id
      nama.value = data.semester.nama
      tanggal_mulai.value = data.semester.tanggal_mulai
      tanggal_selesai.value = data.semester.tanggal_selesai

      clearValidation()
      openModal()
    }catch(err){
      console.error(err)
    }
  })

  iconX.addEventListener('click',  closeModal)

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    clearValidation()

    toggleBtn(btnSimpan, true)

    const errors = {}
    if(!tahun_ajaran_id.value.trim()) errors.tahun_ajaran_id = ["Tahun Ajaran harus di isi."]
    if(!nama.value.trim()) errors.nama = ["Nama harus di isi."]
    if(!tanggal_mulai.value.trim()) errors.tanggal_mulai = ["Tanggal mulai harus di isi."]
    if(!tanggal_selesai.value.trim()) errors.tanggal_selesai = ["Tanggal selesai harus di isi."]

    if (tanggal_mulai.value && tanggal_selesai.value && tanggal_selesai.value <= tanggal_mulai.value) {
      errors.tanggal_selesai = ['Tanggal selesai harus setelah tanggal mulai!']
    }

    if(Object.keys(errors).length){
      showValidation(errors)

      toggleBtn(btnSimpan, false)
      return
    }

    const isUpdate = idEl.value.trim() !== ""

    const url = isUpdate ? form.dataset.updateUrl.replace(':id', idEl.value) : form.dataset.storeUrl
    const method = isUpdate ? "PUT" : "POST"
    
    const formData = new FormData(form)

    try{
      const res = await fetch(url, {
        method,
        headers: {'Accept': 'application/json'},
        body: formData
      })

      const data = await res.json()
      console.log(data)

      if(!res.ok){
        if(data.errors){
          showValidation(data.errors)
        }else{
          showAlert('error', 'Error', "Terjadi kesalah pada server!")
        }

        return
      }

      showAlert('success', 'Berhasil', data.message, () => {
        closeModal()

        initTableSemester()
      })
    }catch(err){
      console.error(err)
    } finally{
      toggleBtn(btnSimpan, false)
    }
  })
}

function toggleActivation(){
  const tbody = document.querySelector('[table-admin-semester]')
  if(!tbody) return

  tbody.addEventListener('click', (e) => {
    const btnActivation = e.target.closest('[action="toggleAktivasiSemester"]')
    if(!btnActivation) return

    const id = btnActivation.dataset.id
    const csrf = document.querySelector('meta[name="csrf-token"]').content
    
    showConfirm(
      'Ubah Status Aktivasi?',
      'Status aktivasi Tahun Ajaran akan diubah.',
      async () => {
        const url = semesterRoutes.activation.replace('__ID__', id)

        try{
          const res = await fetch(url, {
            method: 'PUT',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrf
            }
          })

          const data = await res.json()
          console.log(data)

          if(!res.ok){
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: data.message || 'Data tidak di temukan.'
            })
            return
          }

          showAlert('success', 'Berhasil', data.message)

          initTableSemester()
        }catch(err){
          console.error(err)
        }
      }
    )
  })
}