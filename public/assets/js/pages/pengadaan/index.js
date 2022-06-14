// ===== GLOBAL VARIABLE =====
var pengadaan_id = window.location.href.split('/')[4];
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

// ===== pengadaan =====
// update
$('.pengadaan-field').on('change', async function() {
    await updatepengadaan(pengadaan_id, $('#pengadaanForm').serialize(), callbackpengadaanChange)
})

// ===== WBS JASA =====
$('input[name=wbs_jasa]').on('change', async function() {
    let data = {
        wbs_jasa: $(this).val()
    }
    await jasaWbsSaveService(pengadaan_id, data, jasaWbsSaveCallback);
})
$(document).on('click', '.delete-wbs-jasa', async function() {
    await jasaWbsDestroyService(pengadaan_id, $(this).data('id'), jasaWbsDestroyCallback)
})
// ===== JASA =====
// create
$('#createJasaBtn').on('click', function(){
    jasaModalOpenCallback('create')
});
$('#saveJasaBtn').on('click', async function() {
    await jasaSaveService(pengadaan_id, $('#jasaForm').serialize(), jasaSaveCallback);
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
    let jasa_id = $('input[name=jasa_id]').val();
    await jasaUpdateService(pengadaan_id, jasa_id, $('#jasaForm').serialize(), jasaUpdateCallback);
})

// delete
$(document).on('click', '.deleteJasaBtn', function(){
    deleteModalOpenCallback('jasa', $(this).data('id'));
});
$('#deleteJasaBtn').on('click', function() {
    let jasa_id = $('input[name=jasa_id]').val();
    jasaDeleteService(pengadaan_id, jasa_id, jasaDeleteCallback)
})

// import jasa from wbs
$(document).on('click', '.import-jasa', function() {
    let data = {
        skki_id: $(this).data('skki-id')
    }
    jasaImportFromWbsService(pengadaan_id, data, jasaImportFromWbsCallback)
})
// show jasa from wbs
$(document).on('click', '.show-jasa', async function() {
    let skki_id = $(this).data('skki-id')
    await jasaShowFromWbsService(pengadaan_id, skki_id, jasaShowFromWbsCallback)
})

// ===== WBS MATERIAL=====
// create
$('input[name=wbs_material]').on('change', async function() {
    let data = {
        wbs_material: $(this).val()
    }
    await materialWbsSaveService(pengadaan_id, data, materialWbsSaveCallback)
})
// destroy
$(document).on('click', '.delete-wbs-material', async function() {
    await materialWbsDestroyService(pengadaan_id, $(this).data('id'), materialWbsDestroyCallback)
})
// import material
$(document).on('click', '.import-material', async function() {
    let data = {
        skki_id: $(this).data('skki-id')
    }
    await materialImportFromWbsService(pengadaan_id, data, materialImportFromWbsCallback)
})
// show material
$(document).on('click', '.show-material', async function() {
    await materialShowFromWbsService(pengadaan_id, $(this).data('skki-id'), materialShowFromWbsCallback)
})
// ===== MATERIAL =====
// create
$('#createMaterialBtn').on('click', function(){
    materialModalOpenCallback('create')
});
$('input[name=base_material_id]').on('change', async function() {
    baseMaterialIDChangeCallback($(this).val(), materials)
})
$('#saveMaterialBtn').on('click', async function() {
    await materialSaveService(pengadaan_id, $('#materialForm').serialize(), materialSaveCallback);
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
    }
    materialModalOpenCallback('update', data)
})
$('#updateMaterialBtn').on('click', async function() {
    let material_id = $('input[name=material_id]').val();
    await materialUpdateService(pengadaan_id, material_id, $('#materialForm').serialize(), materialUpdateCallback);
})

// delete
$(document).on('click', '.deleteMaterialBtn', function() {
    deleteModalOpenCallback('material', $(this).data('id'));
})
$('#deleteMaterialBtn').on('click', function() {
    let material_id = $('input[name=material_id]').val();
    materialDeleteService(pengadaan_id, material_id, materialDeleteCallback)
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
    await fileSaveService(pengadaan_id, data, fileSaveCallback);
})
// delete
$(document).on('click', '.deleteFileBtn', function() {
    deleteModalOpenCallback('file', $(this).data('id'));
})
$('#deleteFileBtn').on('click', function() {
    let file_id = $('input[name=file_id]').val();
    fileDeleteService(pengadaan_id, file_id, fileDeleteCallback)
});

// ===== KONTRAK =====
$('select[name=status]').on('change', function() {
    statusChangeCallback($(this).val())
})
$(document).on('click', '#saveKontrakBtn', async function() {
    let data = $('#kontrakForm').serialize()+`&pengadaan_id=${pengadaan_id}`
    await kontrakSaveService(data, kontrakSaveCallback)
})