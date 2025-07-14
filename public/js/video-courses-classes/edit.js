function removeFile(fileId) {
    let deletedFilesForm = $('input[name="deleted_files"]');
    let deletedFiles = deletedFilesForm.val().split(',').filter(Boolean);

    deletedFiles.push(fileId);
    deletedFilesForm.val(deletedFiles.join(','));
}

$('document').ready(function () {
    $('#link').on('change', function () {
        $(this).val() != ''
            ? embed.prop('readonly', true)
            : embed.prop('readonly', false);
    });
});