
//Show and hide edit-student content
$('.edit-student-tab').click(function(e) {
    let id_tab = $(this).attr('data-id-tab');
    $('.edit-student-tab').each((index, value) => {
        let tab = $(value).attr('data-id-tab');
        $(`#${tab}`).addClass('d-none');
        $(value).removeClass('student-active-tab');
    });

    $(`#${id_tab}`).removeClass('d-none');
    $(this).addClass('student-active-tab');
});

$('#student_status').on('change', function () {
    let label = $('#label_student_status');
    if ($(this).is(':checked')) {
        label.text('Ativo');
    } else {
        label.text('Desativado');
    }
});