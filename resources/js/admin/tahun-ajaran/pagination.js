export function initPagination(data, onChange){
  const pagination = document.querySelector('[data-pagination="tahun_ajaran"]')
  if(!pagination) return

  const {current_page, total_pages} = data

  const isFirstPage = current_page === 1
  const isLastPage = current_page === total_pages

  if(total_pages <= 1){
    pagination.innerHTML = ''
    return
  }

  pagination.innerHTML = `
    <button id="prevBtn" ${isFirstPage ? 'disabled' : ''} class="border rounded py-1 px-2 ${isFirstPage ? 'bg-black/10 cursor-not-allowed text-gray-400' : 'bg-gray-700 hover:bg-gray-800 text-white cursor-pointer'}">
      Prev
    </button>

    <div class=" border rounded px-2 py-1">
      <select id="pageSelectTahunAjaran" class="cursor-pointer focus:outline-none">
        ${Array.from({ length: data.total_pages }, (_, i) => `
          <option value="${i + 1}" ${data.current_page === i + 1 ? 'selected' : ''}>
            ${i + 1}
          </option>
        `).join('')}
      </select>
      <span>/ ${data.total_pages}</span>
    </div>
    
    <button id="nextBtn" ${isLastPage ? 'disabled' : ''} class="border rounded py-1 px-2 ${isLastPage ? 'cursor-not-allowed bg-black/10 text-gray-400' : 'bg-gray-700 hover:bg-gray-800 text-white cursor-pointer'}">
      Next
    </button>
  `

  const pageSelect = pagination.querySelector('#pageSelectTahunAjaran')
  pageSelect.addEventListener('change', (e) => {
    const page = Number(e.target.value)
     
    const url = new URL(window.location.href)
    page > 1 ? url.searchParams.set('page', page) : url.searchParams.delete('page')
    
    window.history.pushState({}, '', url)
    
    onChange(page)
  })

  const prevBtn = pagination.querySelector('#prevBtn')
  prevBtn.addEventListener('click', () => {
    if(current_page > 1){
      const page = current_page - 1
      
      const url = new URL(window.location.href)
      page > 1 ? url.searchParams.set('page', page) : url.searchParams.delete('page')
      
      window.history.pushState({}, '', url)

      onChange(page)
    } 
  })
  
  const nextBtn = pagination.querySelector('#nextBtn')
  nextBtn.addEventListener('click', () => {
    if(current_page < total_pages){
      const page = current_page + 1
      
      const url = new URL(window.location.href)
      page > 1 ? url.searchParams.set('page', page) : url.searchParams.delete('page')
      
      window.history.pushState({}, '', url)

      onChange(page)
    }
  })
}