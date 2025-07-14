@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Aulas Gravadas
@endsection

@section('content')
    <input type="hidden" id="classroom_id" value="{{$classroom->id}}">

    @handheld
        <div class="col  d-flex justify-content-between">
    @endhandheld
        <h1 style="font-size: 36px; line-height: 48px; margin-bottom:20px !important;">
            {{ $classroom->formatted_name }}
        </h1>
        @handheld
            <div class="navbar-item" style="width: 56px; height: 56px; background-color: white; border-radius: 12px; text-align: center;"
            onclick="showOnbCourseModal()">
                <button class="btn" style="height: 100%; width: 100%">
                    <img src="{{asset('images/icons/help-circle.svg')}}" alt="">
                </button>
            </div>
        @endhandheld
    @handheld
    </div>
    @endhandheld



    <div class="card">
        <div 
            class="card-body recorded-class-card"
            data-complete-lesson-text="{{ __('classroom.complete_lesson') }}"
            data-description-text="{{ __('classroom.description') }}"
            data-materials-text="{{ __('classroom.materials') }}"
            data-teacher-text="{{ __('classroom.teacher') }}"
        >
            <div class="container-fluid p-0">
                @tablet
                    <div class="recorded-class-row">
                        <div class="col-md-12 right-side">
                @endtablet
                @mobile
                    <div class="row recorded-class-row">
                        <div class="col-md-12 right-side">
                @endmobile
                @desktop
                    <div class="row recorded-class-row">
                        <div class="col-md-8 right-side">
                @enddesktop
                        @if ($first_course == null)
                            <div class="class-video" style="margin-top: 40px !important">
                                <img class="mb-3" height="62" src="{{ asset('images/icons/video-circle.svg') }}" alt="Video Icon">
                                <h1 class="p-4 text-center">Não existem aulas nessa turma</h1>
                            </div>
                        @else
                            @if ($first_course->link)
                                <iframe class="class-video d-block main-video"
                                    src="{{ generateVideoEmbedUrl($first_course->link)}}"
                                    title="{{ $first_course->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen style="margin-top: 40px !important;">
                                </iframe>
                            @else
                                <div class="embed-iframe">
                                    {!! $first_course->embed_code !!}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between mt-8 course-details">
                                    <div>
                                        <div class="align-items-center">
                                            @if(isset($first_course->recorded_at) && $first_course->recorded_at != null)
                                                @php
                                                    $date = $first_course->getOriginal('recorded_at');
                                                    $date = explode(' ', $date);
                                                    $date = explode('-', $date[0]);
                                                    $date = $date[0]."/".$date[1]."/".$date[2];
                                                @endphp
                                                <span style="font-size:15px; font-weight: bolder; color:#329fba;">{{ $date }}</span>
                                            @endif
                                            <h1 class="course_name_active" style="margin-top:4px !important; margin-bottom: 7px !important">{{ $first_course->formatted_name }}</h1>
                                        </div>
                                        <span class="teacher-name">{{ __('classroom.teacher') }} {{ $first_course->teacher?->name == null ? "Não encontrado" : $first_course->teacher?->name }}</span>
                                    </div>

                                @canany(['admin', 'teacher'])
                                    <div class="course-detail-actions d-flex">
                                        <a href="{{ route('classrooms.courses.edit', [$classroom->id, $first_course->id]) }}" class="me-3">
                                            <button class="square-action-btn">
                                                <img src="{{ asset('images/icons/pen.svg') }}" alt="Edit Icon">
                                            </button>
                                        </a>

                                        <button class="square-action-btn" onclick="deleteCourseModal({{ $first_course->id }});">
                                            <img src="{{ asset('images/icons/trash.svg') }}" alt="Delete Icon">
                                        </button>
                                    </div>
                                @endcanany

                                @can('guardian')
                                <label class="course_item btn course-finished px-4 {{ $student->courseIsDone($first_course) ? 'bg-primary' : '' }} " for="course_{{ $first_course->id }}_status">
                                    <input @checked($student->courseIsDone($first_course))  onclick="markCourse({{ $first_course->id }});" class="markCourse {{ $student->courseIsDone($first_course) ? 'finished-class-checkbox-primary' : 'finished-class-checkbox' }}" type="checkbox" id="course_{{ $first_course->id }}_status">
                                    <span class="text-white">{{ __('classroom.complete_lesson') }}</span>
                                </label>
                                @endcan

                            </div>

                            @if ($first_course->description || $first_course->hasFiles)
                                <nav class="mt-5">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        @if ($first_course->description)
                                            <span class="nav-link {{ ($first_course->description) ? "active" : "" }} tab-title" id="description-tab" data-toggle="tab" href="#description"
                                                role="tab" aria-controls="description" aria-selected="true">
                                                {{ __('classroom.description') }}
                                            </span>
                                        @endif
                                        @if ($first_course->hasFiles)
                                            <span class="nav-link tab-title {{ ($first_course->description =="" ) ? "active" : "" }}" id="materials-tab" data-toggle="tab" href="#materials"
                                                role="tab" aria-controls="materials" aria-selected="true">
                                                {{ __('classroom.materials') }}
                                            </span>
                                        @endif
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show {{ ($first_course->description) ? "active" : "" }}" id="description" role="tabpanel" aria-labelledby="description-tab">
                                        <div class="class-description mt-4">
                                            <pre>{!! $first_course->description_formatted !!}</pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show {{ ($first_course->description=="") ? "active" : "" }}" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                        @if ($first_course->hasFiles)
                                            @foreach ($first_course->materials as $material)
                                                <div class="class-material mt-4">
                                                    <div class="file-list-item d-flex justify-content-between">
                                                        <div class="file-icon me-3">
                                                            <img height="30" src="{{ asset('images/icons/file-pdf.svg') }}">
                                                        </div>
                                                        <div class="file-details w-100">
                                                            <b class="d-block">{{ $material->file->name }}</b>
                                                            <small class="text-muted"> {{ $material->file->size }} </small>
                                                        </div>
                                                        <div class="file-actions">
                                                            <a href="/file/material/{{ $material->file_id }}/view" target="_blank">
                                                                <div class="btn bg-primary">
                                                                    <img height="20" src="{{ asset('images/icons/eye.svg') }}">
                                                                </div>
                                                            </a>
                                                            <a href="/file/material/{{ $material->file_id }}" target="_blank">
                                                                <div class="btn bg-primary">
                                                                    <img height="20" src="{{ asset('images/icons/download.svg') }}">
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>


                    @desktop
                        <div class="col-md-4 pe-4 pt-7 left-side">
                    @enddesktop
                    @tablet
                        <div class="col-md-12 pt-7 left-side" style="padding-left: 0px !important">
                    @endtablet
                    @mobile
                        <div class="col-md-12 pe-4 pt-3 left-side">
                    @endmobile
                        @canany(['admin', 'teacher'])
                            <a href="{{ route('classrooms.courses.create', $classroom->id) }}"
                                class="default-btn bg-primary btn-shadow module-action-btn">
                                <span class="text-white">Adicionar aula</span>
                            </a>
                            <a href="{{ route('classrooms.modules.create', ['classroom' => $classroom->id]) }}" class="default-btn bg-primary btn-shadow module-action-btn">
                                <span class="text-white">Adicionar módulo</span>
                            </a>
                        @endcanany

                        @if($classroom->modules != null && $classroom->modules->count() > 0 && count($modulesWithCourses) == 1)
                            <div @can('guardian')class="align-items-center" @endcan @canany(['admin', 'teacher'])class="d-flex align-items-center" @endcanany>
                                <h2 class="mt-2 d-inline">{{ $modulesWithCourses[0]->formatted_name}}</h2>
                                @can('guardian')
                                    <div class="progress-area" style="width: 100%">
                                        <div class="progress mt-3 mb-2" style="height:7px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $statistics['percentage'] }}%;"
                                                aria-valuenow="{{ $statistics['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="progress-value">
                                            {{ round($statistics['percentage'], 0) }}%
                                        </span>
                                    </div>
                                @endcan
                                @canany(['admin', 'teacher'])
                                    <div class="course-detail-actions d-flex" style="margin-left: 20px">
                                        <a href="{{ route('modules.edit', [$modulesWithCourses[0]->id]) }}" class="me-3">
                                            <button class="square-action-btn">
                                                <img src="{{ asset('images/icons/pen.svg') }}" alt="Edit Icon">
                                            </button>
                                        </a>

                                        <button class="square-action-btn" onclick="deleteModuleModal({{ $modulesWithCourses[0]->id }});">
                                            <img src="{{ asset('images/icons/trash.svg') }}" alt="Delete Icon">
                                        </button>
                                    </div>
                                @endcanany
                            </div>
                            <hr style="border: 2px solid #daeef1c4">
                            <div style="overflow-y:scroll; height: 600px; margin-top:20px;">


                                @foreach ($modulesWithCourses[0]->courses->sortByDesc('recorded_at') as $course)
                                    @php
                                        if(str_contains($course->link, 'youtu.be')){
                                            $url = $course->link;
                                            $url = explode('/', $url);
                                            $course->link = $url[3];
                                        }
                                        if(str_contains($course->link, 'www.youtube.com')){
                                            $url = $course->link;
                                            $url = explode('&', $url);
                                            $url = explode('=', $url[0]);
                                            $course->link = $url[1];
                                        }
                                    @endphp
                                    <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop({{ $course->id }})">
                                        <div>
                                            <label class="d-flex">
                                                <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/{{ $course->link }}/0.jpg">
                                            </label>
                                        </div>
                                        @can('guardian')
                                            <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_{{ $course->id }}"
                                                @checked($student->courseIsDone($course)) disabled/>
                                        @endcan
                                        <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                            <label class="d-flex">
                                                <span class="course_name" id="course_name_{{ $course->id }}">{{ $course->formatted_name }}</span>
                                            </label>
                                            @if(isset($first_course->recorded_at) && $course->recorded_at != null)
                                                @php
                                                    $date = $course->getOriginal('recorded_at');
                                                    $date = explode(' ', $date);
                                                    $date = explode('-', $date[0]);
                                                    $date = $date[0]."/".$date[1]."/".$date[2];
                                                @endphp
                                                <label class="d-flex" style="font-size:14px; font-weight: bolder; color:#329fba">
                                                    <span>{{ $date }}</span>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($classroom->modules != null && $classroom->modules->count() > 0 && count($modulesWithCourses) > 1)
                            @foreach ($modulesWithCourses as $key => $module)
                                @php
                                    $first_module = $module;
                                @endphp
                                <div class="accordion" id="accordionModules_{{$module->id}}" style="{{ ($key != 0) ? "display:none;" : "" }}">
                                    <div class="accordion-item my-1" id="module_item">
                                        <button onclick="changeArrow({{$module->id}})" class="btn dropdown-toggle-split d-block collapse collapsed d-flex justify-content-between align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="collapse"
                                                data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse" style="width: 100%;">
                                                <h2 class="mt-2 d-inline" style="text-align: left;">{{ $module->formatted_name}}</h2>
                                                <div>
                                                    <img id="arrow_{{$module->id}}" src="{{ asset('images/icons/angle_up_icon.svg') }}" style="width: 40px; height: 40px;">
                                                </div>
                                        </button>
                                        @can('guardian')
                                            <div class="progress-area" style="width: 100%">
                                                <div class="progress mt-3 mb-2" style="height:7px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $statistics['percentage'] }}%;"
                                                        aria-valuenow="{{ $statistics['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="progress-value">
                                                    {{ round($statistics['percentage'], 0) }}%
                                                </span>
                                            </div>
                                        @endcan

                                        <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="margin-top:10px">
                                            <div>
                                                @foreach ($modulesWithCourses as $module)
                                                    @if ($module->hasCourses || Auth::user()->is_administrator)
                                                        <div onclick="changeModule({{$module->id}}, {{count($modulesWithCourses)}})" class="{{ ($first_module->id == $module->id) ? "active" : "" }} btn modules accordion-button-tav d-flex justify-content-between align-items-center collapsed mb-5 p-8">
                                                            <b style="{{ strlen($module->formatted_name) < 50 ?  'font-size:17px;' : 'margin-right: 20px !important;
                                                                font-size:13px;
                                                                display: inline-block !important;
                                                                white-space: nowrap !important;
                                                                overflow: hidden !important;
                                                                text-overflow: ellipsis !important;'}}" class="d-block" id="module_name_{{ $module->id }}">
                                                                {{ $module->formatted_name }}
                                                            </b>
                                                            @can('guardian')
                                                                <small>
                                                                    {{ $student->getFinishedCourses(2, $module->id, $classroom->id) }}/{{ $module->courses->count() }}
                                                                </small>
                                                            @endcan
                                                            @canany(['admin', 'teacher'])
                                                                <div class="course-detail-actions d-flex">
                                                                    <a href="{{ route('modules.edit', [$module->id]) }}" class="me-3">
                                                                        <button class="square-action-btn">
                                                                            <img src="{{ asset('images/icons/pen.svg') }}" alt="Edit Icon">
                                                                        </button>
                                                                    </a>

                                                                    <button class="square-action-btn" onclick="deleteModuleModal({{ $module->id }});">
                                                                        <img src="{{ asset('images/icons/trash.svg') }}" alt="Delete Icon">
                                                                    </button>
                                                                </div>
                                                            @endcanany
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr style="border: 2px solid #daeef1c4">
                                        <div style="overflow-y:scroll; height: 600px; margin-top:20px;">
                                            @if( $first_module->courses != null && $first_module->courses->count() >0)
                                                @foreach ($first_module->courses->sortByDesc('recorded_at') as $course)
                                                @php
                                                    if(str_contains($course->link, 'youtu.be')){
                                                        $url = $course->link;
                                                        $url = explode('/', $url);
                                                        $course->link = $url[3];
                                                    }
                                                    if(str_contains($course->link, 'www.youtube.com')){
                                                        $url = $course->link;
                                                        $url = explode('&', $url);
                                                        $url = explode('=', $url[0]);
                                                        $course->link = $url[1];
                                                    }
                                                @endphp
                                                    <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop({{ $course->id }})">
                                                        <div>
                                                            <label class="d-flex">
                                                                <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/{{ $course->link }}/0.jpg">
                                                            </label>
                                                        </div>
                                                        @can('guardian')
                                                            <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_{{ $course->id }}"
                                                                @checked($student->courseIsDone($course)) disabled/>
                                                        @endcan
                                                        <div @canany(['admin', 'teacher']) style="margin-left: 10px" @endcanany>
                                                            <label class="d-flex">
                                                                <span class="course_name" id="course_name_{{ $course->id }}" >{{ $course->formatted_name }}</span>
                                                            </label>
                                                            @if(isset($course->recorded_at) && $course->recorded_at != null)
                                                                @php
                                                                    $date = $course->getOriginal('recorded_at');
                                                                    $date = explode(' ', $date);
                                                                    $date = explode('-', $date[0]);
                                                                    $date = $date[0]."/".$date[1]."/".$date[2];
                                                                @endphp

                                                                <label class="d-flex" style="font-size:14px; font-weight: bolder; color:#329fba">
                                                                    <span>{{$date}}</span>
                                                                </label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <h1 class="p-4 text-center">Não há aulas a serem exibidas</h1>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif(count($modulesWithCourses) == 0)
                            <h1 class="p-4 text-center">Não há modulos a serem exibidos</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- begin:edit Module Modal --}}
    <div class="modal fade" id="edit_module_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="height: 326px;">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-left" style="margin-top: 54px;">
                        <input type="hidden" id="module_to_edit">

                        <h3 for="module">Editar Módulo</h3>
                        <input type="hidden" name="module_id" id="module_id" value="">
                        <input type="text" class="form-control"
                            id="module_name" name="module_name"
                            placeholder="Insira o novo nome do módulo..."
                            value="">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_classroom" type="button" onclick="editModule();"
                        class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>Salvar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:edit Module Modal --}}


    {{-- begin:delete Module Modal Confirmation --}}
    <div class="modal fade" id="delete_module_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="module_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_module_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_module" type="button" onclick="deleteModuleConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:delete Module Modal Confirmation --}}

    {{-- begin:delete Course Modal Confirmation --}}
    <div class="modal fade" id="delete_course_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="course_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_course_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_course" type="button" onclick="deleteCourseConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:delete Course Modal Confirmation --}}

