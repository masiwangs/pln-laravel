async function updatePRK(prk_id, data, callback) {
    const response = await axios.post(`/prk/${prk_id}`, data)
    callback(response.data)
}

// ===== JASA =====
async function jasaSaveService(prk_id, data, callback) {
    const response = await axios.post(`/prk/${prk_id}/jasa`, data)
    callback(response.data)
}

async function jasaUpdateService(prk_id, jasa_id, data, callback) {
    const response = await axios.post(`/prk/${prk_id}/jasa/${jasa_id}`, data)
    callback(response.data)
}

async function jasaDeleteService(prk_id, jasa_id, callback) {
    await axios.delete(`/prk/${prk_id}/jasa/${jasa_id}`)
    callback(jasa_id)
}

// ===== MATERIAL =====
async function materialSaveService(prk_id, data, callback) {
    const response = await axios.post(`/prk/${prk_id}/material`, data)
    callback(response.data)
}

async function materialUpdateService(prk_id, material_id, data, callback) {
    const response = await axios.post(`/prk/${prk_id}/material/${material_id}`, data)
    callback(response.data)
}

async function materialDeleteService(prk_id, material_id, callback) {
    await axios.delete(`/prk/${prk_id}/material/${material_id}`)
    callback(material_id)
}

// ===== FILE =====
async function fileSaveService(prk_id, data, callback) {
    const response = await axios.post(`/prk/${prk_id}/file`, data)
    callback(response.data)
}

async function fileDeleteService(prk_id, file_id, callback) {
    await axios.delete(`/prk/${prk_id}/file/${file_id}`)
    callback(file_id)
}