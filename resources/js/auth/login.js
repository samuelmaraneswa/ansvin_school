document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', (e) => {
    const toggleEye = e.target.closest('[data-action="toggle-eye"]')
    if(toggleEye){
      const password = document.querySelector('[data-login-password]')
      if(!password) return;

      password.type = password.type === 'text' ? 'password' : 'text';

      const icon = toggleEye.querySelector('i')
      icon.classList.toggle('fa-eye-slash')
      icon.classList.toggle('fa-eye')

      return;
    }
  })

  const form = document.querySelector('[data-form-login]')
  const submit = document.getElementById('btnLogin')
  const login_id = document.querySelector('[data-login-login_id]')
  const password = document.querySelector('[data-login-password]')
  const textError = document.querySelector('[data-login-error]')

  if(!form || !submit || !login_id || !password || !textError) return

  login_id.focus();

  function clearValidation(){
    document.querySelectorAll('[data-error-field]').forEach(el => {
      el.textContent = ''
    })
  }

  function toggleBtnSubmit(isClicked){
    if(isClicked){
      submit.style.cursor = 'not-allowed'
      submit.disabled = true
      submit.textContent = 'Loading...'
    }else{
      submit.style.cursor = 'pointer'
      submit.disabled = false
      submit.textContent = 'Login'
    }
  }

  function showValidation(errors){
    Object.entries(errors).forEach(([field, message]) => {
      const el = document.querySelector(`[data-error-field="${field}"]`)
      if(el)
        el.textContent = message
    }) 
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault()

    toggleBtnSubmit(true)
    clearValidation()
    textError.textContent = ''

    const errors = {}
    if(!login_id.value.trim()){
      errors.login_id = "Login Id wajib di isi!"
    }
    
    if(!password.value.trim()){
      errors.password = "Password wajib di isi!"
    }

    if(Object.keys(errors).length){
      showValidation(errors)
      toggleBtnSubmit(false)
      return
    }

    const formData = new FormData(form)
    try{
      const res = await fetch(form.action, {
        method: "POST",
        body: formData,
        headers: {
         'Accept': 'application/json'
        }
      })

      const data = await res.json()
      if(!res.ok){
        textError.textContent = data.message
        password.value = ''
        toggleBtnSubmit(false)
        return
      }
      
      window.location.href = data.redirect

    }catch(err){
      console.error(err)
      toggleBtnSubmit(false)
    }
  })
})