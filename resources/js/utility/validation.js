export function clearValidation(){
  document.querySelectorAll('[data-error-field]').forEach(el => {
    el.textContent = ''
  })
}

export function showValidation(errors){
  Object.entries(errors).forEach(([field, message]) =>{
    const el = document.querySelector(`[data-error-field="${field}"]`)
    if(el){
      el.textContent = message
    }
  })
}

export function toggleBtn(btn, isClicked, text = "Simpan"){
  if(isClicked){
    btn.disabled = true
    btn.textContent = "Loading..."
    btn.style.cursor = "not-allowed"
  }else{
    btn.disabled = false
    btn.textContent = text
    btn.style.cursor = "pointer"
  }
}