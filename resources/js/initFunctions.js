import { CRUDTahunAjaran } from "./admin/tahun-ajaran/crud"
import { initSearchTA } from "./admin/tahun-ajaran/search"
import { initTabelTA } from "./admin/tahun-ajaran/table-tajaran"
import { initCRUDPegawai } from "./admin/user/pegawai/crud"
import { loadPegawai } from "./admin/user/pegawai/loadData"
import { initSearchPegawai } from "./admin/user/pegawai/search"

export function initFunctions(){
  // pegawai
  if (document.querySelector('[data-form-pegawai]') ||
    document.querySelector('[data-admin-pegawai-table]')) {
    initCRUDPegawai()
  }

  if (document.querySelector('[data-admin-pegawai-table]')) {
    loadPegawai()
    initSearchPegawai()
  }

  // tahun-ajaran
  CRUDTahunAjaran()
  initTabelTA()
  initSearchTA()
}