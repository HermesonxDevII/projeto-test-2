@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $class->translated_title }}
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-8">
        <div class="mt-3 mt-md-0">
            <h3 class="classes-furigana-title" id="classes_furigana_title">{{ $class->furigana_title }}</h3>
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                <h1 class="classes-original-title mb-0" id="classes_original_title">
                    {{ $class->original_title }}
                </h1>
                <h2 class="classes-translated-title mb-0" id="classes_translated_title">{{ $class->translated_title }}</h2>
            </div>

            <ol class="breadcrumb mt-5">
                <li class="breadcrumb-item"><a href="{{ route('video-courses.index') }}">{{ __('video-course.title') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('video-courses.show', $videoCourse->id) }}">{{ $videoCourse->title }}</a></li>
                <li class="breadcrumb-item">{{ $class->module->name }}</li>
            </ol>

        </div>

        <a href="{{ route('video-courses.show', $videoCourse->id) }}" class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10 d-sm-block d-none">
            {{ __('video-course.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body recorded-class-card"
            data-mark-as-completed-text="{{ __('video-course.mark_as_completed') }}"
            data-completed-text="{{ __('video-course.completed') }}"
            data-description-text="{{ __('video-course.description') }}"
            data-materials-text="{{ __('video-course.materials') }}"
            data-teacher-text="{{ __('video-course.teacher') }}"
        >
            <div class="container-fluid p-0">
                @tablet
                    <div class="recorded-class-row">
                        <div class="col right-side position-relative" style="padding-right: 0 !important; border-right: 0;">
                        <!-- <div class="col-md-12 right-side"> -->
                @endtablet
                @mobile
                    <div class="row recorded-class-row">
                        <div class="col right-side position-relative" style="padding-right: 0 !important; border-right: 0;">
                        <!-- <div class="col-md-12 right-side"> -->
                @endmobile
                @desktop
                    <div class="row recorded-class-row">
                        <div class="col right-side position-relative">
                        <!-- <div class="col-md-8 right-side"> -->
                @enddesktop
                        
                        <!-- video -->
                        <iframe class="class-video d-block main-video"
                            src="{{ $class->embedurl }}"
                            title="Aula 1"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen style="margin-top: 40px !important;">
                        </iframe>

                        <div class="d-flex justify-content-between mt-8 mb-7 course-details"
                        >
                            <span class="teacher-name">
                                @if ($class->teacher)
                                    {{ __('video-course.teacher') }} {{ $class->teacher }}
                                @endif
                            </span>

                            @can('guardian')
                                <div class="d-flex flex-wrap justify-content-md-start justify-content-between align-items-center gap-7 mt-md-0 mt-5">
                                    <label for="class_{{ $class->id }}_status"
                                        @class([
                                            'course_item class-finished w-md-auto w-100 justify-content-center ms-auto',
                                            'active' => $classFinished
                                        ])
                                    >
                                        <input @checked($classFinished)  onclick="markClass({{ $class->id }});" class="markClass me-3 d-none" type="checkbox" id="class_{{ $class->id }}_status">

                                        <svg class="unchecked-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="9.5" stroke="#1B2A2E"/>
                                        </svg>

                                        <svg class="checked-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="10" fill="white"/>
                                            <path d="M14.6663 6.5L8.24967 12.9167L5.33301 10" stroke="#B4CF04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                        <span class="fw-bolder lh-0">{{ $classFinished ? __('video-course.completed') : __('video-course.mark_as_completed') }}</span>
                                    </label>

                                    @if ($prevClassLink || $nextClassLink)
                                        <div class="d-flex gap-5 ms-auto">
                                            <a href="{{ $prevClassLink }}"
                                                class="btn nav-classes p-2 d-flex justify-content-center align-items-center w-45px h-45px {{ $prevClassLink ? '' : 'disabled' }}"
                                            >
                                                <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 1L1 9L9 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>

                                            <a href="{{ $nextClassLink }}"
                                                class="btn nav-classes p-2 d-flex justify-content-center align-items-center gap-3 px-5 min-w-45px h-45px {{ $nextClassLink ? '' : 'disabled' }}"
                                            >
                                                @if ($class->is_last_of_module)
                                                    Próximo módulo
                                                @endif
                                                <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L9 9L1 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endcan

                            @can('admin')
                                <a href="{{ route('video-courses.classes.edit', [$videoCourse->id, $class->id]) }}">
                                    <button class="square-action-btn">
                                        <img src="{{ asset('images/icons/pen.svg') }}" alt="Edit Icon">
                                    </button>
                                </a>
                            @endcan
                        </div>

                        @if ($class->description)
                            <h2>{{ __('video-course.description') }}</h2>
                            <hr style="border: 2px solid #daeef1c4">
                            <div class="class-description mt-4 mb-9">
                                <pre>{!! $class->description_formatted !!}</pre>
                            </div>
                        @endif

                        @if ($class->files()->exists())
                            <h2>{{ __('video-course.materials') }}</h2>
                            <hr style="border: 2px solid #daeef1c4">
                            @foreach ($class->files as $file)
                                <div class="class-material mt-4">
                                    <div class="file-list-item d-flex justify-content-between">
                                        <div class="file-icon me-3">
                                            <img height="30" src="{{ asset('images/icons/file-pdf.svg') }}">
                                        </div>
                                        <div class="file-details w-100">
                                            <b class="d-block">{{ $file->name }}</b>
                                            <small class="text-muted"> {{ $file->size }} </small>
                                        </div>
                                        <div class="file-actions">
                                            <a href="/video-course-files/{{ $file->id }}/view" target="_blank">
                                                <div class="btn bg-primary">
                                                    <img height="20" src="{{ asset('images/icons/eye.svg') }}">
                                                </div>
                                            </a>
                                            <a href="/video-course-files/{{ $file->id }}" target="_blank">
                                                <div class="btn bg-primary">
                                                    <img height="20" src="{{ asset('images/icons/download.svg') }}">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @desktop
                            <button type="button" class="btn bg-primary p-2 d-md-flex d-none justify-content-center align-items-center classes-toggle">
                                <svg width="9" height="15" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.318 1.13637L7.68164 7.50001L1.31801 13.8636" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        @enddesktop
                    </div>


                    @desktop
                        <div class="col-md-4 pt-11 left-side" id="collapseClassesVideos">
                            <div class="ms-5">
                    @enddesktop
                    @tablet
                        <div class="col-md-12 pt-11 left-side" id="collapseClassesVideos" style="padding-left: 0px !important">
                            <div class="ms-0">
                    @endtablet
                    @mobile
                        <div class="col-md-12 pt-11 left-side" id="collapseClassesVideos" style="padding-left: 0px !important">
                            <div class="ms-0">
                    @endmobile
                                <div>
                                    <h2 class="mb-3">{{ $module->name }}</h2>
                                    @can('guardian')
                                        <div class="d-flex align-items-center gap-4">
                                            <div class="progress w-100" style="height: 5px;">
                                                <div class="progress-bar bg-success-base" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="progress-percent">{{ $progress }}%</span>
                                        </div>
                                    @endcan
                                </div>
                                <hr style="border: 2px solid #daeef1c4">
                                <div style="overflow-y:scroll; height: 600px; margin-top:20px;">
                                    @foreach ($module->getClassesOrdered() as $classThumbnail)
                                        @if ($classThumbnail->link)
                                            @php
                                                if(str_contains($classThumbnail->link, 'youtu.be')){
                                                    $url = $classThumbnail->link;
                                                    $url = explode('/', $url);
                                                    $classThumbnail->link = $url[3];
                                                }
                                                if(str_contains($classThumbnail->link, 'www.youtube.com')){
                                                    $url = $classThumbnail->link;
                                                    $url = explode('&', $url);
                                                    $url = explode('=', $url[0]);
                                                    $classThumbnail->link = $url[1];
                                                }
                                            @endphp
                                            <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectClassAndScrollTop({{ $classThumbnail->id }})">
                                                <div>
                                                    <label class="d-flex">

                                                        <!-- thumbnail -->
                                                        <img
                                                            style="width: 120px; height: 90px; border-radius: 10px"
                                                            src="{{ 
                                                                filter_var($classThumbnail->thumbnail, FILTER_VALIDATE_URL) 
                                                                    ? $classThumbnail->thumbnail 
                                                                    : (
                                                                        $classThumbnail->thumbnail === 'default_thumbnail.png' 
                                                                            ? asset('storage/thumbnails/default_thumbnail.png')
                                                                            : asset('storage/' . $classThumbnail->thumbnail)
                                                                    )
                                                            }}"
                                                        />
                                                    </label>
                                                </div>
                                                @can('guardian')
                                                    <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="class_{{ $classThumbnail->id }}"
                                                        @checked($classThumbnail->viewed) disabled/>
                                                @endcan
                                                <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                                    <label class="d-flex">
                                                        <span
                                                            class="class_name"
                                                            id="class_name_{{ $classThumbnail->id }}"
                                                            @if ($classThumbnail->id == $class->id) style="color: rgb(50, 160, 186);" @endif
                                                        >{{ $classThumbnail->original_title }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson_completed_modal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="d-flex justify-content-center">
                        <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
                        <dotlottie-player src="https://lottie.host/a8a01255-6d9d-4030-a258-97af95eed0d6/iTORLXd815.lottie" background="transparent" speed="1" style="width: 300px; height: 300px" loop autoplay></dotlottie-player>                        
                    </div>
                    <h3 class="my-3 text-center" style="color:#329FBA !important;" id="lesson_complete_student">Parabéns Nome do Aluno!</h3>
                    <h3 class="my-3 text-center" style="color:#329FBA !important;font-size: 1.20rem !important;" id="lesson_complete_description">Você concluiu mais um módulo da Melis Education!</h3>
                    <audio id="module_complete_audio">
                        <source src="{{ asset('storage/audio/376318__jimhancock__tada.wav')}}" type="audio/wav">
                        Seu navegador não suporta o elemento de áudio.
                    </audio>
                    <audio id="course_complete_audio">
                        <source src="{{ asset('storage/audio/595665__chungus43a__super-mario-bros.wav')}}" type="audio/wav">
                        Seu navegador não suporta o elemento de áudio.
                    </audio>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap');

/* .bg-secondary-darker {
    background-color: #C11345 !important;
} */
.nav-classes {
    background-color: #F4F4F5 !important;
    color: #485558 !important;
}
.nav-classes:hover {
    background-color: #329FBA !important;
    color: #FFF !important;
}
.bg-success-base {
    background-color: #B4CF04 !important;
}
.progress-bar {
    border-radius: 50px !important;
}
.progress-percent {
    font-family: 'Raleway', serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 16px;
    color: #1B2A2E;
}
.classes-toggle {
    width: 34px;
    height: 34px;
    position: absolute;
    top: 40px;
    right: -22px;
}
.classes-toggle.open {
    transform: rotate(180deg);
}
.breadcrumb .breadcrumb-item,
.breadcrumb .breadcrumb-item a {
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;
    color: #767F82;
}
.breadcrumb .breadcrumb-item a:hover {
    color: #32A0BA;
}
.breadcrumb .breadcrumb-item {
    padding-right: 1rem !important;
}
.breadcrumb .breadcrumb-item:after {
    content: url("data:image/svg+xml,%3Csvg width='7' height='12' viewBox='0 0 7 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L1 11' stroke='%23767F82' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") !important;
    margin-top: -1px;
    padding-left: 1rem !important;
}

.class_name{
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

.class-finished {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    width: 232px;
    padding: 12px 20px;
    border: 1px solid transparent;
    border-radius: 10px;
    background-color: #EFF0F0;
    color: #485558;
    cursor: pointer;
    transition: .2s;
}
.class-finished.active {
    background-color: #B4CF04;
    color: #FFF;
}
.class-finished:not(.active) .unchecked-icon
.class-finished.active .checked-icon {
    display: block;
}
.class-finished:not(.active) .checked-icon,
.class-finished.active .unchecked-icon {
    display: none;
}
.class-finished:not(.active):hover {
    border-color: #BABFC0;
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

    .class-finished {
        margin-top: 0 !important;
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
    <!-- <script src="{{ asset('js/courses/recorded/index.js') }}"></script> -->
    <script src="{{ asset('js/video-courses-classes/show.js') }}"></script>
    <script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>
    <script>getUserRole();getStudent();</script>
    <script>
        $('.classes-toggle').click(function() {
            $(this).toggleClass('open');
            $('.right-side').toggleClass('border-end-0');
            $('.class-video').toggleClass('h-600px');
            $('.recorded-class-row').toggleClass('pe-4');

            if ($(this).hasClass('open')) {
                $('#collapseClassesVideos').hide();
                return;
            }

            $('#collapseClassesVideos').show();
        });
    </script>
@endsection
