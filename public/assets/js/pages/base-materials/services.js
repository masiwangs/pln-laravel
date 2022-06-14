// // ===== BASE MATERIAL =====
async function baseMaterialSaveService(data, callback) {
    const response = await axios.post('/database/material', data)
    callback(response.data)
}

async function baseMaterialUpdateService(base_material_id, data, callback) {
    const response = await axios.post(`/database/material/${base_material_id}`, data)
    callback(response.data)
}

async function baseMaterialDeleteService(base_material_id, callback) {
    await axios.delete(`/database/material/${base_material_id}`)
    callback(base_material_id)
}