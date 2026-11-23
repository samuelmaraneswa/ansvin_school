import { initPaginationSemester } from "./pagination"

export async function initTableSemester(){
  const formatTanggal = (tanggal) => {
    const [tahun, bulan, hari] = tanggal.split('-')

    const namaBulan = [
      'Jan', 'Feb', 'Mar', 'Apr',
      'Mei', 'Jun', 'Jul', 'Agu',
      'Sep', 'Okt', 'Nov', 'Des'
    ]

    return `${Number(hari)} ${namaBulan[Number(bulan) - 1]} ${tahun}`
  }

  const tbody = document.querySelector('[table-admin-semester]')
  if(!tbody) return

  const params = new URLSearchParams(window.location.search)
  const url = `${semesterRoutes.index}?${params.toString()}`
  // console.log(url)

  try{
    const res = await fetch(url, {
      headers: {'X-requested-With': 'XMLHttpRequest'}
    })
    
    const data = await res.json()
    // console.log(data)
    const currentURL = new URL(window.location.href)
    data.pagination.current_page > 1 
      ? currentURL.searchParams.set('page', data.pagination.current_page)
      : currentURL.searchParams.delete('page')

    window.history.replaceState(null, '', currentURL)

    if(!data.semester.length){
      tbody.innerHTML = `
        <tr>
          <td colspan="7" class="text-center py-8 text-gray-500">
            Belum ada data semester.
          </td>
        </tr>
      `
      return;
    }

    tbody.innerHTML = data.semester.map((item, index) => `
      <tr class="odd:bg-white even:bg-gray-200">
        <td class="px-4 py-2">${(data.pagination.current_page - 1) * data.pagination.limit + index + 1}</td>
        <td class="px-4 py-2">${item.tahun_ajaran.nama}</td>
        <td class="px-4 py-2">${item.nama}</td>
        <td class="px-4 py-2">${formatTanggal(item.tanggal_mulai)}</td>
        <td class="px-4 py-2">${formatTanggal(item.tanggal_selesai)}</td>

        <td class="px-4 py-2">
          <span class="${(Number(item.is_active) === 1) ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"} px-4 py-2 text-sm rounded">
            ${(Number(item.is_active) === 1) ? 'Aktif' : 'Nonaktif'}
          </span>
        </td>

        <td class="px-4 py-2">
          <button type="button" class="px-2 py-1 text-white rounded bg-green-600 hover:bg-green-500 cursor-pointer" action="edit-admin-semester" data-id=${item.id}>
            Edit
          </button>

          <button 
            type="button" 
            action="toggleAktivasiSemester"
            data-id="${item.id}"
            class="${(Number(item.is_active) === 1) ? "bg-red-600 hover:bg-red-500" : "bg-green-600 hover:bg-green-500"} rounded cursor-pointer py-1 px-2 text-white">
            ${(Number(item.is_active) === 1) ? "Nonaktifkan" : "Aktifkan"}
          </button>
        </td>
      <tr>
    `).join('')

    initPaginationSemester(data.pagination, initTableSemester)
  }catch(err){
    console.error(err)
  }
}