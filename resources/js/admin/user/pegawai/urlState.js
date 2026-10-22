import { state } from "./state"

export function getQuery(){
  const params = new URLSearchParams()

  if(state.keyword){
    params.set('keyword', state.keyword)
  }
  
  if(state.page > 1){
    params.set('page', state.page)
  }

  return params.toString()
}

export function updateURL(){ 
  const params = new URLSearchParams()

  if(state.keyword){
    params.set('keyword', state.keyword)
  }

  if(state.page > 1){
    params.set('page', state.page)
  }

  const query = params.toString()

  history.replaceState(null, '', query ? `${pegawaiRoutes.index}?${query}` : pegawaiRoutes.index)
}

export function getReturnURL() {
  const query = getQuery()

  return query
    ? `${pegawaiRoutes.index}?${query}`
    : pegawaiRoutes.index
}