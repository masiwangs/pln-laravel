async function updatekontrak(kontrak_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}`, data)
    callback(response.data)
}

// ===== JASA =====
async function jasaSaveService(kontrak_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}/jasa`, data)
    callback(response.data)
}

async function jasaUpdateService(kontrak_id, jasa_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}/jasa/${jasa_id}`, data)
    callback(response.data)
}

async function jasaDeleteService(kontrak_id, jasa_id, callback) {
    await axios.delete(`/kontrak/${kontrak_id}/jasa/${jasa_id}`)
    callback(jasa_id)
}

// ===== MATERIAL =====
async function materialSaveService(kontrak_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}/material`, data)
    callback(response.data)
}

async function materialUpdateService(kontrak_id, material_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}/material/${material_id}`, data)
    callback(response.data)
}

async function materialDeleteService(kontrak_id, material_id, callback) {
    await axios.delete(`/kontrak/${kontrak_id}/material/${material_id}`)
    callback(material_id)
}

// ===== FILE =====
async function fileSaveService(kontrak_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}/file`, data)
    callback(response.data)
}

async function fileDeleteService(kontrak_id, file_id, callback) {
    await axios.delete(`/kontrak/${kontrak_id}/file/${file_id}`)
    callback(file_id)
}

// ===== AMANDEMEN =====
async function amandemenSaveService(kontrak_id, data, callback) {
    const response = await axios.post(`/kontrak/${kontrak_id}/amandemen`, data)
    callback(response.data)
}