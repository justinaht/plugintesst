import { affApi, jsonToFormData } from './index.js'

export function getDashboardInfo(data) {
  return affApi.post('', jsonToFormData(Object.assign({ action: 'aff_get_dashboard_info'}, data)))
}
