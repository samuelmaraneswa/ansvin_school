export function initHeaderSearchMobile(){
  document.addEventListener('click', (e) => {
    const toggleSearchBtn = e.target.closest('[data-action="toggle-mobile-search"]')
    if(toggleSearchBtn){
      const mobileSearch = document.querySelector('[data-mobile-search]')
      mobileSearch.classList.remove('hidden')
    }

    const closeSearchBtn = e.target.closest('[data-action="close-mobile-search"]')
    if(closeSearchBtn){
      const mobileSearch = document.querySelector('[data-mobile-search]')
      mobileSearch.classList.add('hidden')
    }
  })
}