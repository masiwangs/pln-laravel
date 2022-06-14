function callbackBaseMaterial(materials) {
    materials.forEach(material => {
        $('#materialList').append(`<option value=${material.id}>${material.normalisasi}: ${material.nama}`)
    });
}
// ===== KONTRAK=====
function kontrakDetailToggleCallback() {
    let is_hide = $('#kontrakDetailContainer').hasClass('d-none');
    if(is_hide) {
        $('#kontrakDetailToggle').html('Sembunyikan <i class="bi bi-eye-slash"></i>')
    } else {
        $('#kontrakDetailToggle').html('Lihat <i class="bi bi-eye"></i>')
    }
    $('#kontrakDetailContainer').toggleClass('d-none')
}

// ===== PELAKSANAAN =====
function handleProgressChange(){
    let val = $('#progressRange').val();
    $('#progressInput').val(val)
}
function handleProgressInputChange() {
    let val = $('#progressInput').val();
    $('#progressRange').val(val)
}
// ===== MATERIAL =====
function callbackPelaksanaanChange({data}) {
    $('#lastUpdated').text(moment(data.done_at).format("YYYY-MM-DD HH:mm:ss"))
}

// ===== JASA =====
function jasaModalOpenCallback(type, data = null) {
    switch (type) {
        case 'create':
            $('#jasaModalLabel').text('Realisasi Jasa Baru');
            $('#saveJasaBtn').show();
            $('#updateJasaBtn').hide();
            $('#jasaModal').modal('show');
            break;
        case 'update':
            $('#jasaModalLabel').text('Edit Jasa');
            $('#saveJasaBtn').hide();
            $('#updateJasaBtn').show();
            $('#jasaIdInput').val(data.id);
            $('#jasaNamaInput').val(data.nama);
            $('#jasaHargaInput').val(data.harga);
            $('#jasaTanggalInput').val(data.tanggal);
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
        <td>${data.tanggal}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editJasaBtn" data-id="${data.id}" data-nama="${data.nama}" data-harga="${data.harga}" data-tanggal=${data.tanggal}>Edit</button>\
                <button class="btn btn-danger deleteJasaBtn" data-id="${data.id}">Hapus</button>\
            </div>\
        </td>\
    </tr>`)
    let last_saldo = $('#jasaSaldoText').data('sum');
    let new_saldo = parseInt(last_saldo) - parseInt(data.harga);
    $('#jasaSaldoText').val('Rp'+new Intl.NumberFormat('id-ID').format(new_saldo));
    $('#jasaSaldoText').data('sum', new_saldo)
    $('#jasaModal').modal('hide');
}

function jasaUpdateCallback({data}) {
    $('#jasa-'+data.new.id).html(`\
        <td>${data.new.nama}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.new.harga)}</td>\
        <td>${data.new.tanggal}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editJasaBtn" data-id="${data.new.id}" data-nama="${data.new.nama}" data-harga="${data.new.harga}" data-tanggal=${data.new.tanggal}>Edit</button>\
                <button class="btn btn-danger deleteJasaBtn" data-id="${data.new.id}">Hapus</button>\
            </div>\
        </td>\
    `)
    let last_saldo = $('#jasaSaldoText').data('sum');
    let new_saldo = parseInt(last_saldo) + parseInt(data.last.harga) - parseInt(data.new.harga);
    $('#jasaSaldoText').val('Rp'+new Intl.NumberFormat('id-ID').format(new_saldo));
    $('#jasaSaldoText').data('sum', new_saldo)
    $('#jasaModal').modal('hide');
}

function jasaDeleteCallback({data}) {
    console.log(data)
    let last_saldo = $('#jasaSaldoText').data('sum');
    let new_saldo = parseInt(last_saldo) + parseInt(data.harga);
    $('#jasaSaldoText').val('Rp'+new Intl.NumberFormat('id-ID').format(new_saldo));
    $('#jasaSaldoText').data('sum', new_saldo)
    $('#jasa-'+data.id).remove();
    $('#deleteModal').modal('hide');
}

function jasaRabCallback({data}) {
    $('#jasaRabTbl>tbody').html('')
    data.forEach(jasa => {
        $('#jasaRabTbl>tbody').append(`
            <tr>\
                <td>${jasa.nama}</td>\
                <td>Rp${ new Intl.NumberFormat('id-ID').format(jasa.harga) }</td>\
            </tr>\
        `)
    })
    $('#jasaRabModal').modal('show')
}

// ===== MATERIAL =====
// open for create
function materialModalOpenCallback(type, data = null) {
    switch (type) {
        case 'reservasi':
            $('#updateMaterialBtn').hide();
            $('#materialModalLabel').html('<span class="text-danger">Reservasi</span> Material Baru');
            $('#materialModal').modal('show');
            $('#materialTransaksiType').val('keluar');
            break;
        case 'retur':
            $('#updateMaterialBtn').hide();
            $('#materialModalLabel').html('<span class="text-primary">Retur</span> Material Baru');
            $('#materialModal').modal('show');
            $('#materialTransaksiType').val('masuk');
            break;
        case 'update':
            $('#materialModalLabel').text('Edit Material');
            $('#saveMaterialBtn').hide();
            $('#updateMaterialBtn').show();
            $('#materialNormalisasiMessageContainer').show()
            $('#selectedMaterialNormalisasi').text(data.normalisasi)
            $('input[name=material_id').val(data.id);
            $('#materialNormalisasi').val(data.normalisasi);
            $('input[name=base_material_id]').val(data.base_material_id)
            $('input[name=material_nama]').val(data.nama);
            $('input[name=material_satuan]').val(data.satuan);
            $('input[name=material_harga]').val(data.harga);
            $('input[name=material_jumlah]').val(data.jumlah);
            $('input[name=material_tanggal]').val(data.tanggal);
            $('input[name=material_tug9]').val(data.tug9);
            $('textarea[name=material_deskripsi]').val(data.deskripsi);
            $('input[name=material_transaksi]').val(data.transaksi);
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
            $('#materialNormalisasi').val(selectedMaterial[0].normalisasi)
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
        <td>${data.tanggal}</td>\
        <td>${data.tug9}</td>\
        <td>${data.transaksi == 'keluar' ? '<span class="text-danger">reservasi</span>' : '<span class="text-primary">retur</span>'}</td>\
        <td>${data.normalisasi}</td>\
        <td>${data.nama}</td>\
        <td>${data.satuan}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.harga)}</td>\
        <td>${data.jumlah}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(parseInt(data.harga)*parseInt(data.jumlah))}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editMaterialBtn" data-id="${data.id}" data-normalisasi="${data.normalisasi}" data-nama="${data.nama}" data-satuan="${data.satuan}" data-harga="${data.harga}" data-tug9="${ data.tug9 }" data-tanggal="${ data.tanggal }" data-transaksi="${ data.transaksi }"  data-jumlah="${data.jumlah}" data-base-material-id="${data.base_material_id}" data-deskripsi="${data.deskripsi}">Edit</button>\
                <button class="btn btn-danger deleteMaterialBtn" data-id="${data.id}">Hapus</button>\
            </div>\
        </td>\
    </tr>`)
    // clear form
    $('input[name=tug9]').val('');
    $('input[name=tanggal]').val('');
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
        <td>${data.tanggal}</td>\
        <td>${data.tug9}</td>\
        <td>${data.transaksi == 'keluar' ? '<span class="text-danger">reservasi</span>' : '<span class="text-primary">retur</span>'}</td>\
        <td>${data.normalisasi}</td>\
        <td>${data.nama}</td>\
        <td>${data.satuan}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(data.harga)}</td>\
        <td>${data.jumlah}</td>\
        <td>Rp${new Intl.NumberFormat('id-ID').format(parseInt(data.harga)*parseInt(data.jumlah))}</td>\
        <td>\
            <div class="d-flex justify-content-end">\
                <button class="btn btn-warning me-2 editMaterialBtn" data-id="${data.id}" data-normalisasi="${data.normalisasi}" data-nama="${data.nama}" data-satuan="${data.satuan}" data-harga="${data.harga}" data-tug9="${ data.tug9 }" data-tanggal="${ data.tanggal }" data-transaksi="${ data.transaksi }"  data-jumlah="${data.jumlah}" data-base-material-id="${data.base_material_id}" data-deskripsi="${data.deskripsi}">Edit</button>\
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

