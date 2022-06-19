function callbackBaseMaterial(materials) {
    materials.forEach(material => {
        $('#materialSelect').append(`<option value=${material.id}>${material.normalisasi}: ${material.nama}`)
    });
    $('#materialSelect').select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#materialForm")
    })
}

// ===== SKKI =====
function callbackSKKIChange({data}) {
    $('#nomorSkki').text(data.skki);
    if(data.prk_id) {
        $('#namaPrk').text(data.prk.nama);
        $('#namaProject').val(data.prk.nama);
        $('#nomorPRK').val(data.prk.prk);
    } else {
        $('#namaPrk').text('');
        $('#namaProject').val('');
        $('#nomorPRK').val('');
    }
    $('#lastUpdated').text(moment(data.done_at).format("YYYY-MM-DD HH:mm:ss"))
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

function jasaDeleteCallback(id) {
    $('#jasa-'+id).remove();
    $('#deleteModal').modal('hide');
}

function jasaImportFromPRKCallback({data}) {
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
    $('#importJasaPrkBtn').html('Import dari PRK');
}

function jasaShowFromPRKCallback() {
    $('#jasaPrkModal').modal('show');
}

// ===== MATERIAL =====
// open for create
function materialModalOpenCallback(type, data = null) {
    switch (type) {
        case 'create':
            $('#materialModalLabel').text('Material Baru');
            $('#updateMaterialBtn').hide();
            $('#materialNormalisasiMessageContainer').hide();
            $('select[name=base_material_id]').val('');
            $('input[name=material_nama]').val('');
            $('textarea[name=material_deskripsi]').val('');
            $('input[name=material_satuan]').val('');
            $('input[name=material_harga]').val('');
            $('input[name=material_jumlah]').val('');
            $('input[name=material_stok]').val('');
            $('#materialModal').modal('show');
            break;
        case 'update':
            $('#materialModalLabel').text('Edit Material');
            $('#saveMaterialBtn').hide();
            $('#updateMaterialBtn').show();
            $('#materialNormalisasiMessageContainer').show()
            $('#selectedMaterialNormalisasi').text(data.normalisasi)
            $('input[name=material_id]').val(data.id);
            $('select[name=base_material_id]').val(data.base_material_id).trigger('change');
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
    if(val) {
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
    console.log(data)
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

function materialImportFromPRKCallback({data}) {
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
                    <button class="btn btn-warning me-2 editMaterialBtn" data-id="${material.id}" data-normalisasi="${material.normalisasi}" data-nama="${material.nama}" data-satuan="${material.satuan}" data-harga="${material.harga}" data-jumlah="${material.jumlah}" data-stok="${material.stok}" data-base-material-id="${material.base_material_id}" data-deskripsi="${material.deskripsi}">Edit</button>\
                <button class="btn btn-danger" data-id="${material.id}">Hapus</button>\
                </div>
            </td>\
        </tr>`)
    })
    $('#importMaterialPrkBtn').html('Import dari PRK')
    $('#materialModal').modal('hide');
    location.reload()
}

function materialShowFromPRKCallback() {
    $('#materialPrkModal').modal('show');
}

// ===== FILE =====
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

