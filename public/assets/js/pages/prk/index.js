// ===== GLOBAL VARIABLE =====
var prk_id = window.location.href.split('/')[4];
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
    $('#materialSelect').select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#materialForm")
    })
})

// ===== PRK =====
// update
$('.prk-field').on('change', async function() {
    await updatePRK(prk_id, $('#prkForm').serialize(), callbackPRKChange)
})

// ===== JASA =====
// create
$('#createJasaBtn').on('click', function(){
    jasaModalOpenCallback('create')
});
$('#saveJasaBtn').on('click', async function() {
    await jasaSaveService(prk_id, $('#jasaForm').serialize(), jasaSaveCallback);
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
    await jasaUpdateService(prk_id, jasa_id, $('#jasaForm').serialize(), jasaUpdateCallback);
})

// delete
$(document).on('click', '.deleteJasaBtn', function(){
    deleteModalOpenCallback('jasa', $(this).data('id'));
});
$('#deleteJasaBtn').on('click', function() {
    let jasa_id = $('input[name=jasa_id]').val();
    jasaDeleteService(prk_id, jasa_id, jasaDeleteCallback)
})

// ===== MATERIAL =====
// create
$('#createMaterialBtn').on('click', function(){
    materialModalOpenCallback('create')
});
$('select[name=base_material_id]').on('change', async function() {
    baseMaterialIDChangeCallback($(this).val(), materials)
})
$('#saveMaterialBtn').on('click', async function() {
    await materialSaveService(prk_id, $('#materialForm').serialize(), materialSaveCallback);
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
    await materialUpdateService(prk_id, material_id, $('#materialForm').serialize(), materialUpdateCallback);
})

// delete
$(document).on('click', '.deleteMaterialBtn', function() {
    deleteModalOpenCallback('material', $(this).data('id'));
})
$('#deleteMaterialBtn').on('click', function() {
    let material_id = $('input[name=material_id]').val();
    materialDeleteService(prk_id, material_id, materialDeleteCallback)
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
    await fileSaveService(prk_id, data, fileSaveCallback);
})
// delete
$(document).on('click', '.deleteFileBtn', function() {
    deleteModalOpenCallback('file', $(this).data('id'));
})
$('#deleteFileBtn').on('click', function() {
    let file_id = $('input[name=file_id]').val();
    fileDeleteService(prk_id, file_id, fileDeleteCallback)
});

// ===== DELETE PROJECT =====
$('#deleteProject').on('click', function() {
    deleteModalOpenCallback('project', prk_id);
})

$('#deleteProjectBtn').on('click', function() {
    $(this).attr('disabled', true)
    deleteProjectService(prk_id);
})