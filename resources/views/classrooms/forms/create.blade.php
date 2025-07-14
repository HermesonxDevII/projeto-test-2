<form action="{{ route('classrooms.store') }}" method="POST" id="classroom_form" enctype="multipart/form-data">
    @csrf
    <div id="classroom_info_tab" class="visible" data-tab-num="1">
        <h1>Preencha o formulário</h1>
        <div class="row mt-8">
            <div class="col-lg-10 col-md-12 col-sm-12">
                <label for="classroom_name">Nome da Turma</label>
                <input type="text" class="form-control @error('classroom.name') is-invalid @enderror"
                    id="classroom_name" name="classroom[name]" aria-describedby="classroom_name_feedback"
                    placeholder="Insira o nome da turma..." value="{{ old('classroom.name') }}" required>

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
                    value="{{ old('classroom.description') }}" required>

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
                    <option value="" selected>Selecione...</option>
                    @foreach ($evaluationModels as $evaluation_models)
                        <option value="{{ $evaluation_models->id }}" @selected(old("classroom.evaluation_model_id") == $evaluation_models->id)>
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

                @error('classroom_thumbnail')
                    <div id="classroom_thumbnail_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-2 pe-3 d-flex align-items-end" id="preview-upload">
                <img src="{{ url("storage/default_thumbnail.png") }}"
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
                            id="class_name" name="course[id][name]" aria-describedby="live_class_name_feedback"
                            placeholder="Insira o nome da Aula..." value="{{ old('course.name') }}" required>

                        @error('course.name')
                            <div id="live_class_name_feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-6 col-md-6 col-sm-12 classroom-link">
                        <label for="schedule_link">Link da Aula</label>
                        <div class="input-group mb-3 rounded-corner-link">
                            <input type="text" class="form-control @error('course.link') is-invalid @enderror"
                                id="class_link" name="course[id][link]" aria-describedby="live_class_link_feedback"
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
                        <select class="form-select @error('course.teacher_id') is-invalid @enderror" id="teacher_id"
                            name="course[id][teacher_id]" aria-describedby="live_class_teacher_feedback">
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
                <div class="row mt-4">

                <div class="col-md-6">
                    <div class="row">
                        <label for="" class="mt-0">{{ __('Dias da Semana') }}</label>
                        <div class="row flex-nowrap week-days">

                            @foreach ($weekdays as $weekday)
                                <div class="col-1 week-day-box">
                                    <div class="week-day-checkbox">
                                        <input type="hidden" name="schedules[id][{{ $weekday->id }}][status]" value="off" />
                                        <input id="schedules_id_week_day_{{ $weekday->id }}" type="checkbox"
                                            name="schedules[id][{{ $weekday->id }}][status]" />
                                        <label for="schedules_id_week_day_{{ $weekday->id }}">
                                            {{ $weekday->firstLetter }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="d-flex col-md-6 classroom-hours mt-6">
                    <div class="ps-1 me-5" style="width: 45%;">
                        <label for="class_start">Início da Aula</label>
                        <input type="time" class="form-control @error('course.start') is-invalid @enderror"
                            id="class_start" name="course[id][start]" aria-describedby="class_start_feedback"
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
                            id="class_end" name="course[id][end]" aria-describedby="class_end_feedback"
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
            <a onclick="AddScheduleRow();" id="addNewSchedule" data-id-tab="schedule_tab"
                class="default-btn bg-primary btn-shadow text-white m-1 mb-8">
                Adicionar novo
            </a>
        </div>
    </div>

    <div class="additional-schedule-rows">
        {{-- <ul>
            <li>{{ var_dump(old('course')) }}</li>
            <li>{{ var_dump(old('schedules')) }}</li>
            <li>{{ var_dump(old('week_days')) }}</li>
        </ul>     --}}

        @if (old('schedules', null) != null)
            @foreach (old('schedules') as $key => $schedule)

                <div class="row" data-id-schedule-row="{{ $key }}">
                    <div class="col-md-12 col-xxl-10">
                        <div class="row first-classroom-row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="class_name">Nome da Aula</label>
                                <input type="text" class="form-control @error("course.{$key}.name") is-invalid @enderror"
                                    id="class_name" name="course[{{ $key }}][name]" aria-describedby="live_class_name_feedback"
                                    placeholder="Insira o nome da Aula..." value="{{ old("course.{$key}.name") }}" required>

                                @error("course.{$key}.name")
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-8">
                            <div class="col-lg-6 col-md-6 col-sm-12 classroom-link">
                                <label for="schedule_link">Link da Aula</label>
                                <div class="input-group mb-3 rounded-corner-link">
                                    <input type="text" class="form-control @error("course.{$key}.link") is-invalid @enderror"
                                        id="class_link" name="course[{{ $key }}][link]" aria-describedby="live_class_link_feedback"
                                        placeholder="Insira o link da aula..." value="{{ old("course.{$key}.link") }}" required>
                                    {{-- <div class="input-group-append generate-link">
                                        <button class="btn btn-outline-secondary" type="button">Gerar</button>
                                    </div> --}}

                                    @error("course.{$key}.link")
                                        <div id="live_class_link_feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="teacher_id">Professor</label>
                                <select class="form-select @error("course.{$key}.teacher_id") is-invalid @enderror" id="teacher_id"
                                    name="course[{{ $key }}][teacher_id]" aria-describedby="live_class_teacher_feedback">
                                    <option value="" selected>Selecione...</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" @selected(old("course.{$key}.teacher_id") == $teacher->id)>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error("course.{$key}.teacher_id")
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

                                    @foreach ($weekdays as $weekday)
                                        <div class="col-1 week-day-box">
                                            <div class="week-day-checkbox">
                                                <input id="schedules_id_week_day_{{ $weekday->id }}" type="checkbox"
                                                    name="schedules[{{ $key }}][{{ $weekday->name }}]"
                                                    @checked(old("schedules.{$key}.{$weekday->name}")) />

                                                <label for="schedules_id_week_day_{{ $weekday->id }}">
                                                    {{ $weekday->firstLetter }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                @error("weekdays")
                                    <div id="live_class_teacher_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex col-md-6 classroom-hours">
                            <div class="ps-1 me-5" style="width: 45%;">
                                <label for="class_start">Início da Aula</label>
                                <input type="time" class="form-control @error("course.{$key}.start") is-invalid @enderror"
                                    id="class_start" name="course[{{ $key }}][start]" aria-describedby="class_start_feedback"
                                    value="{{ old("course.{$key}.start") }}" required>

                                @error("course.{$key}.start")
                                    <div id="class_start_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="ps-1" style="width: 45%;">
                                <label for="class_end">Fim da Aula</label>
                                <input type="time" class="form-control @error("course.{$key}.end") is-invalid @enderror"
                                    id="class_end" name="course[{{ $key }}][end]" aria-describedby="class_end_feedback"
                                    value="{{ old("course.{$key}.end") }}" required>

                                @error("course.{$key}.end")
                                    <div id="class_end_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xxl-2 justify-content-end add-new-col" >
                    <a onclick="RemoveScheduleRow({{ $key }})" class="btn default-btn text-white bg-danger m-1 w-100 mb-8 removeSchedule">
                        Apagar
                    </a>
                </div>
            </div>
            @endforeach
        @endif
</form>
