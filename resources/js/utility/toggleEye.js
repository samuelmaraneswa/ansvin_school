const eyes = document.querySelectorAll('[data-action="toggle-eye"]')
eyes.forEach(eye => {
  eye.addEventListener('click', () => {
    const wrapper = eye.closest(".relative")
    const input = wrapper.querySelector('input')
    const icon = eye.querySelector('i')

    if(input.type === 'password'){
      input.type = 'text'
      icon.classList.replace('fa-eye-slash', 'fa-eye')
    }else{
      input.type = 'password'
      icon.classList.replace('fa-eye', 'fa-eye-slash')
    }
  })
})