@endsection

<script>

    function selectCourseAndScrollTop(courseId){
        selectCourse(courseId);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }


    function changeModule(module_id, modules_length){
        arrow = document.getElementById('arrow_'+module_id);
        arrow.src = '{{ asset('images/icons/angle_up_icon.svg') }}'
        modules = document.getElementsByClassName('accordion')
        for (var i = 0; i < modules_length; i++) {
            modules[i].style.display = "none";
        }
        var selected = document.getElementById('accordionModules_' + module_id);
        if(selected.style.display = "none"){
            selected.style.display = "";
        }
    }

    function changeArrow(arrow_id){
        arrow = document.getElementById('arrow_'+arrow_id);
        if(arrow.src == '{{ asset('images/icons/angle_up_icon.svg') }}'){
            arrow.src = '{{ asset('images/icons/angle_down_icon.svg') }}'
        }else{
            arrow.src = '{{ asset('images/icons/angle_up_icon.svg') }}'
        }
    }
</script>

<style>
.course_name{
    font-size: 14px;
    font-Weight: 600;
    color: #485558;
}

.course-checkbox:checked {
    border: 3.5px solid white;
    box-shadow: 0 0 0 2px #485558;
    background-color: var(--bg-primary);
}

.course-item:hover *{
    cursor: pointer !important;
}

