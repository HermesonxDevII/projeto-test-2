document.getElementById('btn-iniciar-aula').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('createTransmissionModal'));
    modal.show();
});

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
        classroom_id = $('#classroom_id').val();

    if (isValidVariable(student_id) && isValidVariable(classroom_id)) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/classrooms/addStudent`,
            type: 'POST',
            data: {
                'classroomId': classroom_id,
                'studentId': student_id
            },
            success: function (response) {
                let data = response.data;
                moment.locale('pt-br');

                $('#classroom_students tbody').append(`
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
    let classroom_id = $('#classroom_id').val();

    if (isValidVariable(student_id) && isValidVariable(classroom_id)) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/classrooms/removeStudent`,
            type: 'POST',
            data: {
                'classroomId': classroom_id,
                'studentId': student_id
            },
            success: function (response) {
                $(`#classroom_students tbody tr[data-id-student='${student_id}']`).fadeOut(300, function () {
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

$('document').ready(function () {
    $('.copy-icon').on("click", function () {
        let id = $(this).parent().attr('id');
        copyElementText(id);
        notify('Link copiado com sucesso!');
    });
});

function modalDeleteEvaluation(evaluation_id) {
    if(isValidVariable(evaluation_id)) {
        let evaluation_name = $(`table tbody tr[data-id-evaluation="${evaluation_id}"]`).find('.title').text();
        $('#delete_evaluation_modal_item').text(`a avaliação ${evaluation_name}?`);
        $('#evaluation_to_delete').val(evaluation_id);
        $('#delete_evaluation_modal').modal('show');
    }
}

function deleteEvaluationConfirmed() {
    let evaluation_id = $('#evaluation_to_delete').val();

    if (isValidVariable(evaluation_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/evaluations/delete/${evaluation_id}`,
            type: 'DELETE',
            success: function (response) {
                $(`table tbody tr[data-id-evaluation="${evaluation_id}"]`).remove();
                $('#delete_evaluation_modal').modal('hide');

                notify(response.msg, response.icon);
            },
            error: function (error) {
                console.log(error);
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            }
        });
        $('#evaluation_to_delete').val('');
    }
}
