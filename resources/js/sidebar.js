import { initFunctions } from "./initFunctions"

updateActiveMenu(window.location.href)
document.addEventListener('click', async (e) => {

  const link = e.target.closest('[data-action="navigate-admin"]')
  if(!link) return

  e.preventDefault()

  navigateAdmin(link.href)
})

window.addEventListener('popstate', () => {
  navigateAdmin(window.location.href, false)
})

function updateActiveMenu(url){
  const links = document.querySelectorAll('[data-action="navigate-admin"]')
  const currentPath = new URL(url, window.location.origin).pathname

  links.forEach(link => {
    const linkPath = new URL(link.href, window.location.origin).pathname

    link.classList.remove('bg-gray-900', 'text-white')

    if(linkPath === currentPath || (linkPath !== '/admin' && currentPath.startsWith(linkPath + '/'))){
      link.classList.add('bg-gray-900', 'text-white')
    }
  })

  document.querySelectorAll('[data-submenu-wrapper]').forEach(wrapper => {
    const activeLink = wrapper.querySelector(
      '[data-action="navigate-admin"].bg-gray-900'
    )

    const submenu = wrapper.querySelector('[data-submenu]')
    const icon = wrapper.querySelector('[data-action="toggle-submenu"] i')

    if (activeLink) {
      submenu?.classList.remove('hidden')
      icon?.classList.remove('fa-chevron-down')
      icon?.classList.add('fa-chevron-up')
    }
  })
}

function closeMobileMenu() {
  const menuWrapper = document
    .querySelector('[data-action="toggle-menu"]')
    ?.closest('[data-menu-wrapper]')

  if (!menuWrapper) return

  const menu = menuWrapper.querySelector('[data-menu]')
  menu?.classList.add('hidden')

  menuWrapper.querySelectorAll('[data-submenu-wrapper]').forEach(wrapper => {
    const submenu = wrapper.querySelector('[data-submenu]')
    const icon = wrapper.querySelector('[data-action="toggle-submenu"] i')
    const activeLink = wrapper.querySelector(
      '[data-action="navigate-admin"].bg-gray-900'
    )

    if (activeLink) {
      submenu?.classList.remove('hidden')
    } else {
      submenu?.classList.add('hidden')

      icon?.classList.remove('fa-chevron-up')
      icon?.classList.add('fa-chevron-down')
    }
  })
}

export async function navigateAdmin(url, push = true){
  const adminContent = document.querySelector('[data-content="admin"]')
  if(!adminContent) return

  const res = await fetch(url)
  const html = await res.text()

  // console.log(html)
  // return

  const parser = new DOMParser()
  const doc = parser.parseFromString(html, 'text/html');

  const newContent = doc.querySelector('[data-content="admin"]')
  if(!newContent) return

  adminContent.innerHTML = newContent.innerHTML

  if(push){
    history.pushState(null, '', url)
  }

  updateActiveMenu(url)

  initFunctions()

  closeMobileMenu()
}