function materialRabCallback({data}) {
    $('#materialRabTbl>tbody').html('')
    data.forEach(material => {
        $('#materialRabTbl>tbody').append(`
            <tr>\
                <td>${ material.normalisasi }</td>\
                <td>${ material.nama }</td>\
                <td>${ material.satuan }</td>\
                <td>Rp${ new Intl.NumberFormat('id-ID').format(material.harga) }</td>\
                <td>${ material.jumlah }</td>\
                <td>Rp${ new Intl.NumberFormat('id-ID').format(material.jumlah * material.harga) }</td>\
            </tr>\
        `)
    })
    $('#materialRabTbl').dataTable();
    $('#materialRabModal').modal('show')
}

function materialStokCallback({data}) {
    $('#materialStokTbl>tbody').html('')
    for(k in data) {
        let material = data[k]
        console.log(material)
        $('#materialStokTbl>tbody').append(`
            <tr>\
                <td>${ material.normalisasi }</td>\
                <td>${ material.nama }</td>\
                <td>${ material.satuan }</td>\
                <td>Rp${ new Intl.NumberFormat('id-ID').format(material.harga) }</td>\
                <td>${ material.jumlah }</td>\
                <td>Rp${ new Intl.NumberFormat('id-ID').format(material.jumlah * material.harga) }</td>\
            </tr>\
        `)
    }
    $('#materialStokTbl').dataTable();
    $('#materialStokModal').modal('show')
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
                <small>${data.deskripsi.substr(0, 200)}</small>\
            </td>\
            <td>\
                <div class="d-flex justify-content-end">\
                    <a href="/storage/${data.url}" target="_blank" class="btn btn-primary me-2">Unduh</a>\
                    <button class="btn btn-danger">Hapus</button>\
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
            $('#jasaIdInput').val(id);
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

