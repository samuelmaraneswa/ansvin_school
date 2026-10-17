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
}