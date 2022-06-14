$(document).ready(function() {
    // file script
    const openCreateFileModalButton = $('#createFileBtn');
    const createFileModal = $('#fileModal');
    const deleteModal = $('#deleteModal');
    const deleteModalLabel = $('#deleteModalLabel');
    const deleteModalFileButton = $('#deleteFileBtn');
    const deleteModalJasaButton = $('#deleteJasaBtn');
    const deleteModalMaterialButton = $('#deleteMaterialBtn');
    const fileTableBody = $('#fileTbl>tbody');
    const fileIdField = $('input[name=file_id]');
    const fileField = $('input[name=file]');
    const fileDescriptionField = $('textarea[name=file_deskripsi]');
    const saveFileButton = $('#saveFileBtn');

    // open create file modal
    openCreateFileModalButton.on('click', function() {
        createFileModal.modal('show');
    })

    // upload file
    saveFileButton.on('click', function() {
        let form_data = new FormData();
        form_data.append('file', fileField[0].files[0]);
        form_data.append('deskripsi', fileDescriptionField.val())
        $.ajax({
            url: window.location.href + '/file',
            method: 'POST', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            data: form_data,
            success: function(response) {
                fileTableBody.append(`\
                    <tr>\
                        <td>\
                            <p class="mb-0">${response.data.nama}</p>\
                            <small>${response.data.deskripsi.substr(0, 200)}</small>\
                        </td>\
                        <td>\
                            <div class="d-flex justify-content-end">\
                                <a href="/storage/${response.data.url}" target="_blank" class="btn btn-primary me-2">Unduh</a>\
                                <button class="btn btn-warning me-2">Edit</button>\
                                <button class="btn btn-danger">Hapus</button>\
                            </div>\
                        </td>\
                    </tr>`)
                createFileModal.modal('hide');
            }
        })
    })

    // open delete file modal
    $(document).on('click', '.deleteFileBtn', function() {
        deleteModalLabel.text('Hapus File');
        deleteModalFileButton.show();
        deleteModalJasaButton.hide();
        deleteModalMaterialButton.hide();
        fileIdField.val($(this).data('id'));
        deleteModal.modal('show');
    })

    // delete file
    deleteModalFileButton.on('click', function() {
        let id = fileIdField.val();
        $.ajax({
            url: window.location.href + '/file/'+id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            success: function(response) {
                $('#file-'+id).remove();
                deleteModal.modal('hide');
            }
        })
    })
})