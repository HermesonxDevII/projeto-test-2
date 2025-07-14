const video_course_id = $('#video_course_id').val();

function deleteModuleModal(module_id) {
  if (isValidVariable(module_id)) {
      $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          url: `/video-course-modules/${module_id}/getBasicData`,
          type: 'GET',
          success: function (response) {
              if (isValidVariable(response.id)) {
                  let modal = $('#delete_module_modal');

                  modal.find('#delete_module_modal_item').text(`O módulo ${response.name}? `)
                      .append(`Este módulo possui ${response.classes_count} aulas cadastradas!`);
                  modal.find('#module_to_delete').val(response.id);
                  modal.modal('show');
              }
          }
      });
  } else {
      closeAllModals();
      showAlertModal('Módulo inválido! Operação cancelada.');
  }
}

function deleteModuleConfirmed() {
  let module_id = $('#module_to_delete').val();

  if (isValidVariable(module_id)) {
      $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          url: `video-courses/${video_course_id}/modules/${module_id}`,
          type: 'DELETE',
          success: function (response) {
              let modal = $('#delete_module_modal');
              modal.find('#module_to_delete').val('');

              $(`#module_item_${module_id}`).fadeOut();
              modal.modal('hide');

          },
          error: function (error) {
              window.location.reload();
              closeAllModals();
          }
      });
  } else {
      closeAllModals();
      showAlertModal('Módulo inválido! Operação cancelada.');
  }
}

function deleteClassModal(class_id) {
    if (isValidVariable(class_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/video-course-classes/${class_id}/getBasicData`,
            type: 'GET',
            data: {
                'class': class_id
            },
            success: function (response) {
                if (isValidVariable(response.id)) {
                    let modal = $('#delete_class_modal');

                    modal.find('#delete_class_modal_item').text(`${response.original_title}?`);
                    modal.find('#class_to_delete').val(response.id);
                    modal.modal('show');
                }
            },
            error: function () {
                notify('Não foi possível obter as informações solicitadas.', 'error');
            }
        });
    } else {
        closeAllModals();
        showAlertModal('Aula inválida! Operação cancelada.');
    }
}

function deleteClassConfirmed() {
    let class_id = $('#class_to_delete').val();

    if (isValidVariable(class_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `video-courses/${video_course_id}/classes/${class_id}`,
            type: 'DELETE',
            success: function (response) {
                let modal = $('#delete_class_modal');
                modal.find('#class_to_delete').val('');
                modal.modal('hide');
                window.location.reload();
            }
        });
    } else {
        closeAllModals();
        showAlertModal('Aula inválida! Operação cancelada.');
    }
}