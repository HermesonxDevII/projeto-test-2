function RemoveCourse(id) {
    $.ajax({
        method: 'DELETE',
        url: `/courses/${id}`,
        success: function(res) {
        },
        error: function(e) {
            console.log('error');
        }
    });
}

function SaveCourse() {
    let createForm = $('.base-schedule-row').find('input,select').serializeArray();
    createForm.push({name: 'teacher_id', value: $('#teacher_id').val()});

    $.post({
        url: '/courses',
        data: createForm,
        success: function(res) {
            AddScheduleRow(true, res.id);
        },
        error: function(res) {
            showAlertModal('Não foi possível registrar as informações da turma.');
        }
    })
}
