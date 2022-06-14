async function updatepengadaan(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}`, data)
    callback(response.data)
}

// ===== WBS JASA =====
async function jasaWbsSaveService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/wbs-jasa`, data)
    callback(response.data)
}
async function jasaWbsDestroyService(pengadaan_id, wbs_jasa_id, callback) {
    await axios.delete(`/pengadaan/${pengadaan_id}/wbs-jasa/${wbs_jasa_id}`)
    callback(wbs_jasa_id)
}
// ===== JASA =====
async function jasaSaveService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/jasa`, data)
    callback(response.data)
}

async function jasaUpdateService(pengadaan_id, jasa_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/jasa/${jasa_id}`, data)
    callback(response.data)
}

async function jasaDeleteService(pengadaan_id, jasa_id, callback) {
    await axios.delete(`/pengadaan/${pengadaan_id}/jasa/${jasa_id}`)
    callback(jasa_id)
}

async function jasaImportFromWbsService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/jasa/import/wbs-jasa`, data)
    callback(response.data)
}

async function jasaShowFromWbsService(pengadaan_id, skki_id, callback) {
    const response = await axios.get(`/pengadaan/${pengadaan_id}/jasa/skki?skki_id=${skki_id}`)
    callback(response.data)
}

// ===== WBS MATERIAL =====
async function materialWbsSaveService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/wbs-material`, data)
    callback(response.data)
}
async function materialWbsDestroyService(pengadaan_id, wbs_material_id, callback) {
    await axios.delete(`/pengadaan/${pengadaan_id}/wbs-material/${wbs_material_id}`)
    callback(wbs_material_id)
}
async function materialImportFromWbsService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/material/import/wbs-material`, data)
    callback(response.data)
}
async function materialShowFromWbsService(pengadaan_id, skki_id, callback) {
    const response = await axios.get(`/pengadaan/${pengadaan_id}/material/skki?skki_id=${skki_id}`)
    callback(response.data)
}
// ===== MATERIAL =====
async function materialSaveService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/material`, data)
    callback(response.data)
}

async function materialUpdateService(pengadaan_id, material_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/material/${material_id}`, data)
    callback(response.data)
}

async function materialDeleteService(pengadaan_id, material_id, callback) {
    await axios.delete(`/pengadaan/${pengadaan_id}/material/${material_id}`)
    callback(material_id)
}

// ===== FILE =====
async function fileSaveService(pengadaan_id, data, callback) {
    const response = await axios.post(`/pengadaan/${pengadaan_id}/file`, data)
    callback(response.data)
}

async function fileDeleteService(pengadaan_id, file_id, callback) {
    await axios.delete(`/pengadaan/${pengadaan_id}/file/${file_id}`)
    callback(file_id)
}

// ===== KONTRAK =====
async function kontrakSaveService(data, callback) {
    const response = await axios.post('/kontrak', data)
    callback(response.data)
}