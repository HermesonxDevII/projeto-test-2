$(document).on('click','#finish_button', function () {

    let form = $('#calendar_form');
    let embed = $('#embed_code').val(),
        title = $('#title').val().length;

    if (embed.length == 0 || title == 0 || !validateHTML(embed)) {
        showAlertModal(`Você precisa inserir um título e um código embed do Genially válido antes de salvar um calendário.`);
        return;
    }

    let grade_selected=false;
    $("#calendar_form").find('input.grade_select').each( function(){
        if($(this).is(':checked')){
            grade_selected=true;
        }
    })

    if(grade_selected==false){
        showAlertModal(`Você precisa selecionar ao menos uma série antes de salvar um calendário.`);
        return;
    }

    form.submit();
});

$(document).ready(function() {
    $('#embed_code').on('change keyup keydown focusin focusout', function(e) {
        if ($('#embed_code').val() == "") {
            $('#embed_code').removeClass('is-valid').removeClass('is-invalid');
        } else if (!validateHTML(e.target.value)) {
            $('#embed_code').removeClass('is-valid').addClass('is-invalid');
        } else {
            $('#embed_code').removeClass('is-invalid').addClass('is-valid');
        }
    });
})
