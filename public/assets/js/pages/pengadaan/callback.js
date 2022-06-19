function callbackBaseMaterial(materials) {
    materials.forEach(material => {
        $('#materialList').append(`<option value=${material.id}>${material.normalisasi}: ${material.nama}`)
    });
}

// ===== MATERIAL =====
function callbackpengadaanChange({data}) {
    $('#nomorPengadaan').text(data.nodin);
    $('#namaPengadaan').text(data.nama);
    $('#lastUpdated').text(moment(data.done_at).format("YYYY-MM-DD HH:mm:ss"))
}

// ===== WBS JASA =====
function jasaWbsSaveCallback({data}) {
    $('#wbsJasaContainer').append(`\
        <div id="wbs-jasa-${data.id}" class="d-flex mb-2">\
            <input list="skkiList" type="text" id="first-name-vertical" class="form-control skki-field me-2" disabled value="${data.wbs_jasa}" placeholder="Masukkan nomor WBS Jasa">\
            <button class="btn btn-primary me-2 import-jasa" data-skki-id="${data.skki_id}">Import&nbsp;Jasa</button>\
            <button class="btn btn-primary me-2 show-jasa" data-skki-id="${data.skki_id}">Lihat&nbsp;Jasa</button>\
            <button class="btn btn-danger delete-wbs-jasa" data-skki-id="${data.skki_id}">Hapus</button>\
        </div>\
    `)
    $('input[name=wbs_jasa]').val('')
}

function jasaWbsDestroyCallback(id) {
    $('#wbs-jasa-'+id).remove();
}
// ===== JASA =====
function jasaModalOpenCallback(type, data = null) {
    switch (type) {
        case 'create':
            $('#jasaModalLabel').text('Buat Jasa Baru');
            $('#saveJasaBtn').show();
            $('#updateJasaBtn').hide();
            $('#jasaModal').modal('show');
            break;
        case 'update':
            $('#jasaModalLabel').text('Edit Jasa');
            $('#saveJasaBtn').hide();
            $('#updateJasaBtn').show();
            $('input[name=jasa_id]').val(data.id);
            $('input[name=jasa_nama]').val(data.nama);
            $('input[name=jasa_harga]').val(data.harga);
            $('#jasaModal').modal('show');
            break;
        
        default:
            alert('Error');
            break;
        }
}

function jasaSaveCallback({data}) {
    $('#jasaTbl>tbody').append(`<tr id="jasa-${data.id}">\
        <td>${data.nama}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.harga)}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editJasaBtn" data-id="${data.id}" data-nama="${data.nama}" data-harga="${data.harga}">Edit</button>\
                <button class="btn btn-danger deleteJasaBtn" data-id="${data.id}">Hapus</button>\
            </div>\
        </td>\
    </tr>`)
    $('#jasaModal').modal('hide');
}

function jasaUpdateCallback({data}) {
    $('#jasa-'+data.id).html(`\
        <td>${data.nama}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.harga)}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editJasaBtn" data-id="${data.id}" data-nama="${data.nama}" data-harga="${data.harga}">Edit</button>\
                <button class="btn btn-danger deleteJasaBtn" data-id="${data.id}">Hapus</button>\
            </div>\
        </td>\
    `)
    $('#jasaModal').modal('hide');
}
// hapus jasa
function jasaDeleteCallback(id) {
    $('#jasa-'+id).remove();
    $('#deleteModal').modal('hide');
}
// import jasa dari wbs
function jasaImportFromWbsCallback({data}) {
    data.forEach(jasa => {
        $('#jasaTbl>tbody').append(`<tr id="jasa-${jasa.id}">\
            <td>${jasa.nama}</td>\
            <td>Rp${new Intl.NumberFormat('id-ID').format(jasa.harga)}</td>\
            <td>\
                <div class="d-flex justify-content-end">\
                    <button class="btn btn-warning me-2 editJasaBtn" data-id="${jasa.id}" data-nama="${jasa.nama}" data-harga="${jasa.harga}">Edit</button>\
                    <button class="btn btn-danger deleteJasaBtn" data-id="${jasa.id}">Hapus</button>\
                </div>\
            </td>\
        </tr>`)
    })
    $('.import-jasa').attr('disabled', false)
}
// show jasa form wbs
function jasaShowFromWbsCallback({data}) {
    $('#jasaSkkiTbl>tbody').html('');
    data.forEach(jasa => {
        $('#jasaSkkiTbl>tbody').append(`<tr id="jasa-${jasa.id}">\
            <td>${jasa.nama}</td>\
            <td>Rp${new Intl.NumberFormat('id-ID').format(jasa.harga)}</td>\
        </tr>`)
    })
    $('#jasaSkkiModal').modal('show')
}

