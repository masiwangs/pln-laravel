// ===== GLOBAL VARIABLE =====
var skki_id = window.location.href.split('/')[4];
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

// ===== SKKI =====
// update
$('.skki-field').on('change', async function() {
    let data = $('#skkiForm').serialize()+`&wbs_jasa=${$('input[name=wbs_jasa]').val()}&wbs_material=${$('input[name=wbs_material]').val()}`;
    await skkiUpdateService(skki_id, data, callbackSKKIChange)
})

// ===== JASA =====
// create
$('#createJasaBtn').on('click', function(){
    jasaModalOpenCallback('create')
});
$('#saveJasaBtn').on('click', async function() {
    await jasaSaveService(skki_id, $('#jasaForm').serialize(), jasaSaveCallback);
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
    await jasaUpdateService(skki_id, jasa_id, $('#jasaForm').serialize(), jasaUpdateCallback);
})

// delete
$(document).on('click', '.deleteJasaBtn', function(){
    deleteModalOpenCallback('jasa', $(this).data('id'));
});
$('#deleteJasaBtn').on('click', function() {
    let jasa_id = $('input[name=jasa_id]').val();
    jasaDeleteService(skki_id, jasa_id, jasaDeleteCallback)
})

// import jasa dari prk
$('#importJasaPrkBtn').on('click', function() {
    jasaImportFromPRKService(skki_id, jasaImportFromPRKCallback)
})

// lihat jasa di prk
$('#showJasaPrkBtn').on('click', function() {
    jasaShowFromPRKCallback();
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
    await materialSaveService(skki_id, $('#materialForm').serialize(), materialSaveCallback);
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
    await materialUpdateService(skki_id, material_id, $('#materialForm').serialize(), materialUpdateCallback);
})

// delete
$(document).on('click', '.deleteMaterialBtn', function() {
    deleteModalOpenCallback('material', $(this).data('id'));
})
$('#deleteMaterialBtn').on('click', function() {
    let material_id = $('input[name=material_id]').val();
    materialDeleteService(skki_id, material_id, materialDeleteCallback)
})

// import material from prk
$('#importMaterialPrkBtn').on('click', function() {
    $(this).text('loading...')
    materialImportFromPRKService(skki_id, materialImportFromPRKCallback);
})
// lihat material di prk
$('#showMaterialPrkBtn').on('click', function() {
    materialShowFromPRKCallback();
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
    await fileSaveService(skki_id, data, fileSaveCallback);
})
// delete
$(document).on('click', '.deleteFileBtn', function() {
    deleteModalOpenCallback('file', $(this).data('id'));
})
$('#deleteFileBtn').on('click', function() {
    let file_id = $('input[name=file_id]').val();
    fileDeleteService(skki_id, file_id, fileDeleteCallback)
});