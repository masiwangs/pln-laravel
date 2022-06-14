// ===== BAS MATERIAL =====
function baseMaterialModalOpenCallback(type, data = null) {
    switch (type) {
        case 'create':
            $('#baseMaterialModalLabel').text('Buat Material Baru');
            $('#saveBaseMaterialBtn').show();
            $('#updateBaseMaterialBtn').hide();
            $('#baseMaterialModal').modal('show');
            break;
        case 'update':
            $('#baseMaterialModalLabel').text('Edit Material');
            $('#saveBaseMaterialBtn').hide();
            $('#updateBaseMaterialBtn').show();
            $('#materialIdInput').val(data.id);
            $('#materialNormalisasiInput').val(data.normalisasi);
            $('#materialNamaInput').val(data.nama);
            $('#materialDeskripsiTextarea').val(data.deskripsi);
            $('#materialSatuanInput').val(data.satuan);
            $('#materialHargaInput').val(data.harga);
            $('#baseMaterialModal').modal('show');
            break;
        default:
            alert('Error');
            break;
        }
}

function baseMaterialImportModalOpenCallback() {
    $('#baseMaterialImportModal').modal('show')
}

function baseMaterialSaveCallback({data}) {
    $('#baseMaterialTbl>tbody').append(`
        <tr id="base-material-${ data.id }">
            <td>${ data.normalisasi }</td>
            <td>
                <div>${ data.nama }</div>
                <small>${ data.deskripsi }</small>
            </td>
            <td>${ data.satuan }</td>
            <td>Rp${ new Intl.NumberFormat('id-ID').format(data.harga) }</td>
            <td>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-warning me-2 editBaseMaterialBtn" data-id="${ data.id }" data-normalisasi="${ data.normalisasi }" data-nama="${ data.nama }" data-deskripsi="${ data.deskripsi }" data-satuan="${ data.satuan }" data-harga="${ data.harga }">Edit</button>
                    <button class="btn btn-danger" data-id="${ data.id }">Hapus</button>
                </div>
            </td>
        </tr>
    `)
    $('#baseMaterialModal').modal('hide');
}

function baseMaterialUpdateCallback({data}) {
    $('#base-material-'+data.id).html(`\
        <td>${ data.normalisasi }</td>
        <td>
            <div>${ data.nama }</div>
            <small>${ data.deskripsi }</small>
        </td>
        <td>${ data.satuan }</td>
        <td>Rp${ new Intl.NumberFormat('id-ID').format(data.harga) }</td>
        <td>
            <div class="d-flex justify-content-end">
                <button class="btn btn-warning me-2 editBaseMaterialBtn" data-id="${ data.id }" data-normalisasi="${ data.normalisasi }" data-nama="${ data.nama }" data-deskripsi="${ data.deskripsi }" data-satuan="${ data.satuan }" data-harga="${ data.harga }">Edit</button>
                <button class="btn btn-danger" data-id="${ data.id }">Hapus</button>
            </div>
        </td>
    `)
    $('#baseMaterialModal').modal('hide');
}

function baseMaterialDeleteCallback(id) {
    $('#base-material-'+id).remove();
    $('#deleteModal').modal('hide');
}

// ==== UNIVERSAL DELETE MODAL =====
function deleteModalOpenCallback(id) {
    $('#deleteModalLabel').text('Hapus Material');
    $('#deleteBaseMaterialBtn').hide();
    $('#materialIdInput').val(id);
    $('#deleteModal').modal('show');
}

