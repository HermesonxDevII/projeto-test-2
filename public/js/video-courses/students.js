function hideAddStudents() {
    $('#add-students').fadeOut();
}

function showAddStudents() {
    $('#add-students').fadeIn();
}

function hideStudentSelect(student_id) {
    $(`#students option[value='${student_id}']`).hide();
}

function showStudentSelect(student_id) {
    $(`#students option[value='${student_id}']`).show();
}

function addStudent() {
    let student_id = $('#students').val(),
    video_course_id = $('#video_course_id').val();

    if (isValidVariable(student_id) && isValidVariable(video_course_id)) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/video-courses/addStudent`,
            type: 'POST',
            data: {
                'videoCourseId': video_course_id,
                'studentId': student_id
            },
            success: function (response) {
                let data = response.data;
                moment.locale('pt-br');

                $('#video_course_students tbody').append(`
                    <tr data-id-student='${data.student_id}'>
                        <td class="align-middle">
                            ${moment(data.student_start_date).format('ll')}
                        </td>
                        <td class="align-middle">
                            ${data.student_name} <span class="badge badge-primary bg-primary ms-2">Novo</span>
                        </td>
                        <td class="align-middle">
                            ${data.guardian_name}
                        </td>
                        <td class="align-middle text-center">
                            <h5 class="m-0">
                                <span class="badge badge-${data.student_status == 1 ? 'success' : 'danger'}">
                                    ${data.student_status == 1 ? 'Ativo' : 'Desativado'}
                                </span>
                            </h5>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="btn-action me-4" onclick="removeStudent(${data.student_id})" href="javascript: void(0);">
                                    <img src="/images/icons/trash.svg" alt="">
                                </a>
                            </div>
                        </td>
                    </tr>
                `);

                $('#students').val('');
                hideStudentSelect(data.student_id);
                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            }
        });
    } else {
        showAlertModal('Informe um aluno para adicioná-lo a esta turma.')
    }
}

function removeStudent(student_id) {
    let video_course_id = $('#video_course_id').val();

    if (isValidVariable(student_id) && isValidVariable(video_course_id)) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/video-courses/removeStudent`,
            type: 'POST',
            data: {
                'videoCourseId': video_course_id,
                'studentId': student_id
            },
            success: function (response) {
                $(`#video_course_students tbody tr[data-id-student='${student_id}']`).fadeOut(300, function () {
                    $(this).remove();
                });
                showStudentSelect(response.student_id);

                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            }
        });
    }
}

function modalDeleteStudent(student_id) {
    if(isValidVariable(student_id)) {
        let student_name = $(`table tbody tr[data-id-student="${student_id}"]`).find('.name').text();
        $('#delete_video_course_student_modal_item').text(`o aluno ${student_name}?`);
        $('#student_to_delete').val(student_id);
        $('#delete_video_course_student_modal').modal('show');
    }
}
  
function deleteStudentConfirmed() {
    let student_id = $('#student_to_delete').val();
        video_course_id = $('#video_course_id').val();

    if (isValidVariable(student_id)) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/video-courses/removeStudent`,
            type: 'POST',
            data: {
                'videoCourseId': video_course_id,
                'studentId': student_id
            },
            success: function (response) {
                $(`table tbody tr[data-id-student="${student_id}"]`).remove();
                $('#delete_video_course_student_modal').modal('hide');

                notify(response.msg, response.icon);
            },
            error: function (error) {
                console.log(error);
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            }
        });
        $('#student_to_delete').val('');
    }
}

$('document').ready(function () {
    // $('.select2').select2();
    // select2Setup();
});
