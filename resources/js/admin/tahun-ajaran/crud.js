import { showAlert, showConfirm } from "../../utility/sweetAlert"
import { clearValidation, showValidation } from "../../utility/validation"
import { initTabelTA } from "./table-tajaran"

export function CRUDTahunAjaran(){
  handleSubmit()
  toggleAktivasi()
}

function handleSubmit(){
  const btnTambah = document.querySelector('[data-action="tambah-tahun-ajaran"]')
  const tbody = document.querySelector('[data-admin-tahun-ajaran-table]')
  if(!btnTambah || !tbody) return

  const modal = document.querySelector('[modal-tahun-ajaran]')
  if(!modal) return

  const modalContent = modal.querySelector('[data-modal-content]')
  const iconX = modal.querySelector('[data-action="close-modal-tahun-ajaran"]')
  if(!modalContent || !iconX) return
  
  const title = modalContent.querySelector('[title-tahun-ajaran]')
  const form = modalContent.querySelector('[form-tahun-ajaran]')
  if(!title || !form) return
  
  const idEl = form.querySelector('[name="id"]')
  const nama = form.querySelector('[name="nama"]')
  const tanggal_mulai = form.querySelector('[name="tanggal_mulai"]')
  const tanggal_selesai = form.querySelector('[name="tanggal_selesai"]')
  if(!idEl || !nama || !tanggal_mulai || !tanggal_selesai) return

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
    title.textContent = "Tambah"

    openModal()
  })
  
  iconX.addEventListener('click', closeModal)

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    clearValidation()

    const errors = {}
    if(!nama.value.trim()) errors.nama = ["Nama tahun ajaran mesti di isi!"]
    if(!tanggal_mulai.value.trim()) errors.tanggal_mulai = ["Tanggal Mulai tahun ajaran mesti di isi!"]
    if(!tanggal_selesai.value.trim()) errors.tanggal_selesai = ["Tanggal selesai tahun ajaran mesti di isi!"]

    if (tanggal_mulai.value && tanggal_selesai.value && tanggal_selesai.value <= tanggal_mulai.value) {
      errors.tanggal_selesai = ['Tanggal selesai harus setelah tanggal mulai!']
    }

    
    const isEdit = idEl.value.trim() !== ""

    const url = isEdit ? form.dataset.updateUrl.replace(':id', idEl.value) : form.dataset.storeUrl
    const method = isEdit ? "PUT" : "POST"
    const formData = new FormData(form)

    try{
      const res = await fetch(url, {
        method,
        headers: {'Accept': 'application/json'},
        body: formData
      })

      const data = await res.json()
      console.log(data)
      if(data.errors){
        showValidation(data.errors)
        return
      }

      if(!res.ok){
        showAlert('error', 'Error', "Terjadi kesalah pada sister!", () => {
          closeModal()
        })

        return
      }

      showAlert('success', 'Berhasil', data.message, () => {
        closeModal()
      })

      initTabelTA()
    }catch(err){
      console.error(err)
    }
  })

  tbody.addEventListener('click', async (e) => {
    const btnEdit = e.target.closest('[data-action="edit-tahun-ajaran"]')
    if(!btnEdit) return
    
    const id = btnEdit.dataset.id
    const url = tahunAjaranRoutes.show.replace('__ID__', id)

    try{
      const res = await fetch(url, {
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

      idEl.value = data.tahun_ajaran.id
      nama.value = data.tahun_ajaran.nama
      tanggal_mulai.value = data.tahun_ajaran.tanggal_mulai
      tanggal_selesai.value = data.tahun_ajaran.tanggal_selesai

      clearValidation()
      openModal()
    }catch(err){
      console.error(err)

      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Terjadi kesalahan pada server.'
      })
    }
  })
}

function toggleAktivasi(){
  document.addEventListener('click', async (e) => {
    const button = e.target.closest('[data-action="toggle-aktivasi-tahun-ajaran"]')
    if(!button) return

    const id = button.dataset.id
    
    showConfirm(
      'Ubah Status Aktivasi?',
      'Status aktivasi Tahun Ajaran akan diubah.',
      async () => {
        const url = tahunAjaranRoutes.activation.replace('__ID__', id)
        const csrf = document.querySelector('meta[name="csrf-token"]').content
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

          initTabelTA()
        }catch(err){
          console.error(err)

          showAlert('error', 'Gagal', 'Terjadi kesalah pada server.');
        }
      }
    )
  })
}