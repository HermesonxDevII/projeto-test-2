function modalDeleteCalendar(id){
    if(isValidVariable(id)) {
        let calendar_name = $(`table tbody tr[data-id-calendar="${id}"]`).find('.title_calendar').text();
        $('#delete_calendar_modal_item').text(`O calendário ${calendar_name}?`);
        $('#calendar_to_delete').val(id);
        $('#delete_calendar_modal').modal('show');
    }
}

$(document).on('click', '.modal-confirm-button', function() {
    let id = $('#calendar_to_delete').val();
    $('.modal-confirm-button').addClass('disabled');
    if (isValidVariable(id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/calendars/${id}`,
            type: 'DELETE',
            success: function (response) {
                $(`table tbody tr[data-id-calendar="${id}"]`).remove();
                $('#delete_calendar_modal').modal('hide');
                notify(response.msg, response.icon);
                $('#calendar_to_delete').val('');
                $('.modal-confirm-button').removeClass('disabled');
                closeAllModals();
            },
            error: function (error) {
                console.log(error);
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                $('.modal-confirm-button').removeClass('disabled');
                closeAllModals();
            }
        });

    }
})
