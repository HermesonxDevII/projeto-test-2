
function showClassroomOption(id) {
    if (isValidVariable(id)) {
        $(`#classroom option[value="${id}"]`).prop('disabled', false).show();
        $('#classroom').val('');
    }
}

function hideClassroomOption(id) {
    if (isValidVariable(id)) {
        $(`#classroom option[value="${id}"]`).prop('disabled', true).hide();
        $('#classroom').val('');
    }
}

function removeClassroom(element) {
    if (isValidVariable(element)) {
        let row = $(`#student_classrooms tbody tr[data-id-classroom="${element}"]`);
        row.remove();
        showClassroomOption(row.data('id-classroom'));
    }
}

function getClassrooms() {
    let classroomsIds = [];

    $('#student_classrooms tbody tr').each((index, value) => {
        classroomsIds.push($(value).data('id-classroom'));
    });

    return classroomsIds;
}

function addClassroom() {
    let classroom = $('#classroom').val();

    if (isValidVariable(classroom)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/classrooms/getBasicData`,
            type: 'POST',
            data: {
                'id': classroom
            },
            success: function (response) {
                $("#student_classrooms tbody").append(`
                    <tr class="align-middle" data-id-classroom="${response.id}">
                        <td>${response.name}</td>
                        <td>${response.students} Alunos</td>
                        <td>${response.weekdays == '' ? '-' : response.weekdays}</td>
                        <td>${moment(response.created_at).format('D/MM/YYYY, h:mm')}</td>
                        <td>
                            <button class="btn btn-action text-white" onclick="removeClassroom('${response.id}');">
                                <img src="/images/icons/trash.svg" alt="">
                            </button>
                        </td>
                    </tr>
                `);

                hideClassroomOption(response.id);

                if (!$('#student_classrooms').is(':visible')) {
                    $('#student_classrooms').removeClass('d-none');
                }
            }
        });
    } else {
        showAlertModal('Selecione uma turma para adicioná-la ao aluno(a).');
    }
}

$('document').ready(function () {
    $('.avatar').on('click', function () {
        let avatarId = $(this).data('id-avatar');
        $('input[name="student[avatar_id]"]').val(avatarId);
        $('.avatar').css({'border': '2px solid transparent', 'box-shadow': 'none'});
        $(this).css({'border': '2px solid #329FBA', 'box-shadow': '0px 0px 5px #40404080'});
    });

    $('.finish').on('click', function () {        
        let salas = getClassrooms(),
            method = $('input[name="_method"').val();

        if (isValidVariable(method) && method == 'PUT') {
            let student_status = $('#student_status').is(':checked') ? 'on' : 'off';
            $('#student_form').append(`<input type="hidden" name="student[status]" value="${student_status}" />`);
        }

        $.each(salas, function (index, value) {
            $('#student_form').append(`<input type="hidden" name="student[classrooms][${index}]" value="${value}" />`);
        });

        let fm = $('#student_form');

        fm.submit();
    });
});
