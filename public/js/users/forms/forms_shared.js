$('.finish').on('click', function () {

    // if (isValidVariable(method) && method == 'PUT') {
    //     let student_status = $('#student_status').is(':checked') ? 'on' : 'off';
    //     // console.log(student_status);
    //     $('#student_form').append(`<input type="hidden" name="student[status]" value="${student_status}" />`);
    // } 

    // $.each(salas, function (index, value) {
    //     $('#student_form').append(`<input type="hidden" name="student[classrooms][${index}]" value="${value}" />`);
    // });

    // $('form').submit();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#profile_photo_upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('#profile_photo').on('change', function () {
    readURL(this);
});