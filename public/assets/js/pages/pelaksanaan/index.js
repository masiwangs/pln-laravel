// ===== GLOBAL VARIABLE =====
var pelaksanaan_id = window.location.href.split('/')[4];
var materials;

// ===== ON READY =====
$(document).ready(async function() {
    // define DataTable
    $('#jasaTbl').DataTable();
    $('#materialTbl').DataTable();
    $('#fileTbl').DataTable();

    // get base material
    materials = await getBaseMaterials();
    callbackBaseMaterial(materials);
})

// ===== PELAKSANAAN =====
// update
$('.pelaksanaan-field').on('change', async function() {
    await updatePelaksanaan(pelaksanaan_id, $('#pelaksanaanForm').serialize(), callbackPelaksanaanChange)
})

// KONTRAK
$('#kontrakDetailToggle').on('click', function() {
    kontrakDetailToggleCallback();
})

// ===== JASA =====
// create
$('#jasaRealisasiCreateBtn').on('click', function(){
    jasaModalOpenCallback('create')
});
$('#saveJasaBtn').on('click', async function() {
    await jasaSaveService(pelaksanaan_id, $('#jasaForm').serialize(), jasaSaveCallback);
})

// update
$(document).on('click', '.editJasaBtn', function(){
    let data = {
        id: $(this).data('id'),
        nama: $(this).data('nama'),
        harga: $(this).data('harga'),
    }
    jasaModalOpenCallback('update', data)
});
$('#updateJasaBtn').on('click', async function() {
    let jasa_id = $('#jasaIdInput').val();
    await jasaUpdateService(pelaksanaan_id, jasa_id, $('#jasaForm').serialize(), jasaUpdateCallback);
})
$('#jasaRabToggle').on('click', async function() {
    await jasaRabService(pelaksanaan_id, jasaRabCallback)
})

// delete
$(document).on('click', '.deleteJasaBtn', function(){
    deleteModalOpenCallback('jasa', $(this).data('id'));
});
$('#deleteJasaBtn').on('click', function() {
    let jasa_id = $('#jasaIdInput').val();
    jasaDeleteService(pelaksanaan_id, jasa_id, jasaDeleteCallback)
})

// ===== MATERIAL =====
// create
$('#reservasiMaterialBtn').on('click', function(){
    materialModalOpenCallback('reservasi')
});
$('#returMaterialBtn').on('click', function(){
    materialModalOpenCallback('retur')
});
$('input[name=base_material_id]').on('change', async function() {
    baseMaterialIDChangeCallback($(this).val(), materials)
})
$('#saveMaterialBtn').on('click', async function() {
    await materialSaveService(pelaksanaan_id, $('#materialForm').serialize(), materialSaveCallback);
})

// update
$(document).on('click', '.editMaterialBtn', function() {
    let data = {
        id: $(this).data('id'),
        base_material_id: $(this).data('base-material-id'),
        normalisasi: $(this).data('normalisasi'),
        nama: $(this).data('nama'),
        deskripsi: $(this).data('deskripsi'),
        satuan: $(this).data('satuan'),
        harga: $(this).data('harga'),
        jumlah: $(this).data('jumlah'),
        tug9: $(this).data('tug9'),
        tanggal: $(this).data('tanggal'),
        transaksi: $(this).data('transaksi'),
    }
    materialModalOpenCallback('update', data)
})
$('#updateMaterialBtn').on('click', async function() {
    let material_id = $('input[name=material_id]').val();
    await materialUpdateService(pelaksanaan_id, material_id, $('#materialForm').serialize(), materialUpdateCallback);
})

// delete
$(document).on('click', '.deleteMaterialBtn', function() {
    deleteModalOpenCallback('material', $(this).data('id'));
})
$('#deleteMaterialBtn').on('click', function() {
    let material_id = $('input[name=material_id]').val();
    materialDeleteService(pelaksanaan_id, material_id, materialDeleteCallback)
})

$('#materialRabToggle').on('click', async function() {
    await materialRabService(pelaksanaan_id, materialRabCallback)
})

$('#materialStokToggle').on('click', async function() {
    await materialStokService(pelaksanaan_id, materialStokCallback)
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
    await fileSaveService(pelaksanaan_id, data, fileSaveCallback);
})
// delete
$(document).on('click', '.deleteFileBtn', function() {
    deleteModalOpenCallback('file', $(this).data('id'));
})
$('#deleteFileBtn').on('click', function() {
    let file_id = $('input[name=file_id]').val();
    fileDeleteService(pelaksanaan_id, file_id, fileDeleteCallback)
});