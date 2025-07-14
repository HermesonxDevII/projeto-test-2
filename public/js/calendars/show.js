$(document).on('click', '.link-calendar', function(){

    let url = $(this).attr('href');

    if (isValidVariable(url)) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('.embed-iframe').children().remove();
                $('.embed-iframe').append(response.calendar.embed_code);
            },
            error: function (error) {
                console.log(error);
                let data = error.responseJSON;
                notify(data.msg, data.icon);
            }
        });
    }
})
