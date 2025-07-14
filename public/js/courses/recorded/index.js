const lang = {
    'complete_lesson': $('.recorded-class-card').attr('data-complete-lesson-text'),
    'description': $('.recorded-class-card').attr('data-description-text'),
    'materials': $('.recorded-class-card').attr('data-materials-text'),
    'teacher': $('.recorded-class-card').attr('data-teacher-text'),
}

function editModuleModal(module_id) {
    if (isValidVariable(module_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/modules/${module_id}/getBasicData`,
            type: 'GET',
            data: {
                'module': module_id
            },
            success: function (response) {
                if (isValidVariable(response.id)) {
                    let modal = $('#edit_module_modal');
                    modal.find('#module_name').val(response.name);
                    modal.find('#module_id').val(response.id);
                    modal.modal('show');
                }
            }
        });
    } else {
        closeAllModals();
        showAlertModal('Módulo inválido! Operação cancelada.');
    }
}

function editModule() {
    let modal = $('#edit_module_modal'),
        module_id = modal.find('#module_id').val(),
        module_name = modal.find('#module_name').val();

    if (isValidVariable(module_id) && isValidVariable(module_name)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/modules/${module_id}`,
            type: 'PUT',
            data: {
                'name': module_name
            },
            success: function (response) {
                $(`#module_name_${module_id}`).text(
                    module_name
                ).css('textTransform', 'capitalize');
                modal.modal('hide');

                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            }
        });
    } else {
        closeAllModals();
        showAlertModal('Módulo inválido! Operação cancelada.');
    }
}

