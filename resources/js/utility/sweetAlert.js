export function showAlert(icon, title, text, callback = null) {
  Swal.fire({
    icon,
    title,
    text,
    timer: 1500,
    confirmButtonText: 'OK'
  }).then(() => {
    if (callback) callback()
  })
}

export function showConfirm(title, text, callback) {
  Swal.fire({
    icon: 'warning',
    title,
    text,
    showCancelButton: true,
    confirmButtonText: 'Ya, lanjut',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed && callback) {
      callback()
    }
  })
}