// ===== ON READY =====
$(document).ready(async function() {
    $('#baseMaterialTbl').DataTable();
})
// ===== BASE MATERIAL =====
// create
$('#baseMaterialCreateBtn').on('click', function(){
    baseMaterialModalOpenCallback('create')
});
$('#baseMaterialImportBtn').on('click', function(){
    baseMaterialImportModalOpenCallback()
});
$('#saveBaseMaterialBtn').on('click', async function() {
    await baseMaterialSaveService($('#baseMaterialForm').serialize(), baseMaterialSaveCallback);
})

// update
$(document).on('click', '.editBaseMaterialBtn', function(){
    let data = {
        id: $(this).data('id'),
        normalisasi: $(this).data('normalisasi'),
        nama: $(this).data('nama'),
        deskripsi: $(this).data('deskripsi'),
        satuan: $(this).data('satuan'),
        harga: $(this).data('harga'),
    }
    baseMaterialModalOpenCallback('update', data)
});
$('#updateBaseMaterialBtn').on('click', async function() {
    let base_material_id = $('#materialIdInput').val();
    await baseMaterialUpdateService(base_material_id, $('#baseMaterialForm').serialize(), baseMaterialUpdateCallback);
})

// delete
$(document).on('click', '.deleteBaseMaterialBtn', function(){
    deleteModalOpenCallback($(this).data('id'));
});
$('#deleteBaseMaterialBtn').on('click', function() {
    let base_material_id = $('#materialIdInput').val();
    baseMaterialDeleteService(base_material_id, baseMaterialDeleteCallback)
})