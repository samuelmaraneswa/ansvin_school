document.addEventListener('click', (e) => {
  const btnToggleMenu = e.target.closest('[data-action="toggle-menu"]')

  if(btnToggleMenu){
    const menuWrapper = btnToggleMenu.closest('[data-menu-wrapper]')
    if(!menuWrapper) return

    const menu = menuWrapper.querySelector('[data-menu]')
    if(!menu) return

    document.querySelectorAll('[data-menu-wrapper]').forEach(wrapper => {
      if(wrapper !== menuWrapper){
        const otherMenu = wrapper.querySelector('[data-menu]')
        const otherIcon = wrapper.querySelector('[data-action="toggle-menu"] i')

        otherMenu.classList.add('hidden')

        if(otherIcon){
          otherIcon.classList.remove('fa-chevron-up')
          otherIcon.classList.add('fa-chevron-down')
        }
      }
    })

    const icon = menuWrapper.querySelector('i')
    if(icon){
      icon.classList.toggle('fa-chevron-down')
      icon.classList.toggle('fa-chevron-up')
    }

    menu.classList.toggle('hidden')
    return
  }

  const btnToggleSubMenu = e.target.closest('[data-action="toggle-submenu"]')

  if(btnToggleSubMenu){
    const subMenuWrapper = btnToggleSubMenu.closest('[data-submenu-wrapper]')
    if(!subMenuWrapper) return 

    const subMenu = subMenuWrapper.querySelector('[data-submenu]')
    if(!subMenu) return

    subMenu.classList.toggle('hidden')
    
    const icon = btnToggleSubMenu.querySelector('i')
    if(icon){
      icon.classList.toggle('fa-chevron-down')
      icon.classList.toggle('fa-chevron-up')
    }

    return;
  }
  
  const insideMenuWrapper = e.target.closest('[data-menu-wrapper]')
  if(!insideMenuWrapper){
    document.querySelectorAll('[data-menu-wrapper]').forEach(wrapper => {
      const menu = wrapper.querySelector('[data-menu]')
      const icon = wrapper.querySelector('[data-action="toggle-menu"] i')
      
      menu.classList.add('hidden')

      if(icon){
        icon.classList.remove('fa-chevron-up')
        icon.classList.add('fa-chevron-down')
      }
    })
  }
})