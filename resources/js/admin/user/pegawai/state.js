const params = new URLSearchParams(location.search)

export const state = {
  keyword: params.get('keyword') || '',
  page: Number(params.get('page')) || 1
}