.course-item:hover span{
    color: #32a0ba !important;
    transition: 0.5s !important;
}

.course-checkbox{
    min-width: 20px;
    height: 20px;
    margin-right: 10px;
    margin-bottom: 10px;
    background-color: white;
    border-radius: 50%;
    vertical-align: middle;
    appearance: none;
    -webkit-appearance: none;
    outline: none;
    cursor: pointer;
    border-radius: 25px !important;
    border: 2px solid #485558;
}
.main-video{
    width: 100% !important;
    height: 456px !important;
}
.accordion-button-tav,
.accordion-button-tav::after {
    color: #485558 !important;
    border: none !important;
    height: 65px;
    box-shadow: none !important;
}

.accordion-button-tav {
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
    background-color: #e7e7e7 !important;
}

.accordion-button-tav.active {
    background-color: #329fba !important;
    color: white !important;
    border: none !important;
    height: 65px;
    box-shadow: none !important;
}

.accordion-button-tav:hover {
    background-color: #329fba !important;
    color: white !important;
    border: none !important;
    height: 65px;
    box-shadow: none !important;
}
@media (max-width: 1400px) {
    .right-side{
        border: 0 !important;
        padding-right: 0px !important;
    }

    .main-video{
        width: 100% !important;
        height: 367.48px !important;
    }
}

/* MOBILE */
@media (max-width: 450px) {
    .main-video{
        width: 100% !important;
        height: 193.48px !important;
    }
}
@media (max-width: 767px) {
    .main-video{
        width: 100% !important;
        height: 300.04px !important;
    }
    .course-detail-actions {
        justify-content: end;
    }

    .course-details {
        flex-direction: column;
    }

    .course-finished {
        margin-top: 20px;
        justify-content: start !important;
        padding-left: 20px !important;
    }

    #description-tab,
    #materials-tab {
        font-size: 20px;
    }

}

</style>


@section('extra-scripts')
    <script src="{{ asset('js/courses/recorded/index.js') }}"></script>
    <script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>
    <script>getUserRole();getStudent();</script>
@endsection
