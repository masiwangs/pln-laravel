async function updatePelaksanaan(pelaksanaan_id, data, callback) {
    const response = await axios.post(`/pelaksanaan/${pelaksanaan_id}`, data)
    callback(response.data)
}

// ===== JASA =====
async function jasaSaveService(pelaksanaan_id, data, callback) {
    const response = await axios.post(`/pelaksanaan/${pelaksanaan_id}/jasa`, data)
    callback(response.data)
}

async function jasaUpdateService(pelaksanaan_id, jasa_id, data, callback) {
    const response = await axios.post(`/pelaksanaan/${pelaksanaan_id}/jasa/${jasa_id}`, data)
    callback(response.data)
}

async function jasaDeleteService(pelaksanaan_id, jasa_id, callback) {
    const response = await axios.delete(`/pelaksanaan/${pelaksanaan_id}/jasa/${jasa_id}`)
    callback(response.data)
}

async function jasaRabService(pelaksanaan_id, callback){
    const response = await axios.get(`/pelaksanaan/${pelaksanaan_id}/rab/jasa`)
    callback(response.data)
}

// ===== MATERIAL =====
async function materialSaveService(pelaksanaan_id, data, callback) {
    const response = await axios.post(`/pelaksanaan/${pelaksanaan_id}/material`, data)
    callback(response.data)
}

async function materialUpdateService(pelaksanaan_id, material_id, data, callback) {
    const response = await axios.post(`/pelaksanaan/${pelaksanaan_id}/material/${material_id}`, data)
    callback(response.data)
}

async function materialDeleteService(pelaksanaan_id, material_id, callback) {
    await axios.delete(`/pelaksanaan/${pelaksanaan_id}/material/${material_id}`)
    callback(material_id)
}

async function materialRabService(pelaksanaan_id, callback) {
    const response = await axios.get(`/pelaksanaan/${pelaksanaan_id}/rab/material`)
    callback(response.data)
}

async function materialStokService(pelaksanaan_id, callback) {
    const response = await axios.get(`/pelaksanaan/${pelaksanaan_id}/stok/material`)
    callback(response.data)
}

// ===== FILE =====
async function fileSaveService(pelaksanaan_id, data, callback) {
    const response = await axios.post(`/pelaksanaan/${pelaksanaan_id}/file`, data)
    callback(response.data)
}

async function fileDeleteService(pelaksanaan_id, file_id, callback) {
    await axios.delete(`/pelaksanaan/${pelaksanaan_id}/file/${file_id}`)
    callback(file_id)
}