function controlsTableVisibility() {
    let table = $('#student_classrooms');
    table.is(':visible') == true ? table.addClass('d-none') : table.removeClass('d-none');
}

function fillUserData(response) {
    $('#guardian_email').val(response.email);
    if($('#guardian_name').val()==="") $('#guardian_name').val(response.name).prop('disabled', true);
    if($('#guardian_phone_number').val()==="") $('#guardian_phone_number').val(response.phone_number).prop('disabled', true);
    if($('#guardian_id').val()==="") $('#guardian_id').val(response.id);
    if($('#zip_code').val()==="") $('#zip_code').val(response.address[0].zip_code).prop('disabled', true);
    if($('#province').val()==="") $('#province').val(response.address[0].province).prop('disabled', true);
    if($('#city').val()==="")     $('#city').val(response.address[0].city).prop('disabled', true);
    if($('#district').val()==="") $('#district').val(response.address[0].district).prop('disabled', true);
    if($('#number').val()==="")   $('#number').val(response.address[0].number).prop('disabled', true);
    if($('#complement').val()==="") $('#complement').val(response.address[0].complement).prop('disabled', true);
    if($('#login').val()==="")    $('#login').val(response.email).prop('disabled', true);
    // $('#password, #password_confirmation').val('****').prop('disabled', true);
}

function clearUserData() {
    $(`#guardian_name,
       #guardian_phone_number,
       #guardian_id,
       #zip_code,
       #province,
       #city,
       #district,
       #number,
       #complement,
       #login,
       #password,
       #password_confirmation`)
    .val('').prop('disabled', false);
}

function checkUserExists() {
    let guardianEmail = $('input[name="guardian[email]"]').val();

    if (isValidVariable(guardianEmail)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/users/getUser`,
            type: 'POST',
            data: {
                'email': guardianEmail
            },
            success: function (response) {
                if (isValidVariable(response)) {
                    fillUserData(response);
                }
                // else {
                //      clearUserData();
                // }
            }
        });
    }
}

$('document').ready(function () {
    $('.back').on('click', function () {
        let tabId = $('.visible').attr('id'),
            tabNum = $('#' + tabId).attr('data-tab-num');

        if (tabNum > 1) {
            if (tabNum != 2) {
                $('.finish').addClass('d-none');
                $('.next').show();
            }
            $('#' + tabId).removeClass('visible').addClass('d-none');
            $(`[data-tab-num="${parseInt(tabNum) - 1}"]`).removeClass('d-none').addClass('visible');
        }  else {
            history.back();
        }
    });

    $('.next').on('click', function () {
        let tabId = $('.visible').attr('id'),
            tabNum = $('#' + tabId).attr('data-tab-num');

        if (tabNum < 3) {
            if (tabNum == 2) {
                $('.next').hide();
                $('.finish').removeClass('d-none');
            }
            $('#' + tabId).removeClass('visible').addClass('d-none');
            $(`[data-tab-num="${parseInt(tabNum) + 1}"]`).removeClass('d-none').addClass('visible');
        }
    });

    $('input[name="guardian[email]"]').keyup(function() {
        clearTimeout($.data(this, 'timer'));
        let wait = setTimeout(checkUserExists, 1500);
        $(this).data('timer', wait);
    });

    $("body").keypress(function (e) {
        let key = e.which;
            if (key == 13) {
            $('.next').trigger('click');
        }
    });
});
