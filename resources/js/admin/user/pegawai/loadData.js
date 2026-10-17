import { initPagination } from "./pagination";
import { state } from "./state";
import { renderTable } from "./table";
import { updateURL } from "./urlState";

export async function loadPegawai(){
  const paramsUrl = new URLSearchParams(location.search);

  state.page = Number(paramsUrl.get('page')) || 1;
  state.keyword = paramsUrl.get('keyword') || '';

  const params = new URLSearchParams({
    page: state.page,
    keyword: state.keyword
  })

  const url = `${pegawaiRoutes.index}?${params}`
  
  const res = await fetch(url, {
    headers: {
      'X-requested-With': 'XMLHttpRequest'
    }
  })

  const data = await res.json()
  // console.log(data)

  if (state.page !== data.pagination.current_page) {
    state.page = data.pagination.current_page;
    updateURL();
  }

  renderTable(data)
  initPagination(data, loadPegawai)
}