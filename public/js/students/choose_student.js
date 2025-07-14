$('document').ready(function () {
});

function selectStudent(student_id) {

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: `/students/selectStudent`,
        type: 'POST',
        data: {
            'student_id': student_id
        },
        success: function (response) {
            //Unsubscribe courses from student chosen earlier
            unsubscribeFromCourses();
            window.location.href = '/dashboard';
        }
    });

}
