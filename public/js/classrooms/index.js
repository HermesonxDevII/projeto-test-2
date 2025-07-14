function modalDeleteClassroom(classroom_id) {
    if(isValidVariable(classroom_id)) {
        let classroom_name = $(`table tbody tr[data-id-classroom="${classroom_id}"]`).find('.name').text();
        $('#delete_classroom_modal_item').text(`a turma ${classroom_name}?`);
        $('#classroom_to_delete').val(classroom_id);
        $('#delete_classroom_modal').modal('show');
    }
}

function deleteClassroomConfirmed() {
    let classroom_id = $('#classroom_to_delete').val();

    if (isValidVariable(classroom_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/classrooms/${classroom_id}`,
            type: 'DELETE',
            success: function (response) {
                $(`table tbody tr[data-id-classroom="${classroom_id}"]`).remove();
                $('#delete_classroom_modal').modal('hide');

                notify(response.msg, response.icon);
            },
            error: function (error) {
                console.log(error);
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            }
        });
        $('#classroom_to_delete').val('');
    }
}

$('document').ready(function () {
});