// ===== WBS MATERIAL =====
function materialWbsSaveCallback({data}) {
    $('#wbsMaterialContainer').append(`\
        <div id="wbs-material-${data.id}" class="d-flex mb-2">\
            <input list="skkiList" type="text" id="first-name-vertical" class="form-control skki-field me-2" disabled value="${data.wbs_material}" placeholder="Masukkan nomor WBS Material">\
            <button class="btn btn-primary me-2 import-material" data-skki-id="${data.skki_id}">Import&nbsp;Material</button>\
            <button class="btn btn-primary me-2 show-material" data-skki-id="${data.skki_id}">Lihat&nbsp;Material</button>\
            <button class="btn btn-danger delete-wbs-material" data-id="${data.id}">Hapus</button>\
        </div>\
    `)
    $('input[name=wbs_material]').val('')
}

function materialWbsDestroyCallback(id) {
    $('#wbs-material-'+id).remove();
}

function materialImportFromWbsCallback({data}) {
    data.forEach(material => {
        $('#materialTbl>tbody').append(`<tr id="material-${material.id}">\
            <td>${material.normalisasi}</td>\
            <td>${material.nama}</td>\
            <td>${material.satuan}</td>\
            <td>Rp${new Intl.NumberFormat('id-ID').format(material.harga)}</td>\
            <td>${material.jumlah}</td>\
            <td>Rp${new Intl.NumberFormat('id-ID').format(parseInt(material.harga)*parseInt(material.jumlah))}</td>\
            <td>\
                <div class="d-flex justify-content-end">\
                    <button class="btn btn-warning me-2 editMaterialBtn" data-id="${ material.id }" data-normalisasi="${ material.normalisasi }" data-nama="${ material.nama }" data-satuan="${ material.satuan }" data-harga="${ material.harga }" data-jumlah="${ material.jumlah }" data-stok="${ material.stok }" data-base-material-id="${ material.base_material_id }" data-deskripsi="${ material.deskripsi }">Edit</button>\
                    <button class="btn btn-danger deleteMaterialBtn" data-id="${ material.id }">Hapus</button>\
                </div>\
            </td>\
        </tr>`)
    })
    $('.import-material').attr('disabled', false)
}

function materialShowFromWbsCallback({data}) {
    $('#materialSkkiTbl>tbody').html('');
    data.forEach(material => {
        $('#materialSkkiTbl>tbody').append(`<tr>\
            <td>${material.normalisasi}</td>\
            <td>${material.nama}</td>
            <td>${material.satuan}</td>
            <td>Rp${new Intl.NumberFormat('id-ID').format(material.harga)}</td>
            <td>${material.jumlah}</td>
            <td>Rp${new Intl.NumberFormat('id-ID').format(material.jumlah*material.harga)}</td>
        </tr>`)
    })
    $('#materialSkkiModal').modal('show')
}
// ===== MATERIAL =====
// open for create
function materialModalOpenCallback(type, data = null) {
    switch (type) {
        case 'create':
            $('#updateMaterialBtn').hide();
            $('#saveMaterialBtn').show();
            $('#materialModalLabel').text('Material Baru');
            $('#materialModal').modal('show');
            break;
        case 'update':
            $('#materialModalLabel').text('Edit Material');
            $('#saveMaterialBtn').hide();
            $('#updateMaterialBtn').show();
            $('#materialNormalisasiMessageContainer').show()
            $('#selectedMaterialNormalisasi').text(data.normalisasi)
            $('input[name=material_id]').val(data.id);
            $('input[name=base_material_id]').val(data.base_material_id)
            $('input[name=material_nama]').val(data.nama);
            $('input[name=material_satuan]').val(data.satuan);
            $('input[name=material_harga]').val(data.harga);
            $('input[name=material_jumlah]').val(data.jumlah);
            $('textarea[name=material_deskripsi]').val(data.deskripsi);
            $('#stokContainer').show();
            $('#materialModal').modal('show');
            break;

        default:
            alert('Error');
            break;
    }
}
// on base material id change
function baseMaterialIDChangeCallback(val, materials) {
    $('#materialNormalisasiMessageContainer').hide()
    if(val.length > 0) {
        let selectedMaterial = materials.filter(el => el.id == val)
        if(selectedMaterial.length > 0) {
            $('#selectedMaterialNormalisasi').text(selectedMaterial[0].normalisasi)
            $('#materialNormalisasiMessageContainer').show()
            $('input[name=material_nama]').val(selectedMaterial[0].nama);
            $('textarea[name=material_deskripsi]').val(selectedMaterial[0].deskripsi);
            $('input[name=material_satuan]').val(selectedMaterial[0].satuan);
            $('input[name=material_harga]').val(selectedMaterial[0].harga);
        }
    }
}
// save
function materialSaveCallback({data}) {
    // write data to table
    $('#materialTbl>tbody').append(`<tr id="material-${data.id}">\
        <td>${data.normalisasi}</td>\
        <td>${data.nama}</td>\
        <td>${data.satuan}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.harga)}</td>\
        <td>${data.jumlah}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(parseInt(data.harga)*parseInt(data.jumlah))}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editMaterialBtn" data-id="${data.id}" data-normalisasi="${data.normalisasi}" data-nama="${data.nama}" data-satuan="${data.satuan}" data-harga="${data.harga}" data-jumlah="${data.jumlah}" data-base-material-id="${data.base_material_id}" data-deskripsi="${data.deskripsi}">Edit</button>\
                <button class="btn btn-danger deleteMaterialBtn" data-id="${data.id}">Hapus</button>\
            </div>\
        </td>\
    </tr>`)
    // clear form
    $('input[name=material_nama]').val('');
    $('textarea[name=material_deskripsi]').val('');
    $('input[name=material_satuan]').val('');
    $('input[name=material_harga]').val('');
    $('input[name=base_material_id]').val('');
    $('input[name=material_jumlah]').val('');
    $('#materialNormalisasiMessageContainer').hide();
    $('#materialModal').modal('hide');
}
// update
function materialUpdateCallback({data}) {
    $('#material-'+data.id).html(`\
        <td>${data.normalisasi}</td>\
        <td>${data.nama}</td>\
        <td>${data.satuan}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.harga)}</td>\
        <td>${data.jumlah}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(parseInt(data.harga)*parseInt(data.jumlah))}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editMaterialBtn" data-id="${data.id}" data-normalisasi="${data.normalisasi}" data-nama="${data.nama}" data-satuan="${data.satuan}" data-harga="${data.harga}" data-jumlah="${data.jumlah}" data-base-material-id="${data.base_material_id}" data-deskripsi="${data.deskripsi}">Edit</button>\
                <button class="btn btn-danger deleteMaterialBtn" data-id="${data.id}">Hapus</button>\
            </div>\
        </td>\
    `)
    $('#materialModal').modal('hide');
}
// delete
function materialDeleteCallback(id) {
    $('#material-'+id).remove();
    $('#deleteModal').modal('hide');
}

