var deleted_schedules = [];

$('.edit-student-tab, .edit-schedule-tab').click(function (e) {
    let id_tab = $(this).attr('data-id-tab');
    $('.edit-student-tab').each((index, value) => {
        let tab = $(value).attr('data-id-tab');
        $(`#${tab}`).addClass('d-none');
        $(value).removeClass('student-active-tab');
    });

    $(`#${id_tab}`).removeClass('d-none');
    $(this).addClass('student-active-tab');
});

$('#student_status').on('change', function () {
    let label = $('#label_student_status');
    if ($(this).is(':checked')) {
        label.text('Ativo');
    } else {
        label.text('Desativado');
    }
});

$('.next-tab-btn').click(function () {
    let id_tab = $(this).attr('data-id-tab');
    $('.edit-student-tab').each((index, value) => {
        let tab = $(value).attr('data-id-tab');
        $(`#${tab}`).addClass('d-none');
        $(value).removeClass('student-active-tab');
    });

    $(`#${id_tab}`).removeClass('d-none');
    $('.edit-schedule-tab').addClass('student-active-tab');
});

function AddScheduleRow(FromEdit = false) {
    if(!ValidateSchedule()) {
        showAlertModal(`Para prosseguir, preencha todos os campos e selecione pelo menos um dia da semana.
            O Horário do fim da aula deve ser maior que a de início.`);
        return;
    }

    let ScheduleRowId = Date.now().toString(),
        originalScheduleRow = $('.base-schedule-row'),
        clonedScheduleRow = $('.base-schedule-row').clone().remove('#addNewSchedule'),
        additionalScheduleRows = $('.additional-schedule-rows');

    clonedScheduleRow.attr('data-id-schedule-row', ScheduleRowId);

    // Adding values (only for selects)
    originalScheduleRow.find('select').each(function (i) {
        clonedScheduleRow.find('select').eq(i).val(
            $(this).val()
        );
    });

    clonedScheduleRow.find('.add-new-col').append(`
        <a onclick="RemoveScheduleRow('${ScheduleRowId}', ${FromEdit})" class="btn default-btn text-white bg-danger m-1 w-100 mb-8 removeSchedule">
            Apagar
        </a>
    `);

    // Make unique input label and names for each new cloned input
    clonedScheduleRow.find('input, select','label').each(function() {
        let idAttr;
        let nameAttr = $(this).attr('name').replaceAll('[id]', `[${ScheduleRowId}]`).replaceAll('_id_', `_${ScheduleRowId}_`);

        // We use those hidden inputs to send 'value:off' to server when the checkbox is unchecked.
        if ($(this).attr('type') != 'hidden') {
            idAttr = $(this).attr('id').replaceAll('[id]', `[${ScheduleRowId}]`).replaceAll('_id_', `_${ScheduleRowId}_`);
        }

        $(this).attr('name', nameAttr);
        $(this).attr('id', idAttr);
    });

    // Make unique label ids for each new cloned input
    clonedScheduleRow.find('label').each(function() {
        let forAttr = $(this).attr('for').replaceAll('[id]', `[${ScheduleRowId}]`).replaceAll('_id_', `_${ScheduleRowId}_`);
        $(this).attr('for', forAttr);
    });

    clonedScheduleRow.prepend('<hr class="hr-divider" />');
    clonedScheduleRow.appendTo(additionalScheduleRows);

    // Cleaning the cloned divs
    additionalScheduleRows.find('#addNewSchedule').remove();
    additionalScheduleRows.find('.base-schedule-row').each(function (i, e) {
        $(e).removeClass('base-schedule-row');
    });

    ClearBaseScheduleFields();
}

function RemoveScheduleRow(ScheduleRowId, FromEdit = false) {
    $(`div[data-id-schedule-row="${ScheduleRowId}"]`).remove();

    if(!FromEdit) {
        deleted_schedules.push(ScheduleRowId);
        $('#deleted_schedules').val(deleted_schedules.join(','));
    }
}

function SubmitForm() {
    let form = $('#classroom_form'),
        additionalScheduleRows = $('.additional-schedule-rows .row'),
        method = $('input[name="_method"').val();

    if (additionalScheduleRows.length == 0 && method == 'POST') {
        showAlertModal("Você precisa criar pelo menos um horário de aula em um dia da semana.");
        return;
    }

    if (BaseFieldsHasValue()) {
        showAlertModal("Você tem aulas não adicionadas. Adicione-as antes de prosseguir.");
        return;
    }

    // Remove names from base schedule
    $('.base-schedule-row').find('input, select').each(function() {
        $(this).removeAttr('name');
        $(this).attr('disabled', true);
    });

    loading();
    form.submit();
}

function ValidateSchedule() {
    // base-schedule-row ONLY validations.
    let formBase = $('.base-schedule-row'),
        scheduleFields = formBase.find('input,select').not('#class_link'),
        scheduleWeekdays = formBase.find('input:checked'),
        valid = true;

    scheduleFields.each(function() {
        if (!isValidVariable($(this).val())) {
            valid = false;
        }
    });

    if (formBase.find('#class_start').val() >= formBase.find('#class_end').val()) {
        valid = false;
    }

    if (scheduleWeekdays.length == 0) {
        valid = false;
    }

    return valid;
}

function ClearBaseScheduleFields() {
    $('.base-schedule-row').find('input[type="text"],input[type="time"], select').each((i, e) => {
        $(e).val('');
    });

    $('.base-schedule-row').find('input[type="checkbox"]').each((i, e) => {
         $(e).prop('checked',false);
    });
}

function BaseFieldsHasValue() {
    let hasValue = false;

    $('.base-schedule-row').find('input[type="text"],input[type="time"], select').each((i, e) => {
        if (isValidVariable($(e).val())) {
            hasValue = true;
        }
    });

    $('.base-schedule-row').find('input[type="checkbox"]').each((i, e) => {
        if (isValidVariable($(e).prop('checked'))) {
            hasValue = true;
        }
    });

    return hasValue;
}

$('#classroom_thumbnail').on('change', function () {
    console.log('pegou o #classroom_thumbnail');
    readURL(this);
});

function readURL(input) {
    console.log('entrou na função readURL');
    if (input.files && input.files[0]) {
        console.log('entrou no if');
        let reader = new FileReader();
        reader.onload = function (e) {
            console.log('entrou no reader.onload');
            $('#classroom_thumbnail_upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        console.log(reader);
    }
}
