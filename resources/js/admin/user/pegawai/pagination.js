import { state } from "./state"
import { updateURL } from "./urlState"

export function initPagination(data, onChange){
  const pagination = document.querySelector('[data-pagination="pegawai"]')
  if(!pagination) return

  const {current_page, total_pages} = data.pagination
  
  const isFirstPage = current_page === 1
  const isLastPage = current_page === total_pages

  let option = ''

  for(let i = 1; i <= total_pages; i++){
    option += `
      <option value="${i}" ${i === current_page ? 'selected' : ''}>
        ${i}
      </option>
    `
  }

  if(total_pages <= 1){
    pagination.innerHTML = ''
    return
  }

  pagination.innerHTML = `
    <button id="prevPage" ${isFirstPage ? 'disabled' : ''} class="text-sm md:text-base text-white rounded px-2 py-1 ${isFirstPage ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-800 cursor-pointer hover:bg-gray-900'}">
      Prev
    </button>

    <div class="bg-white rounded overflow-hidden border border-gray-600 p-1">
      <select id="pageSelect" class="focus:outline-none cursor-pointer">
        ${option}
      </select>
      <span>/ ${total_pages}</span>
    </div>

    <button id="nextPage" ${isLastPage ? 'disabled' : ''} class="text-sm md:text-base text-white rounded px-2 py-1 ${isLastPage ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-800 cursor-pointer hover:bg-gray-900'}">
      Next
    </button>
  `

  const pageSelect = pagination.querySelector('#pageSelect')
  pageSelect.addEventListener('change', (e) => {
    state.page = Number(e.target.value)

    updateURL()
    onChange()
  })

  const prevPage = pagination.querySelector('#prevPage')
  const nextPage = pagination.querySelector('#nextPage')

  prevPage.addEventListener('click', () => {
    if(state.page <= 1) return

    state.page--

    updateURL()
    onChange()
  })

  nextPage.addEventListener('click', () => {
    if (state.page >= data.pagination.total_pages) return

    state.page++

    updateURL()
    onChange()
  })
}