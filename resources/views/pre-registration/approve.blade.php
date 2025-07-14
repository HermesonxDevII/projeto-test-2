@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Editar Aluno
@endsection

@section('content')
    <style>
        #result_tab span {
            color: var(--colors-neutral-gray-80, #485558);
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
        }

        .pr-87 {
            padding-right: 87px !important;
        }
    </style>
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Aprovar Aluno</h1>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="table-container p-0">
                    <div id="classroom_tab" class="mt-3 hide" data-tab-num="2">
                        <h1>Turmas</h1>
                        <div class="row mt-8 align-items-center">
                            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                <label for="classroom">{{ __('Turmas') }}</label>
                                <select class="form-select @error('student.classrooms') is-invalid @enderror" id="classroom"
                                    aria-describedby="student_classroom_feedback">
                                    <option value="" selected>Selecione...</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">
                                            {{ $classroom->formatted_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('student.classrooms')
                                    <div id="student_classroom_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                <a class="btn bg-primary btn-shadow text-white add-classroom"
                                    style="width: 136px; height: 49.75px; margin-top: 23px;" onclick="addClassroom();">
                                    <span class="d-flex align-items-center h-100 justify-content-center">Adicionar</span>
                                </a>
                            </div>

                            <div class="table-responsive my-4">
                                <table class="table table-curved d-none" id="student_classrooms">
                                    <thead>
                                        <tr>
                                            <th>Turma</th>
                                            <th>Qtd. Alunos</th>
                                            <th>Aulas</th>
                                            <th>Data de Início</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="course_tab" class="mt-3">
                        <h1>Cursos</h1>
                        <div class="row mt-8 align-items-center">
                            <!-- Seleção de cursos -->
                            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                <label for="course">{{ __('Cursos') }}</label>
                                <select class="form-select @error('student.courses') is-invalid @enderror" id="course"
                                    aria-describedby="student_course_feedback">
                                    <option value="" selected>Selecione...</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>

                                @error('student.courses')
                                    <div id="student_course_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Botão para adicionar o curso -->
                            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                <button class="btn bg-primary btn-shadow text-white"
                                    style="width: 136px; height: 49.75px; margin-top: 23px;" onclick="addCourse();">
                                    <span class="d-flex align-items-center h-100 justify-content-center">Adicionar</span>
                                </button>
                            </div>

                            <!-- Tabela de cursos selecionados -->
                            <div class="table-responsive my-4">
                                <table class="table table-curved d-none" id="student_courses">
                                    <thead>
                                        <tr>
                                            <th>Curso</th>
                                            <th>Qtd. Alunos</th>
                                            <th>Data de Início</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div id="result_tab" class="mt-3 hide d-none" data-tab-num="3">
                        <div>
                            <div class="text-center">
                                <img src="{{ asset('images/icons/success.svg') }}" alt="success">
                                <h2 class="my-6">Aluno adicionado com sucesso!</h2>
                            </div>

                            <div class="p-8 d-flex justify-content-between align-items-center"
                                style="border: 1px solid lightgray; border-radius: 8px">
                                <div class="d-flex text-left justify-content-between pr-87" style="width: 100% !important;">
                                    <div>
                                        <span>Nome do Aluno</span>
                                        <p class="m-0" id="student_name" style="color: #8C9497;"></p>
                                    </div>
                                    <div>
                                        <span>Planos e aulas</span>
                                        <p class="m-0" id="grade_name" style="color: #8C9497;"></p>
                                    </div>
                                    <div>
                                        <span>Dias das aulas</span>
                                        <p class="m-0" id="weekDays" style="color: #8C9497;"></p>
                                    </div>
                                    <div>
                                        <span>Turmas/Cursos</span>
                                        <p class="m-0" id="classrooms" style="color: #8C9497;"></p>
                                    </div>
                                </div>
                                <div>
                                    <a id="view-student"
                                        class="btn bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 155px; height: 40px; line-height: 0px;">
                                        Ver Aluno
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center"
                                style="width: 100%; padding: 45px 0px 20px 0px">
                                <button id="sendWelcomeBtn" class="btn bg-primary btn-shadow text-white"
                                    style="padding: 10px 30px;">
                                    Enviar boas vindas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-end mt-5">
        <button onclick="saveNewStudent()" class="btn bg-primary btn-shadow text-white m-1 finish"
            style="width: 136px; height: 40px;">
            Salvar
        </button>
    </div>

    <div class="modal fade" id="send_welcome_modal" tabindex="-1" role="dialog" aria-labelledby="SendWelcomeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="student_id">
                        <img src="{{ asset('images/icons/send-2.svg') }}" alt="send" class="my-2">
                        <h3 class="my-3">Você tem certeza que gostaria de enviar as boas vindas?</h3>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="send_welcome_btn" type="button"
                        class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>ENVIAR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/students/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#sendWelcomeBtn').on('click', function() {
                $('#send_welcome_modal').modal('show');
            });
        });

        function saveNewStudent() {
            var classroomIds = [];
            var courseIds = [];

            $('tr[data-id-classroom]').each(function() {
                var idValue = $(this).data('id-classroom');
                classroomIds.push(idValue);
            });

            $('tr[data-id-course]').each(function() {
                var idValue = $(this).data('id-course');
                courseIds.push(idValue);
            });

            var preRegistrationId = {{ $preRegistration->id }};

            var data = {
                'classrooms': classroomIds,
                'courses': courseIds,
                'preRegistrationId': preRegistrationId
            };

            $.ajax({
                type: "POST",
                url: "/preRegistrations/approveStore",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#classroom_tab').addClass('d-none');
                        $('#course_tab').addClass('d-none');

                        $('#student_name').text(response.student_name);
                        $('#grade_name').text(response.grade_name);
                        $('#weekDays').text(response.weekDays);
                        $('#classrooms').text(response.classroom_names);

                        $('#student_id').val(response.student_id);

                        $('#view-student').attr('href', 'students/' + response.student_id);

                        $('#result_tab').removeClass('d-none');
                        $('.finish').addClass('d-none');
                    } else {
                        notify(response.message, 'error');
                    }
                }
            });
        }

        $('#send_welcome_btn').on('click', function() {
            data = {
                'student_id': $('#student_id').val(),
            }

            $.ajax({
                type: "POST",
                url: "/preRegistrations/sendWelcome",
                data: data,
                dataType: "json",
                success: function(response) {
                    $('#send_welcome_modal').modal('hide');
                    notify(response.msg, response.icon)
                }
            });
        })

        function showCourseOption(id) {
            if (isValidVariable(id)) {
                $(`#course option[value="${id}"]`).prop('disabled', false).show();
                $('#course').val('');
            }
        }

        function hideCourseOption(id) {
            if (isValidVariable(id)) {
                $(`#course option[value="${id}"]`).prop('disabled', true).hide();
                $('#course').val('');
            }
        }

        function removeCourse(element) {
            if (isValidVariable(element)) {
                let row = $(`#student_courses tbody tr[data-id-course="${element}"]`);
                row.remove();
                showCourseOption(row.data('id-course'));
            }
        }

        function getCourses() {
            let coursesIds = [];

            $('#student_courses tbody tr').each((index, value) => {
                coursesIds.push($(value).data('id-course'));
            });

            return coursesIds;
        }

        function addCourse() {
            let course = $('#course').val();

            if (isValidVariable(course)) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/video-courses/getBasicData`,
                    type: 'POST',
                    data: {
                        'id': course
                    },
                    success: function(response) {
                        $("#student_courses tbody").append(`
                            <tr class="align-middle" data-id-course="${response.id}">
                                <td>${response.name}</td>
                                <td>${response.students} Alunos</td>
                                <td>${moment(response.created_at).format('D/MM/YYYY, h:mm')}</td>
                                <td>
                                    <button class="btn btn-action text-white" onclick="removeCourse('${response.id}');">
                                        <img src="/images/icons/trash.svg" alt="">
                                    </button>
                                </td>
                            </tr>
                        `);

                        hideCourseOption(response.id);

                        if (!$('#student_courses').is(':visible')) {
                            $('#student_courses').removeClass('d-none');
                        }
                    }
                });
            } else {
                showAlertModal('Selecione um curso para adicioná-lo ao aluno(a).');
            }
        }
    </script>
@endsection
