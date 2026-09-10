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
}

export async function navigateAdmin(url, push = true){
  const adminContent = document.querySelector('[data-content="admin"]')
  if(!adminContent) return

  const res = await fetch(url)
  const html = await res.text()

  const parser = new DOMParser()
  const doc = parser.parseFromString(html, 'text/html');

  const newContent = doc.querySelector('[data-content="admin"]')
  if(!newContent) return

  adminContent.innerHTML = newContent.innerHTML

  if(push){
    history.pushState(null, '', url)
  }

  updateActiveMenu(url)
}

