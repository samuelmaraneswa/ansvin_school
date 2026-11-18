import { initPagination } from "./pagination"

export async function initTabelTA(){
  const tbody = document.querySelector('[data-admin-tahun-ajaran-table]')
  if(!tbody) return

  const params = new URLSearchParams(window.location.search)
  const url = `${tahunAjaranRoutes.index}?${params.toString()}`
  try{
    const res = await fetch(url, {
      headers: {
        'X-requested-With': 'XMLHttpRequest'
      }
    })

    const data = await res.json()
    // console.log(data)

    const currentURL = new URL(window.location.href)
    // console.log(currentURL)
    data.pagination.current_page > 1 
      ? currentURL.searchParams.set('page', data.pagination.current_page)
      : currentURL.searchParams.delete('page')

    window.history.replaceState(null, '', currentURL)

    if(!data.tahun_ajaran.length){
      tbody.innerHTML = `
        <tr>
          <td colspan="4" class="text-center py-8 text-gray-500">
            Belum ada data Tahun Ajaran.
          </td>
        </tr>
      `
      return;
    }

    tbody.innerHTML = data.tahun_ajaran.map((item, index) => `
      <tr class="odd:bg-white even:bg-gray-200">
        <td class="px-4 py-2">${(data.pagination.current_page - 1) * data.pagination.limit + index + 1}</td>
        <td class="px-4 py-2">${item.nama}</td>

        <td class="px-4 py-2">
          <span class="${Number(item.is_active) === 1
            ? 'bg-green-100 text-green-700'
            : 'bg-red-100 text-red-700'} px-2 py-1 rounded text-sm">
            ${Number(item.is_active) === 1 ? 'Aktif' : 'Nonaktif'}
          </span>
        </td>

        <td class="px-4 py-2 flex items-center gap-3">

          <button class="bg-green-600 px-2 py-1 hover:bg-green-700 text-white rounded cursor-pointer" data-action="edit-tahun-ajaran" data-id="${item.id}">
            Edit
          </button>

          <button
            type="button"
            data-action="toggle-aktivasi-tahun-ajaran"
            data-id="${item.id}"
            data-active="${item.is_active}"
            class="${Number(item.is_active) === 1
              ? 'bg-red-600 hover:bg-red-700'
              : 'bg-green-600 hover:bg-green-700'} text-white px-2 py-1 rounded cursor-pointer">
            ${Number(item.is_active) === 1 ? 'Nonaktifkan' : 'Aktifkan'}
          </button>

        </td>

      </tr>
    `).join('')

    initPagination(data.pagination, initTabelTA)
  }catch(err){
    console.error(err)
  }
}