// ===== FILE =====
// ===== MATERIAL =====
// open for create
function fileModalOpenCallback() {
    $('#fileModalLabel').text('Upload Lampiran Baru')
    $('#fileModal').modal('show');
}
// save
function fileSaveCallback({data}) {
    $('#fileTbl>tbody').append(`\
        <tr id="file-${data.id}">\
            <td>\
                <p class="mb-0">${data.nama}</p>\
                <small>${data.deskripsi ? data.deskripsi.substr(0, 200) : ''}</small>\
            </td>\
            <td>\
                <div class="d-flex justify-content-end">\
                    <a href="/storage/${data.url}" target="_blank" class="btn btn-primary me-2">Unduh</a>\
                    <button class="btn btn-danger deleteFileBtn" data-id="${data.id}">Hapus</button>
                </div>\
            </td>\
        </tr>`)
    $('#fileModal').modal('hide');
}
// delete
function fileDeleteCallback(id) {
    $('#file-'+id).remove();
    $('#deleteModal').modal('hide');
}

// ==== UNIVERSAL DELETE MODAL =====
function deleteModalOpenCallback(type, id) {
    switch (type) {
        case 'jasa':
            $('#deleteModalLabel').text('Hapus Jasa');
            $('#deleteFileBtn').hide();
            $('#deleteJasaBtn').show();
            $('#deleteMaterialBtn').hide();
            $('input[name=jasa_id]').val(id);
            $('#deleteModal').modal('show');
            break;
        case 'material':
            $('#deleteModalLabel').text('Hapus Material');
            $('#deleteFileBtn').hide();
            $('#deleteJasaBtn').hide();
            $('#deleteMaterialBtn').show();
            $('input[name=material_id]').val(id);
            $('#deleteModal').modal('show');
            break;
        case 'file':
            $('#deleteModalLabel').text('Hapus File');
            $('#deleteFileBtn').show();
            $('#deleteJasaBtn').hide();
            $('#deleteMaterialBtn').hide();
            $('input[name=file_id]').val(id);
            $('#deleteModal').modal('show');
            break;
        default:
            alert('Error');
            break;
    }
}

// ===== KONTRAK =====
function statusChangeCallback(val){
    if(val == 'TERKONTRAK') {
        $('#kontrakModal').modal('show');
    }
}
function kontrakSaveCallback({data}) {
    $('#kontrakModal').modal('hide');
    $('#kontrakSuccessModal').modal('show');
    $('input[name=kontrak_nama_kontrak]').val('')
    $('input[name=kontrak_tgl_kontrak]').val('')
    $('input[name=kontrak_tgl_awal]').val('')
    $('input[name=kontrak_tgl_akhir]').val('')
    $('input[name=kontrak_pelaksana]').val('')
    $('select[name=kontrak_direksi]').val('')
}