<form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" id="classroom_form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" id="deleted_schedules" name="deleted_courses"/>
    {{-- First tab --}}
    <div id="first-tab">
        <div id="classroom_info_tab" class="visible" data-tab-num="1">
            <h1>Preencha o formulário</h1>
            <div class="row mt-8">
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <label for="classroom_name">Nome da Turma</label>
                    <input type="text" class="form-control @error('classroom.name') is-invalid @enderror"
                        id="classroom_name" name="classroom[name]" aria-describedby="classroom_name_feedback"
                        placeholder="Insira o nome da turma..." value="{{ old('classroom.name', $classroom->name) }}" required>

                    @error('classroom.name')
                        <div id="classroom_name_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12 mt-8">
                    <label for="classroom_description">Descrição</label>
                    <input type="text" class="form-control @error('classroom.description') is-invalid @enderror"
                        id="classroom_description" name="classroom[description]"
                        aria-describedby="classroom_description_feedback" placeholder="Insira a descrição..."
                        value="{{ old('classroom.description', $classroom->description) }}" required>

                    @error('classroom.description')
                        <div id="classroom_description_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-10 mt-8 pe-3">
                    <label for="evaluation_model_id">Modelo de avaliação</label>
                    <select class="form-select @error("classroom.evaluation_model_id") is-invalid @enderror" id="evaluation_model_id"
                        name="classroom[evaluation_model_id]" aria-describedby="live_evaluation_model_feedback">
                        <option value="">Selecione...</option>
                        @foreach ($evaluationModels as $evaluation_models)
                            <option value="{{ $evaluation_models->id }}" @selected($classroom->evaluation_model_id == $evaluation_models->id)>
                                {{ $evaluation_models->title }}
                            </option>
                        @endforeach
                    </select>

                    @error("classroom.evaluation_model_id")
                        <div id="live_evaluation_model_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-10 mt-8 pe-3">
                    <label for="classroom_thumbnail">Thumbnail 300x246 - até 650 kb</label>
                    <input type="file" accept="image/*" class="form-control @error ('classroom.thumbnail') is-invalid @enderror"
                        id="classroom_thumbnail" name="classroom[thumbnail]"
                        aria-describedby="classroom_thumbnail_feedback" >

                    @error('classroom.thumbnail')
                        <div id="classroom_thumbnail_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-2 pe-3 d-flex align-items-end" id="preview-upload">
                    <img src="{{ url("storage/$classroom->thumbnail") }}"
                        accept="image/*"
                        style="border-radius:12px"
                        id="classroom_thumbnail_upload" alt="thumbnail"
                        class="ml-2" width="49px" height="49px" alt="Default Classroom Thumbnail">
                </div>

                <div class="col-md-12 col-lg-2 w-100 d-flex justify-content-end">
                    <a data-id-tab="schedule_tab" class="default-btn bg-primary btn-shadow text-white m-1 finish next-tab-btn mt-8"
                        style="width: 136px; height: 40px;">
                        Prosseguir
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Second tab --}}
    <div id="second-tab">
        <div id="schedule_tab" class="d-none">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="classroom-title" class="p-0 m-0">Quando serão as aulas ao vivo?</h1>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-end">
                        <a onclick="SubmitForm();" class="default-btn bg-primary btn-shadow text-white m-1 mb-8 save-classroom-btn">
                            Salvar
                        </a>
                    </div>
                </div>
            </div>

    
        <div class="row base-schedule-row">
                <div class="col-md-12 col-xxl-10">
                    <div class="row first-classroom-row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="class_name">Nome da Aula</label>
                            <input type="text" class="form-control @error('course.name') is-invalid @enderror"
                                id="class_name" name="create[course][id][name]" aria-describedby="live_class_name_feedback"
                                placeholder="Insira o nome da Aula..." value="{{ old('course.name') }}" required>

                            @error('course.name')
                                <div id="live_class_name_feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-8">
                        <div class="col-lg-6 col-md-6 col-sm-12 classroom-link">
                            <label for="schedule_link">Link da Aula</label>
                            <div class="input-group mb-3 rounded-corner-link">
                                <input type="text" class="form-control @error('course.link') is-invalid @enderror"
                                    id="class_link" name="create[course][id][link]" aria-describedby="live_class_link_feedback"
                                    placeholder="Insira o link da aula..." value="{{ old('course.link') }}" required>
                                {{-- <div class="input-group-append generate-link">
                                    <button class="btn btn-outline-secondary" type="button">Gerar</button>
                                </div> --}}

                                @error('schedule.link')
                                    <div id="live_class_link_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="teacher_id">Professor</label>
                            <select class="form-select @error('edit.course.teacher_id') is-invalid @enderror" id="teacher_id"
                                name="create[course][id][teacher_id]" aria-describedby="live_class_teacher_feedback">
                                <option value="" selected>Selecione...</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @selected (old('teacher_id') == $teacher->id)>{{ $teacher->name }}</option>
                                @endforeach
                            </select>

                            @error('classroom.description')
                                <div id="live_class_teacher_feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-8">

                    <div class="col-md-6">
                        <div class="row">
                            <label for="" class="mt-0">{{ __('Dias da Semana') }}</label>
                            <div class="row flex-nowrap week-days">

                                {{-- Create - base-schedule-row --}}
                                @foreach ($weekdays as $weekday)
                                    <div class="col-1 week-day-box">
                                        <div class="week-day-checkbox">
                                            <input type="hidden" name="create[schedules][id][{{ $weekday->id }}][status]" value="off" />
                                            <input type="hidden" name="create[schedules][id][{{ $weekday->id }}][week_day_letter]" value="{{ $weekday->firstLetter }}" />
                                            <input id="schedules_id_week_day_{{ $weekday->id }}" type="checkbox"
                                                name="create[schedules][id][{{ $weekday->id }}][status]" />
                                            <label for="schedules_id_week_day_{{ $weekday->id }}">
                                                {{ $weekday->firstLetter }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="d-flex col-md-6 classroom-hours">
                        <div class="ps-1 me-5" style="width: 45%;">
                            <label for="class_start">Início da Aula</label>
                            <input type="time" class="form-control @error('course.start') is-invalid @enderror"
                                id="class_start" name="create[course][id][start]" aria-describedby="class_start_feedback"
                                value="{{ old('course.class_start') }}" required>
                            @error('course.start')
                                <div id="class_start_feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="ps-1" style="width: 45%;">
                            <label for="class_end">Fim da Aula</label>
                            <input type="time" class="form-control @error('course.end') is-invalid @enderror"
                                id="class_end" name="create[course][id][end]" aria-describedby="class_end_feedback"
                                value="{{ old('course.end') }}" required>

                            @error('course.end')
                                <div id="class_end_feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xxl-2 add-new-col justify-content-end" >
                <a onclick="AddScheduleRow(true);" id="addNewSchedule" data-id-tab="schedule_tab"
                    class="default-btn bg-primary btn-shadow text-white m-1 mb-8">
                    Adicionar novo
                </a>
            </div>
        </div>
        <div class="additional-schedule-rows">
            @php
                $createCourses = old('create.course', []);
                $createSchedules = old('create.schedules', []);
            @endphp            
            @foreach ($createCourses as $key => $course)
                <div class="row" data-id-schedule-row="{{ $key }}">
                    <div class="col-md-12 col-xxl-10">
                        <div class="row first-classroom-row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="class_name">Nome da Aula</label>
                                <input 
                                    type="text" 
                                    class="form-control @error("create.course.{$key}.name") is-invalid @enderror"
                                    id="class_name" 
                                    name="create[course][{{ $key }}][name]" 
                                    aria-describedby="live_class_name_feedback"
                                    placeholder="Insira o nome da Aula..." 
                                    value="{{ old("create.course.{$key}.name") }}" 
                                    required
                                >

                                @error("create.course.{$key}.name")
                                    <div id="live_class_name_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-8">
                            <div class="col-lg-6 col-md-6 col-sm-12 classroom-link">
                                <label for="schedule_link">Link da Aula</label>
                                <div class="input-group mb-3 rounded-corner-link">
                                    <input 
                                        type="text" 
                                        class="form-control @error("create.course.{$key}.link") is-invalid @enderror"
                                        id="class_link" 
                                        name="create[course][{{ $key }}][link]" 
                                        aria-describedby="live_class_link_feedback"
                                        placeholder="Insira o link da aula..." 
                                        value="{{ old("create.course.{$key}.link") }}" 
                                        required
                                    >

                                    @error("create.course.{$key}.link")
                                        <div id="live_class_link_feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="teacher_id">Professor</label>
                                <select class="form-select @error("create.course.{$key}.teacher_id") is-invalid @enderror" id="teacher_id"
                                    name="create[course][{{ $key }}][teacher_id]" aria-describedby="live_class_teacher_feedback">
                                    <option value="">Selecione...<option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" @selected (old("create.course.{$key}.teacher_id") == $teacher->id)>{{ $teacher->name }}</option>
                                    @endforeach
                                </select>

                                @error("create.course.{$key}.teacher_id")
                                    <div id="live_class_teacher_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-8">

                        <div class="col-md-6">
                            <div class="row">
                                <label for="" class="mt-0">{{ __('Dias da Semana') }}</label>
                                <div class="row flex-nowrap week-days">

                                    {{-- Create - Old --}}
                                    @foreach (old('create.schedules')[$key] as $schedule_id => $item)
                                        <div class="col-1 week-day-box">
                                            <div class="week-day-checkbox">
                                                <input type="hidden" name="create[schedules][{{ $key }}][{{ $schedule_id }}][status]" value="off" />
                                                <input type="hidden" name="create[schedules][{{ $key }}][{{ $schedule_id }}][week_day_letter]" value="{{ $item['week_day_letter'] }}" />
                                                <input id="schedules_{{ $key }}_week_day_{{ $schedule_id }}" type="checkbox"
                                                    name="create[schedules][{{ $key }}][{{ $schedule_id }}][status]"
                                                    @checked($item['status'] == 'on' ? 1 : 0 )/>
                                                <label for="schedules_{{ $key }}_week_day_{{ $schedule_id }}">
                                                    {{ $item['week_day_letter'] }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-md-6 classroom-hours">
                            <div class="ps-1 me-5" style="width: 45%;">
                                <label for="class_start">Início da Aula</label>
                                <input type="time" class="form-control @error("create.course.{$key}.start") is-invalid @enderror"
                                    id="class_start" name="create[course][{{ $key }}][start]" aria-describedby="class_start_feedback"
                                    value="{{ old("create.course.{$key}.start") }}" required>

                                @error("create.course.{$key}.start")
                                    <div id="class_start_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="ps-1" style="width: 45%;">
                                <label for="class_end">Fim da Aula</label>
                                <input type="time" class="form-control @error("create.course.{$key}.end") is-invalid @enderror"
                                    id="class_end" name="create[course][{{ $key }}][end]" aria-describedby="class_end_feedback"
                                    value="{{ old("create.course.{$key}.end") }}" required>
                                @error("create.course.{$key}.end")
                                    <div id="class_end_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                </div>
                                @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-xxl-2 add-new-col justify-content-end" >
                        <a onclick="RemoveScheduleRow({{ $key }})" class="btn default-btn text-white bg-danger m-1 w-100 mb-8 removeSchedule">
                            Apagar
                        </a>
                    </div>
                    </div>
                </div>
            @endforeach

            @foreach ($classroom->liveCourses as $course)
                @php
                    $key = $course->id;
                @endphp
                <div class="row" data-id-schedule-row="{{ $course->id }}">
                    <hr class="hr-divider" />
                    <div class="col-md-12 col-xxl-10">
                        <div class="row first-classroom-row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="class_name">Nome da Aula</label>
                                <input 
                                    type="text" 
                                    id="class_name_{{ $key }}" 
                                    class="form-control @error("edit.course.$key.name") is-invalid @enderror"
                                    placeholder="Insira o nome da Aula..." 
                                    name="edit[course][{{ $key }}][name]" 
                                    aria-describedby="live_class_name_feedback"                                    
                                    value="{{ old("edit.course.$key.name", $course->name) }}" 
                                    required
                                >

                                @error("edit.course.$key.name")
                                    <div id="live_class_name_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-8">
                            <div class="col-lg-6 col-md-6 col-sm-12 classroom-link">
                                <label for="class_link_{{ $key }}">Link da Aula</label>
                                <div class="input-group mb-3 rounded-corner-link">
                                    <input 
                                        type="text" 
                                        class="form-control @error("edit.course.$key.link") is-invalid @enderror"
                                        id="class_link_{{ $key }}" 
                                        name="edit[course][{{ $key }}][link]" 
                                        aria-describedby="live_class_link_feedback"
                                        placeholder="Insira o link da aula..." 
                                        value="{{ old("edit.course.$key.link", $course->link) }}"
                                        required
                                    >

                                    @error("edit.course.$key.link")
                                        <div id="live_class_link_feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="teacher_id_{{ $key }}">Professor</label>
                                <select 
                                    class="form-select @error("edit.course.$key.teacher_id") is-invalid @enderror" 
                                    id="teacher_id_{{ $key }}"
                                    name="edit[course][{{ $key }}][teacher_id]" 
                                    aria-describedby="live_class_teacher_feedback"
                                >
                                    @foreach ($teachers as $teacher)
                                        <option 
                                            value="{{ $teacher->id }}" 
                                            @selected(old("edit.course.$key.teacher_id", $course->teacher_id) == $teacher->id)
                                        >
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error("edit.course.$key.teacher_id")
                                    <div id="live_class_teacher_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-8">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="" class="mt-0">{{ __('Dias da Semana') }}</label>
                                    <div class="row flex-nowrap week-days">
                                        {{-- Edit - database --}}

                                        @foreach ($course->schedules as $schedule)
                                            <div class="col-1 week-day-box">
                                                <div class="week-day-checkbox">
                                                    <input type="hidden" name="edit[schedules][{{ $key }}][{{ $schedule->id }}][status]" value="off" />
                                                    <input type="hidden" name="edit[schedules][{{ $key }}][{{ $schedule->id }}][week_day_letter]" value="{{ $schedule->weekday->firstLetter }}" />
                                                    <input id="schedules_{{ $key }}_week_day_{{ $schedule->weekday->id }}" type="checkbox"
                                                        name="edit[schedules][{{ $key }}][{{ $schedule->id }}][status]"
                                                        @checked($schedule->status) />
                                                    <label for="schedules_{{ $key }}_week_day_{{ $schedule->weekday->id }}">
                                                        {{ $schedule->weekday->firstLetter }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex col-md-6 classroom-hours">
                                <div class="ps-1 me-5" style="width: 45%;">
                                    <label for="class_start_{{ $key }}">Início da Aula</label>
                                    <input 
                                        type="time" 
                                        class="form-control @error("edit.course.$key.start") is-invalid @enderror"
                                        id="class_start_{{ $key }}" 
                                        name="edit[course][{{ $key }}][start]" 
                                        aria-describedby="class_start_feedback"
                                         value="{{ old("edit.course.$key.start", $course->start) }}"
                                        required
                                    >

                                    @error("edit.course.$key.start")
                                        <div id="class_start_feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="ps-1" style="width: 45%;">
                                    <label for="class_end_{{ $key }}">Fim da Aula</label>
                                    <input 
                                        type="time" 
                                        class="form-control @error("edit.course.$key.end") is-invalid @enderror"
                                        id="class_end_{{ $key }}" 
                                        name="edit[course][{{ $key }}][end]" 
                                        aria-describedby="class_end_feedback"
                                        value="{{ old("edit.course.$key.end", $course->end) }}"
                                        required
                                    >

                                    @error("edit.course.$key.end")
                                        <div id="class_end_feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xxl-2 justify-content-end add-new-col" >
                        <a onclick="RemoveScheduleRow({{ $course->id }})" class="btn default-btn text-white bg-danger m-1 w-100 mb-8 removeSchedule">
                            Apagar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</form>
