// ===== Pembayaran =====
function callbackPembayaranChange(data) {
    $('#lastUpdated').text(moment(data.done_at).format("YYYY-MM-DD HH:mm:ss"))
}

// ===== Pembayaran =====
function pembayaranModalOpenCallback(type, data = null) {
    switch (type) {
        case 'create':
            $('#pembayaranModalLabel').text('Buat Pembayaran Baru');
            $('#savePembayaranBtn').show();
            $('#updatePembayaranBtn').hide();
            $('#pembayaranModal').modal('show');
            break;
        case 'update':
            $('#pembayaranModalLabel').text('Edit Pembayaran');
            $('#savePembayaranBtn').hide();
            $('#updatePembayaranBtn').show();
            $('#pembayaranIdInput').val(data.id);
            $('#pembayaranTanggalInput').val(data.tanggal);
            $('#pembayaranNominalInput').val(data.nominal);
            $('#pembayaranKeteranganTextarea').val(data.keterangan);
            $('#pembayaranModal').modal('show');
            break;
        
        default:
            alert('Error');
            break;
        }
}

function pembayaranSaveCallback({data}) {
    $('#pembayaranPertahapTbl>tbody').append(`
        <tr id="pembayaran-tahap-${ data.id }">
            <td>
                <div><strong>Dibayarkan</strong>: ${ data.tanggal }</div>
                <div><small>${ data.keterangan }</small></div>
            </td>
            <td>Rp${ new Intl.NumberFormat('id-ID').format(data.nominal) }</td>
            <td>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-warning me-2 editPembayaranPertahapBtn" data-id="${ data.id }" data-tanggal="${ data.tanggal }" data-keterangan="${ data.keterangan }" data-nominal="${ data.nominal }">Edit</button>
                    <button class="btn btn-danger deletePembayaranPertahapBtn" data-id="${ data.id }">Hapus</button>
                </div>
            </td>
        </tr>
    `)
    $('#pembayaranModal').modal('hide');
}

function pembayaranPertahapUpdateCallback({data}) {
    $(`#pembayaran-tahap-${ data.id }`).html(`\
        <td>
            <div><strong>Dibayarkan</strong>: ${ data.tanggal }</div>
            <div><small>${ data.keterangan }</small></div>
        </td>
        <td>Rp${ new Intl.NumberFormat('id-ID').format(data.nominal) }</td>
        <td>
            <div class="d-flex justify-content-end">
                <button class="btn btn-warning me-2 editPembayaranPertahapBtn" data-id="${ data.id }" data-tanggal="${ data.tanggal }" data-keterangan="${ data.keterangan }" data-nominal="${ data.nominal }">Edit</button>
                <button class="btn btn-danger deletePembayaranPertahapBtn" data-id="${ data.id }">Hapus</button>
            </div>
        </td>
    `)
    $('#pembayaranModal').modal('hide');
}

function pembayaranPertahapDeleteCallback(id) {
    $('#pembayaran-tahap-'+id).remove();
    $('#deleteModal').modal('hide');
}

// ===== MATERIAL =====
// show material transaction
async function materialTransaksiShowCallback({data}) {
    $('#materialTransaksiTbl>tbody').html('')
    await data.forEach(material => {
        $('#materialTransaksiTbl>tbody').append(`
            <tr>\
                <td>${material.tanggal}</td>\
                <td>${material.tug9}</td>\
                <td>${material.transaksi == 'keluar' ? '<span class="text-danger">Reservasi</span>' : '<span class="text-primary">Retur</span>'}</td>\
                <td>${material.normalisasi}</td>\
                <td>${material.nama}</td>\
                <td>${material.satuan}</td>\
                <td>Rp${new Intl.NumberFormat('id-ID').format(material.harga)}</td>\
                <td>${material.jumlah}</td>\
                <td>Rp${new Intl.NumberFormat('id-ID').format(parseInt(material.harga)*parseInt(material.jumlah))}</td>\
            </tr>
        `)
    });
    $('#materialTransaksiTbl').DataTable();
    $('#materialTransaksiModal').modal('show');
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
        case 'pembayaran-pertahap':
            $('#deleteModalLabel').text('Hapus Pembayaran');
            $('#deleteFileBtn').hide();
            $('#deletePembayaranPertahapBtn').show();
            $('#deleteMaterialBtn').hide();
            $('#pembayaranIdInput').val(id);
            $('#deleteModal').modal('show');
            break;
        // case 'material':
        //     $('#deleteModalLabel').text('Hapus Material');
        //     $('#deleteFileBtn').hide();
        //     $('#deleteJasaBtn').hide();
        //     $('#deleteMaterialBtn').show();
        //     $('input[name=material_id').val(id);
        //     $('#deleteModal').modal('show');
        //     break;
        case 'file':
            $('#deleteModalLabel').text('Hapus File');
            $('#deleteFileBtn').show();
            $('#deletePembayaranPertahapBtn').hide();
            $('#deleteMaterialBtn').hide();
            $('input[name=file_id]').val(id);
            $('#deleteModal').modal('show');
            break;
        default:
            alert('Error');
            break;
    }
}

