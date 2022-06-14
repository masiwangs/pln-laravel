async function updatePembayaran(pembayaran_id, data, callback) {
    const response = await axios.post(`/pembayaran/${pembayaran_id}`, data)
    callback(response.data)
}

// ===== JASA =====
async function pembayaranSaveService(pembayaran_id, data, callback) {
    const response = await axios.post(`/pembayaran/${pembayaran_id}/pertahap`, data)
    callback(response.data)
}

async function pembayaranPertahapUpdateService(pembayaran_id, pertahap_id, data, callback) {
    const response = await axios.post(`/pembayaran/${pembayaran_id}/pertahap/${pertahap_id}`, data)
    callback(response.data)
}

async function pembayaranPertahapDeleteService(pembayaran_id, pertahap_id, callback) {
    await axios.delete(`/pembayaran/${pembayaran_id}/pertahap/${pertahap_id}`)
    callback(pertahap_id)
}

// ===== MATERIAL =====
async function materialTransaksiShowService(pembayaran_id, callback) {
    const response = await axios.get(`/pembayaran/${pembayaran_id}/transaksi/material`)
    callback(response.data)
}

// async function materialUpdateService(prk_id, material_id, data, callback) {
//     const response = await axios.post(`/prk/${prk_id}/material/${material_id}`, data)
//     callback(response.data)
// }

// async function materialDeleteService(prk_id, material_id, callback) {
//     await axios.delete(`/prk/${prk_id}/material/${material_id}`)
//     callback(material_id)
// }

// ===== FILE =====
async function fileSaveService(pembayaran_id, data, callback) {
    const response = await axios.post(`/pembayaran/${pembayaran_id}/file`, data)
    callback(response.data)
}

async function fileDeleteService(pembayaran_id, file_id, callback) {
    await axios.delete(`/pembayaran/${pembayaran_id}/file/${file_id}`)
    callback(file_id)
}