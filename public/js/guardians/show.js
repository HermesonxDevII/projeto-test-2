$(document).on('click','.btn-access', function(){
    $('#send_access_guardian_modal').modal('show');
})

$(document).on('click', '#btn_guardian_access_send', function(){
    let guardian_id = $('#guardian_to_send_access').val();
    if (isValidVariable(guardian_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/guardians/${guardian_id}/sendAccess`,
            type: 'POST',
            data: {id: guardian_id},
            success: function (response) {
                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
            }
        });
        closeAllModals();
    }
})
