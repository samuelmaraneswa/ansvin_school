import { getQuery } from "./urlState"

export function renderTable(data){
  const tbody = document.querySelector('[data-admin-pegawai-table]')
  if(!tbody) return

  const query = getQuery()

  tbody.innerHTML = data.pegawai.map((peg, index) => {
    
    const showUrl = pegawaiRoutes.show.replace('__ID__', peg.id);
    const editUrl = pegawaiRoutes.edit.replace('__ID__', peg.id);
    const destroyUrl = pegawaiRoutes.destroy.replace('__ID__', peg.id);

    return `
    <tr class="odd:bg-white even:bg-gray-100">
      <td class="px-4 py-2">${(data.pagination.current_page - 1) * data.pagination.limit + index + 1}</td>
      <td class="px-4 py-2">${peg.user.name}</td>
      <td class="px-4 py-2">${peg.user.login_id}</td>
      <td class="px-4 py-2 flex items-center gap-4">
        <a href="${showUrl}" class="px-3 py-1 bg-gray-200 cursor-pointer hover:bg-gray-300 text-black rounded" data-pegawai-id="${peg.id}" data-action="navigate-admin">
          Detail
        </a> 

        <a href="${editUrl}" class="px-3 py-1 bg-green-500 cursor-pointer hover:bg-green-700 text-white rounded" data-action="navigate-admin" data-pegawai-id="${peg.id}">Edit</a>

        <button data-delete-url="${destroyUrl}" data-delete-pegawai="${peg.id}" class="px-3 py-1 bg-red-500 hover:bg-red-700 text-white rounded cursor-pointer">Delete</button>

      </td>
    </tr>
  `}).join('');
}