function deleteModuleModal(module_id) {
    if (isValidVariable(module_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/modules/${module_id}/getBasicData`,
            type: 'GET',
            data: {
                'module': module_id
            },
            success: function (response) {
                if (isValidVariable(response.id)) {
                    let modal = $('#delete_module_modal');

                    modal.find('#delete_module_modal_item').text(`O módulo ${response.name}? `)
                        .append(`Este módulo possui ${response.courses_count} aulas cadastradas!`);
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
            url: `/modules/${module_id}`,
            type: 'DELETE',
            data: {
                'module': module_id
            },
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

function deleteCourseModal(course_id) {
    if (isValidVariable(course_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/courses/${course_id}/getBasicData`,
            type: 'GET',
            data: {
                'course': course_id
            },
            success: function (response) {
                if (isValidVariable(response.id)) {
                    let modal = $('#delete_course_modal');

                    modal.find('#delete_course_modal_item').text(`A aula ${response.name}?`);
                    modal.find('#course_to_delete').val(response.id);
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

function deleteCourseConfirmed() {
    let course_id = $('#course_to_delete').val();

    if (isValidVariable(course_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/courses/${course_id}`,
            type: 'DELETE',
            data: {
                'course': course_id
            },
            success: function (response) {
                let modal = $('#delete_course_modal');
                modal.find('#course_to_delete').val('');
                modal.modal('hide');
                window.location.reload();
            }
        });
    } else {
        closeAllModals();
        showAlertModal('Aula inválida! Operação cancelada.');
    }
}

//loading();
function selectCourse(course_id) {

    if (isValidVariable((course_id)) && isValidVariable(user_role) && isValidVariable(student)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/courses/${course_id}/getBasicData`,
            type: 'GET',
            success: function (response) {
                $('.right-side').html(`
                    ${response.link != ""
                        ?
                        `<iframe class="class-video d-block main-video" src="${response.link}"
                                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture
                                allowfullscreen" style="margin-top: 40px !important;">
                        </iframe>`

                        :
                        `<div class="embed-iframe">
                            ${response.embed_code}
                        </div>`
                    }

                    <div class="d-flex justify-content-between mt-8 course-details">
                        <div>
                            <div class="align-items-center">
                                <span style="font-size:15px; font-weight: bolder; color:#329fba;">${(response.recorded_at_formatted ? response.recorded_at_formatted : '')}</span>
                                <h1 class="course_name_active" style="margin-top:4px !important; margin-bottom: 7px !important">${response.name}</h1>
                            </div>
                            <span class="teacher-name">${lang.teacher} ${response.teacher.name}</span>
                        </div>

                        ${!user_role.includes(1) && !user_role.includes(2)
                            ?
                            `<label for="course_${response.id}_status" class="course_item btn course-finished px-4 ${ response.is_done ? 'bg-primary' : '' }">
                                <input ${response.is_done ? 'checked' : ''} onclick="markCourse(${response.id});" class="markCourse ${ response.is_done == 1 ? 'finished-class-checkbox-primary' : 'finished-class-checkbox' }"
                                    type="checkbox" id="course_${response.id}_status">
                                <span class="text-white">${lang.complete_lesson}</span>
                            </label>`
                            :
                            `<div class="d-flex">
                                <a href="/classrooms/${response.classroom.id}/courses/${response.id}/edit" class="me-3">
                                    <button class="square-action-btn">
                                        <img src="/images/icons/pen.svg" alt="Edit Icon">
                                    </button>
                                </a>
                                <button href="" class="square-action-btn" onclick="deleteCourseModal(${response.id});">
                                    <img src="/images/icons/trash.svg" alt="Delete Icon">
                                </button>
                            </div>`
                        }

                    </div>

                    ${ response.materials.length != 0 && response.description ?
                        `<nav class="mt-5">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <span class="nav-link active tab-title" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                                    ${lang.description}
                                </span>
                                ${ response.materials.length != 0
                                    ?
                                    `<span class="nav-link tab-title" id="materials-tab" data-toggle="tab" href="#materials" role="tab" aria-controls="materials" aria-selected="true">
                                        ${lang.materials}
                                    </span>`
                                    : ''
                                }
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="class-description mt-4">
                                    <pre>${response.description}</pre>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                ${response.materials.map((material) => {
                                    return `
                                        <div class="class-material mt-4">
                                            <div class="file-list-item d-flex justify-content-between">
                                                <div class="file-icon me-3">
                                                    <img height="30" src="/images/icons/file-pdf.svg">
                                                </div>
                                                <div class="file-details w-100">
                                                    <b class="d-block">${material.file.name}</b>
                                                    <small class="text-muted">${material.file.size}</small>
                                                </div>
                                                <div class="file-actions">
                                                    <a href="/file/material/${material.file_id}/view" target="_blank">
                                                        <div class="btn bg-primary">
                                                            <img height="20" src="/images/icons/eye.svg">
                                                        </div>
                                                    </a>
                                                    <a href="/file/material/${material.file_id}">
                                                        <div class="btn bg-primary" >
                                                            <img height="20" src="/images/icons/download.svg">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }).join("")}
                            </div>
                        </div>` :
                        ''
                    }

                    ${ response.materials.length == 0 && response.description ?
                        `<nav class="mt-5">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <span class="nav-link active tab-title" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                                    ${lang.description}
                                </span>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="class-description mt-4">
                                    <pre>${response.description}</pre>
                                </div>
                            </div>
                        </div>` :
                        ''
                    }

                    ${ response.materials.length != 0 && response.description == '' ?
                        `<nav class="mt-5">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                ${ response.materials.length != 0
                                    ?
                                    `<span class="nav-link active tab-title" id="materials-tab" data-toggle="tab" href="#materials" role="tab" aria-controls="materials" aria-selected="true">
                                        ${lang.materials}
                                    </span>`
                                    : ''
                                }
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                ${response.materials.map((material) => {
                                    return `
                                        <div class="class-material mt-4">
                                            <div class="file-list-item d-flex justify-content-between">
                                                <div class="file-icon me-3">
                                                    <img height="30" src="/images/icons/file-pdf.svg">
                                                </div>
                                                <div class="file-details w-100">
                                                    <b class="d-block">${material.file.name}</b>
                                                    <small class="text-muted">${material.file.size}</small>
                                                </div>
                                                <div class="file-actions">
                                                    <a href="/file/material/${material.file_id}/view" target="_blank">
                                                        <div class="btn bg-primary">
                                                            <img height="20" src="/images/icons/eye.svg">
                                                        </div>
                                                    </a>
                                                    <a href="/file/material/${material.file_id}">
                                                        <div class="btn bg-primary" >
                                                            <img height="20" src="/images/icons/download.svg">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }).join("")}
                            </div>
                        </div>` :
                        ''
                    }


                `);
                if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $(".right-side").offset().top
                    }, 1000);
                }
                const btn0 = document.getElementsByClassName("course_name");

                for (var i=0; i<btn0.length; i++) {
                    btn0[i].style.color = "#485558";
                  }

                const btn = document.getElementById('course_name_'+course_id);
                btn.style.color = '#32a0ba';
            }
        }).done(function(e) {
            //loading();
        });
    }
}

function markCourse(course_id) {
    getStudent();

    let classroom_id = $('#classroom_id').val(),
        status = $('.course-finished input').is(':checked'),
        url = '';

    status ? url = 'markCourseAsDone' : url = 'unmarkCourseAsDone';
    if (isValidVariable(student) && isValidVariable(course_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/students/${url}`,
            type: 'POST',
            data: {
                'student_id': student,
                'course_id': course_id,
                'classroom_id': classroom_id
            },
            success: function (response) {
                let statistics = response.data;

                $('.progress-value').text(`${statistics.percentage}%`);
                $('.progress-bar').attr('aria-valuenow', statistics.percentage);
                $('.progress-bar').css('width', `${statistics.percentage}%`);

                $(`input[type='checkbox']#course_${course_id}`).prop('checked', status);
                status ? $('#materials-tab').trigger('click') : $('#description-tab').trigger('click');

                if (status) {
                    $('.course-finished').addClass('bg-primary');
                    $('.markCourse').removeClass('finished-class-checkbox').addClass('finished-class-checkbox-primary');
                } else {
                    $('.course-finished').removeClass('bg-primary');
                    $('.markCourse').addClass('finished-class-checkbox').removeClass('finished-class-checkbox-primary');;
                }

                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
            }
        }).done(function(response) {
            closeAllModals();
        });
    }
}

function toggleModules() {
    $('.toggle-modules').toggleClass('rotate-180');
    $('#accordionModules').slideToggle('slow');
}

$('.accordion-collapse').on('show.bs.collapse', function () {
    $(this).parent().find('.course-actions').removeClass('collapsed');
})
$('.accordion-collapse').on('hide.bs.collapse', function () {
    $(this).parent().find('.course-actions').addClass('collapsed');
})
