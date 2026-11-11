import { showAlert } from "../utility/sweetAlert"
import { clearValidation, showValidation, toggleBtn } from "../utility/validation"

document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector('[data-form-change_password]')
  if(!form) return

  const btn = form.querySelector('#btnChangePassword')
  if(!btn) return

  form.addEventListener('submit', async (e) => {
    e.preventDefault()

    const password_lama = form.querySelector('[data-changePassword-password_lama]')
    const password_baru = form.querySelector('[data-changePassword-password_baru]')
    const confirm_password = form.querySelector('[data-changePassword-confirm_password]')
    if(!password_lama || !password_baru || !confirm_password) return

    const errors = {}
    if(!password_lama.value.trim()){
      errors.password_lama = "Password Lama tidak boleh kosong"
    }

    if(!password_baru.value.trim()){
      errors.password_baru = "Password Baru tidak boleh kosong"
    }

    if(!confirm_password.value.trim()){
      errors.confirm_password = "Confirm Password tidak boleh kosong"
    }

    clearValidation()
    toggleBtn(btn, true, "Simpan")

    if(Object.keys(errors).length){
      showValidation(errors)
      toggleBtn(btn, false, "Simpan")
      return
    }

    const formData = new FormData(form)
    const url = changePasswordRoutes.update

    try{
      const res = await fetch(url, {
        method: "POST",
        body: formData
      })

      const data = await res.json()
      // console.log(data)
      if (!res.ok) {
        if (data.errors) {
          showValidation(data.errors)
        } else {
          showAlert('error', 'Gagal', data.message || 'Terjadi kesalahan')
        }

        return
      }

      showAlert('success', 'Berhasil', data.message, () => {
        window.location.href = data.redirect
      })
    }catch(err){
      console.error(err)
    } finally{
      toggleBtn(btn, false, "Simpan")
    }
  })
})