// ===== GLOBAL VARIABLE =====
var pembayaran_id = window.location.href.split('/')[4];

// ===== ON READY =====
$(document).ready(async function() {
    // define DataTable
    $('#pembayaranPertahapTbl').DataTable();
    $('#materialTbl').DataTable();
    $('#fileTbl').DataTable();
})

// ===== Pembayaran =====
// update
$('.pembayaran-field').on('change', async function() {
    await updatePembayaran(pembayaran_id, $('#pembayaranForm').serialize(), callbackPembayaranChange)
})

// ===== JASA =====
// create
$('#pembayaranCreateBtn').on('click', function(){
    pembayaranModalOpenCallback('create')
});
$('#savePembayaranBtn').on('click', async function() {
    await pembayaranSaveService(pembayaran_id, $('#pembayaranPertahapForm').serialize(), pembayaranSaveCallback);
})

// update
$(document).on('click', '.editPembayaranPertahapBtn', function(){
    let data = {
        id: $(this).data('id'),
        tanggal: $(this).data('tanggal'),
        nominal: $(this).data('nominal'),
        keterangan: $(this).data('keterangan'),
    }
    pembayaranModalOpenCallback('update', data)
});
$('#updatePembayaranBtn').on('click', async function() {
    let pertahap_id = $('#pembayaranIdInput').val();
    await pembayaranPertahapUpdateService(pembayaran_id, pertahap_id, $('#pembayaranPertahapForm').serialize(), pembayaranPertahapUpdateCallback);
})

// // delete
$(document).on('click', '.deletePembayaranPertahapBtn', function(){
    deleteModalOpenCallback('pembayaran-pertahap', $(this).data('id'));
});
$('#deletePembayaranPertahapBtn').on('click', function() {
    let pertahap_id = $('#pembayaranIdInput').val();
    pembayaranPertahapDeleteService(pembayaran_id, pertahap_id, pembayaranPertahapDeleteCallback)
})

// ===== MATERIAL =====
$('#materialTransaksiBtn').on('click', function() {
    materialTransaksiShowService(pembayaran_id, materialTransaksiShowCallback)
})

// ===== FILE =====
// create
$('#createFileBtn').on('click', function() {
    fileModalOpenCallback();
})
$('#saveFileBtn').on('click', async function() {
    let data = new FormData();
    data.append('file', $('input[name=file]')[0].files[0]);
    data.append('deskripsi', $('textarea[name=file_deskripsi]').val())
    await fileSaveService(pembayaran_id, data, fileSaveCallback);
})
// delete
$(document).on('click', '.deleteFileBtn', function() {
    deleteModalOpenCallback('file', $(this).data('id'));
})
$('#deleteFileBtn').on('click', function() {
    let file_id = $('input[name=file_id]').val();
    fileDeleteService(pembayaran_id, file_id, fileDeleteCallback)
});