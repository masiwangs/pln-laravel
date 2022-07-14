async function skkiUpdateService(skki_id, data, callback) {
    const response = await axios.post(`/skki/${skki_id}`, data)
    callback(response.data)
}

// ===== PRK =====
function addPrkService(skki_id, data, callback) {
    axios.post(`/skki/${skki_id}/prk`, data)
    .then(res => {
        callback(res.data)
    })
    .catch(e => {
        alert(e.response.data.message)
    })
}
function deletePrkService(skki_id, data, callback) {
    axios.delete(`/skki/${skki_id}/prk/${data.prk}`, data)
    .then(res => {
        callback(data)
    })
    .catch(e => {
        alert(e.response.data.message)
    })
}
function importJasaPrkService(skki_id, data, callback) {
    axios.post(`/skki/${skki_id}/prk/${data.prk}/import-jasa`)
    .then(res => {
        // callback(res.data)
        location.reload()
    })
    .catch(e => {
        alert(e.response.data.message)
    })
}
function importMaterialPrkService(skki_id, data, callback) {
    axios.post(`/skki/${skki_id}/prk/${data.prk}/import-material`)
    .then(res => {
        // callback(res.data)
        location.reload()
    })
    .catch(e => {
        alert(e.response.data.message)
    })
}
// ===== JASA =====
async function jasaSaveService(skki_id, data, callback) {
    const response = await axios.post(`/skki/${skki_id}/jasa`, data)
    callback(response.data)
}

async function jasaUpdateService(skki_id, jasa_id, data, callback) {
    const response = await axios.post(`/skki/${skki_id}/jasa/${jasa_id}`, data)
    callback(response.data)
}

async function jasaDeleteService(skki_id, jasa_id, callback) {
    await axios.delete(`/skki/${skki_id}/jasa/${jasa_id}`)
    callback(jasa_id)
}

async function jasaImportFromPRKService(skki_id, callback) {
    const response = await axios.post(`/skki/${skki_id}/jasa/import/prk`)
    callback(response.data);
}

// ===== MATERIAL =====
async function materialSaveService(skki_id, data, callback) {
    const response = await axios.post(`/skki/${skki_id}/material`, data)
    callback(response.data)
}

async function materialUpdateService(skki_id, material_id, data, callback) {
    const response = await axios.post(`/skki/${skki_id}/material/${material_id}`, data)
    callback(response.data)
}

async function materialDeleteService(skki_id, material_id, callback) {
    await axios.delete(`/skki/${skki_id}/material/${material_id}`)
    callback(material_id)
}

async function materialImportFromPRKService(skki_id, callback) {
    const response = await axios.post(`/skki/${skki_id}/material/import/prk`)
    callback(response.data);
}

// ===== FILE =====
async function fileSaveService(skki_id, data, callback) {
    const response = await axios.post(`/skki/${skki_id}/file`, data)
    callback(response.data)
}

async function fileDeleteService(skki_id, file_id, callback) {
    await axios.delete(`/skki/${skki_id}/file/${file_id}`)
    callback(file_id)
}

// ====== DELETE PROJECT =====
async function deleteProjectService(skki_id) {
    const response = await axios.delete(`/skki/${skki_id}`);
    $('#deleteProjectBtn').attr('disabled', false);
    if(response.data.success) {
        return window.location.href = '/skki';
    } 
    
    alert(response.data.message)
}