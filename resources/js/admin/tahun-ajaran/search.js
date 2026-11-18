import { initTabelTA } from "./table-tajaran.js"

export function initSearchTA(){
  const form = document.querySelector('[data-search-form="tahun-ajaran"]')
  if(!form) return

  const input = form.querySelector('[data-search-input]')
  const iconX = form.querySelector('[data-action="clear-input"]')
  const suggestion = form.querySelector('[data-search-suggestion]')
  if(!input || !iconX || !suggestion) return

  const params = new URLSearchParams(window.location.search)
  const keyword = params.get('keyword') || ''

  input.value = keyword

  if(keyword){
    iconX.classList.remove('hidden')
  }

  let activeIndex = -1

  form.addEventListener('submit', (e) => {
    e.preventDefault()

    const keyword = input.value.trim()
    
    const url = new URL(window.location.href)
    keyword ? url.searchParams.set('keyword', keyword) : url.searchParams.delete('keyword')

    url.searchParams.delete('page')
    
    window.history.pushState({}, '', url)

    suggestion.classList.add('hidden')

    initTabelTA()
  })

  input.addEventListener('input', async () => {
    iconX.classList.remove('hidden')

    const keyword = input.value.trim()
    if(!keyword){
      iconX.classList.add('hidden')
      suggestion.classList.add('hidden')
      return
    }

    suggestion.classList.remove('hidden')

    const params = new URLSearchParams({keyword})
    const url = `${tahunAjaranRoutes.suggestion}?${params.toString()}`
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
          text: 'Terjadi kesalahan pada server.'
        })

        return
      }

      if(data.tahun_ajaran.length === 0){
        suggestion.classList.remove('hidden')

        suggestion.innerHTML = `
          <div class="text-gray-400 px-3 py-2">
            Data Tahun Ajaran tidak ada.
          </div>
        `
        return
      }

      if(input.value.trim() !== keyword) return

      suggestion.innerHTML = data.tahun_ajaran.map(item => {
        const nama = item.nama
        const regex = new RegExp(`(${keyword})`, 'ig')

        const highlightedNama = nama.replace(regex, '<strong>$1</strong>')
        return `
          <div class="px-3 py-2 cursor-pointer hover:bg-gray-100 border-b border-gray-300" data-keyword="${item.nama}">
            ${highlightedNama}
          </div>
        `
      }).join('')
    }catch(err){
      console.error(err)
    }
  })

  iconX.addEventListener('click', () => {
    input.value = ''
    input.focus()
    iconX.classList.add('hidden')
    suggestion.classList.add('hidden')

    const url = new URL(window.location.href)
    url.searchParams.delete('keyword')
    url.searchParams.delete('page')

    history.pushState(null, '', url)

    initTabelTA()
  })

  suggestion.addEventListener('click', (e) => {
    const item = e.target.closest('[data-keyword]')
    if(!item) return

    const keyword = item.dataset.keyword

    input.value = keyword
    suggestion.classList.add('hidden')

    const url = new URL(window.location.href)
    url.searchParams.set('keyword', keyword)
    url.searchParams.delete('page')

    history.pushState(null, '', url)

    initTabelTA()
  })

  input.addEventListener('keydown', (e) => {
    const items = suggestion.querySelectorAll('[data-keyword]')
    if(!items) return

    if(e.key === 'ArrowDown'){
      e.preventDefault()

      activeIndex = (activeIndex + 1) % items.length
      
      items.forEach(item => item.classList.remove('bg-gray-100'))
      items[activeIndex].classList.add('bg-gray-100')

      items[activeIndex].scrollIntoView({
        block: 'nearest'
      })

      input.value = items[activeIndex].dataset.keyword
    }

    if(e.key === 'ArrowUp'){
      e.preventDefault()

      activeIndex = (activeIndex - 1 + items.length) % items.length

      items.forEach(item => item.classList.remove('bg-gray-100'))
      items[activeIndex].classList.add('bg-gray-100')

      items[activeIndex].scrollIntoView({block: 'nearest'})

      input.value = items[activeIndex].dataset.keyword
    }

    if(e.key === 'Escape'){
      activeIndex = -1
      suggestion.classList.add('hidden')
      suggestion.innerHTML = ''
    }
  })

  document.addEventListener('click', (e) => {
    if(!suggestion.contains(e.target) && !input.contains(e.target)){
      suggestion.classList.add('hidden')
      activeIndex = -1
    }
  })
}