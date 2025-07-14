const lang = {
    'mark_as_completed': $('.recorded-class-card').attr('data-mark-as-completed-text'),
    'completed': $('.recorded-class-card').attr('data-completed-text'),
    'description': $('.recorded-class-card').attr('data-description-text'),
    'materials': $('.recorded-class-card').attr('data-materials-text'),
    'teacher': $('.recorded-class-card').attr('data-teacher-text'),
}

function selectClass(class_id) {
  //getUserRole();
  //getStudent();
  //loading();

  if (isValidVariable((class_id)) && isValidVariable(user_role) && isValidVariable(student)) {
      $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          url: `/video-course-classes/${class_id}/getVideoClassData`,
          type: 'GET',
          success: function (response) {
            $('#classes_furigana_title').html(response.furigana_title);
            $('#classes_original_title').html(response.original_title);
            $('#classes_translated_title').html(response.translated_title);

            $('.right-side').html(`
                <iframe class="class-video d-block main-video"
                  src="${response.link}"
                  title="Aula 1"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen style="margin-top: 40px !important;"
                ></iframe>

                <div class="d-flex justify-content-between mt-8 mb-7 course-details">
                    <div>
                      <span class="teacher-name">${response.teacher ? `${lang.teacher} ${response.teacher}` : ''}</span>
                    </div>

                    ${user_role != 1 && user_role != 2
                        ?
                        `<div class="d-flex flex-wrap justify-content-md-start justify-content-between align-items-center gap-7 mt-md-0 mt-5">                            
                            <label class="course_item class-finished w-md-auto w-100 justify-content-center ms-auto ${ response.is_done ? 'active' : '' }" for="class_${response.id}_status">
                                <input ${response.is_done ? 'checked' : ''} onclick="markClass(${response.id});" class="markClass d-none ${ response.is_done == 1 ? 'finished-class-checkbox-primary' : 'finished-class-checkbox' }"
                                    type="checkbox" id="class_${response.id}_status">

                                <svg class="checked-icon ${ response.is_done ? '' : 'd-none' }" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="10" fill="white"/>
                                    <path d="M14.6663 6.5L8.24967 12.9167L5.33301 10" stroke="#B4CF04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                <svg class="unchecked-icon ${ response.is_done ? 'd-none' : '' }" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="9.5" stroke="#1B2A2E"/>
                                </svg>

                                <span class="fw-bolder lh-0">
                                    ${ response.is_done ? lang.completed : lang.mark_as_completed }
                                </span>
                            </label>

                            ${
                                response.prev_class_link || response.next_class_link 
                                ?
                                `<div class="d-flex gap-5 ms-auto">
                                    <a href="${response.prev_class_link}" 
                                        class="btn nav-classes p-2 d-flex justify-content-center align-items-center w-45px h-45px ${ response.prev_class_link ? '' : 'disabled' }"
                                    >
                                        <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 1L1 9L9 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>

                                    <a href="${response.next_class_link}" 
                                        class="btn nav-classes p-2 d-flex justify-content-center align-items-center gap-3 px-5 min-w-45px h-45px ${ response.next_class_link ? '' : 'disabled' }"
                                    >
                                        ${response.is_last_of_module ? 'Próximo módulo' : ''}
                                        <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L9 9L1 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>`
                                : ''
                            }
                        </div>
                        `
                        :
                        `<a href="/video-courses/${response.video_course.id}/classes/${response.id}/edit" class="me-3">
                            ${user_role == 1
                                ? '<button class="square-action-btn"><img src="/images/icons/pen.svg" alt="Edit Icon"></button>'
                                : ''
                            }
                        </a>`
                    }

                </div>

                ${ response.description
                    ? 
                    `<h2>${lang.description}</h2>
                    <hr style="border: 2px solid #daeef1c4">
                    <div class="class-description mt-4 mb-9">
                        <pre>${response.description}</pre>
                    </div>`
                    : ''
                }

                ${ response.files.length
                    ?
                    `<h2>${lang.materials}</h2>
                    <hr style="border: 2px solid #daeef1c4">
                    ${response.files.map((file) => {
                        return `
                            <div class="class-material mt-4">
                                <div class="file-list-item d-flex justify-content-between">
                                    <div class="file-icon me-3">
                                        <img height="30" src="/images/icons/file-pdf.svg">
                                    </div>
                                    <div class="file-details w-100">
                                        <b class="d-block">${file.name}</b>
                                        <small class="text-muted">${file.size}</small>
                                    </div>
                                    <div class="file-actions">
                                        <a href="/video-course-files/${file.id}/view" target="_blank">
                                            <div class="btn bg-primary">
                                                <img height="20" src="/images/icons/eye.svg">
                                            </div>
                                        </a>
                                        <a href="/video-course-files/${file.id}">
                                            <div class="btn bg-primary" >
                                                <img height="20" src="/images/icons/download.svg">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join("")}`
                    : ''
                }
            `);

            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(".right-side").offset().top
                }, 1000);
            }
            const btn0 = document.getElementsByClassName("class_name");

            for (var i=0; i<btn0.length; i++) {
                btn0[i].style.color = "#485558";
                console.log(btn0[i]);
              }

            const btn = document.getElementById('class_name_'+class_id);
            btn.style.color = '#32a0ba';
            console.log(btn);
          }
      }).done(function(e) {
          //loading();
      });
  }
}

function selectClassAndScrollTop(classId){
  selectClass(classId);
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function markClass(class_id) {
    getStudent();
    var status = $('.class-finished input').is(':checked');

    if (isValidVariable(student) && isValidVariable(class_id)) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/students/${student}/videoCourseClassView/${class_id}`,
            type: 'PUT',
            success: function (response) {
                let statistics = response.data;

                $('.progress-value').text(`${statistics.progress}%`);
                $('.progress-bar').attr('aria-valuenow', statistics.progress);
                $('.progress-bar').css('width', `${statistics.progress}%`);
                $('.progress-percent').text(`${statistics.progress}%`);

                $(`#class_${class_id}`).attr('checked', statistics.finished);

                $(`input[type='checkbox']#class_${class_id}_status`).prop('checked', statistics.finished);

                if (statistics.finished) {
                    $('.class-finished').addClass('active');
                    $('.class-finished').find('span').text(lang.completed);
                    $('.class-finished').find('.checked-icon').removeClass('d-none');
                    $('.class-finished').find('.unchecked-icon').addClass('d-none');                    
                    $('.class-finished').find('span').text(lang.completed);

                    $('#lesson_complete_student').text(`Parabéns ${response.student_name}!`);

                    if(statistics.progress === 100) {
                        document.getElementById("module_complete_audio").load(); 

                        if (response.progress_course === 100) {
                            $('#lesson_complete_description').text('Você acaba de concluir um curso Melis Education! ');
    
                            document.getElementById("course_complete_audio").load();
                        }

                        $("#lesson_completed_modal").on('shown.bs.modal', function () {
                            var audio;
    
                            $("audio").each(function () {
                                this.pause();
                                this.currentTime = 0;  // Reiniciar o áudio
                            });

                            audio = document.getElementById("module_complete_audio");
                            
                            if (response.progress_course === 100) {
                                audio = document.getElementById("course_complete_audio");
                            }                            
    
                            audio.play();
                        });

                        $("#lesson_completed_modal").modal("show");
                    }                                                       
                    
                } else {
                    $('.class-finished').removeClass('active');
                    $('.class-finished').find('.checked-icon').addClass('d-none');
                    $('.class-finished').find('.unchecked-icon').removeClass('d-none');
                    $('.class-finished').find('span').text(lang.mark_as_completed);
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