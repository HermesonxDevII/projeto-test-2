function modalDeleteUser(user_to_delete) {
    getUserId();

    if (isValidVariable(user_to_delete)) {

        if (user_id == user_to_delete) {
            showAlertModal('Não é possível excluir seu próprio usuário.');
            return;
        }

        let user_name = $(`table tbody tr[data-id-user="${user_to_delete}"]`).find('.name').text();
        $('#delete_user_modal_item').text(`o(a) usuário(a) ${user_name}?`);
        $('#user_to_delete').val(user_to_delete);
        $('#delete_user_modal').modal('show');
    }
}

function deleteUserComfirmed() {
    let user_id = $('#user_to_delete').val();

    if (isValidVariable(user_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/users/${user_id}`,
            type: 'DELETE',
            success: function (response) {
                $(`table tbody tr[data-id-user="${user_id}"]`).remove();
                $('#delete_user_modal').modal('hide');
                
                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
            }
        }).done(function (response) {
            $('#user_to_delete').val('');
            closeAllModals();
        });
    } else {
        closeAllModals();
        showAlertModal('Usuário inválido! Operação cancelada.');
    }
}
