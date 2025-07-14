function addModule() {
  let module_name = $('#module_name').val(),
      module_id = Date.now();

  if (isValidVariable(module_name)) {
      $('.modules').append(`
          <div class="row mt-8 align-items-end" id="module_${module_id}">
              <div class="col-lg-8 col-md-8 col-sm-12 pe-3">
                  <label for="module_name_${module_id}">Nome</label>
                  <input type="text" class="form-control module" id="module_name_${module_id}" name="video_course_modules[${module_id}]" value="${module_name}"
                      placeholder="Insira o nome do módulo...">
              </div>
              <div class="col-4 d-flex justify-content-end">
                  <a class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center"
                      onclick="removeModule('${module_id}')" style="width: 155px; height: 49px;">
                      Excluir
                  </a>
              </div>
          </div>
      `);

      $('#module_name').val('');
  } else {
      showAlertModal("Informe o nome do módulo para adicioná-lo.");
  }
}

function removeModule(module_id) {
  if (isValidVariable(module_id)) {
      $(`#module_${module_id}`).fadeOut();
  }
}

$('.switch-tab-btn').click(function () {
  let id_tab = $(this).attr('data-id-tab');

  $(this).closest('.progress-tab').addClass('d-none');

  $(`#${id_tab}`).removeClass('d-none');
});