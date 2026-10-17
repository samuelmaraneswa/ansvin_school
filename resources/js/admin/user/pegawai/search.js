import { loadPegawai } from "./loadData"
import { state } from "./state"
import { updateURL } from "./urlState"

export function initSearchPegawai(){
  const form = document.querySelector('[data-search-form="pegawai"]')
  if(!form) return

  const input = form.querySelector('[data-search-input]')
  const suggestion = form.querySelector('[data-search-suggestion]')
  if(!input || !suggestion) return

  const iconX = form.querySelector('[data-action="clear-input"]')
  
  input.value = state.keyword

  if(state.keyword){
    iconX.classList.remove('hidden')
  }

  let activeIndex = -1

  function clearSuggestion(){
    suggestion.classList.add('hidden')
    suggestion.innerHTML = ''
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault()

    state.keyword = input.value.trim()
    state.page = 1

    updateURL()
    clearSuggestion()
    loadPegawai()
  })

  input.addEventListener('input', async () => {
    const keyword = input.value.trim()
    if(!keyword){
      iconX.classList.add('hidden')
      clearSuggestion()

      state.keyword = ''
      state.page = 1

      updateURL()
      loadPegawai()

      return
    }

    iconX.classList.remove('hidden')

    const url = `${pegawaiRoutes.suggestion}?keyword=${encodeURIComponent(keyword)}`
    
    try{
      const res = await fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
      })

      const data = await res.json()
      
      if (input.value.trim() !== keyword) return
      
      if(data.users.length === 0){
        suggestion.innerHTML = `
          <div class="px-3 py-2 text-gray-500 italic">
            Data pegawai tidak ada!
          </div>
        `

        suggestion.classList.remove('hidden')
        return
      }

      suggestion.innerHTML = data.users.map(item => `
        <div class="px-3 py-2 cursor-pointer hover:bg-gray-100" data-keyword="${item.user.name}">
          ${item.user.name}
        </div>  
      `).join('')

      suggestion.classList.remove('hidden')

    }catch(err){
      console.error(err)
    }
  })

  suggestion.addEventListener('click', (e) => {
    const item = e.target.closest('[data-keyword]')
    if(!item) return

    const keyword = item.dataset.keyword

    input.value = keyword

    state.keyword = keyword
    state.page = 1

    updateURL()
    clearSuggestion()
    loadPegawai()
  })

  input.addEventListener('keydown', (e) => {
    const items = suggestion.querySelectorAll('[data-keyword]')
    if (!items.length) return

    if (e.key === 'ArrowDown') {
      e.preventDefault()

      activeIndex = (activeIndex + 1) % items.length

      items.forEach(item => item.classList.remove('bg-gray-100'))
      items[activeIndex].classList.add('bg-gray-100')

      items[activeIndex].scrollIntoView({
        block: 'nearest'
      })

      input.value = items[activeIndex].dataset.keyword
    }

    if (e.key === 'ArrowUp') {
      e.preventDefault()

      activeIndex = (activeIndex - 1 + items.length) % items.length

      items.forEach(item => item.classList.remove('bg-gray-100'))
      items[activeIndex].classList.add('bg-gray-100')

      items[activeIndex].scrollIntoView({
        block: 'nearest'
      })

      input.value = items[activeIndex].dataset.keyword
    }

    if(e.key === 'Escape'){
      activeIndex = -1
      suggestion.classList.add('hidden')
      suggestion.innerHTML = ''
    }
  })

  iconX.addEventListener('click', () => {
    input.value = ''
    state.keyword = ''
    state.page = 1

    updateURL()

    activeIndex = -1
    clearSuggestion()
    iconX.classList.add('hidden')
    input.focus()

    loadPegawai()
  })
}