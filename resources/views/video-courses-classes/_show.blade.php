@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Nome da Aula
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-8">
        <div>
            <h3 class="classes-furigana-title">しょうがく１ねんせいかんじ</h3>
            <div class="d-flex align-items-center gap-3">
                <h1 class="classes-original-title">
                    小学１年生漢字
                </h1>
                <h2 class="classes-translated-title">Nível Shougakkou 1 nensei (Números)</h2>
            </div>

        </div>

        <a href="{{ route('video-courses.show', 1) }}" class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body recorded-class-card">
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
                    <div class="d-flex">
                        <div class="m-w-75">
                @enddesktop

                        @if (1)
                            <iframe class="class-video d-block main-video"
                                src="https://www.youtube.com/embed/gntOMJrT2zQ"
                                title="Aula 1"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen style="margin-top: 40px !important;">
                            </iframe>
                        @else
                            <div class="embed-iframe" style="margin-top: 40px !important;">
                                <iframe src="https://www.youtube.com/embed/gntOMJrT2zQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-8 course-details">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h1 class="course_name_active" style="margin-top:4px !important; margin-bottom: 7px !important">Nome do Curso</h1>

                                    <button class="btn bg-primary p-2 d-flex justify-content-center align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClassesVideos" aria-expanded="false" aria-controls="collapseClassesVideos">
                                        <svg width="26" height="26" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.46967 6.59467C8.74003 6.32431 9.16546 6.30351 9.45967 6.53228L9.53033 6.59467L13.2803 10.3447C13.5732 10.6376 13.5732 11.1124 13.2803 11.4053C13.01 11.6757 12.5845 11.6965 12.2903 11.4677L12.2197 11.4053L9 8.18625L5.78033 11.4053C5.50997 11.6757 5.08454 11.6965 4.79033 11.4677L4.71967 11.4053C4.44931 11.135 4.42851 10.7095 4.65728 10.4153L4.71967 10.3447L8.46967 6.59467Z" fill="#FFF"/>
                                        </svg>
                                    </button>
                                </div>
                                <span class="teacher-name">Prof. Teste</span>
                            </div>

                            @can('guardian')
                                <label class="course_item btn course-finished bg-primary " for="course_1_status">
                                    <input @checked(true)  onclick="markCourse(1);" class="markCourse {{ true ? 'finished-class-checkbox-primary' : 'finished-class-checkbox' }}" type="checkbox" id="course_1_status">
                                    <span class="text-white">Aula finalizada</span>
                                </label>
                            @endcan

                        </div>

                        <nav class="mt-5">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <span class="nav-link active tab-title" id="description-tab" data-toggle="tab" href="#description"
                                    role="tab" aria-controls="description" aria-selected="true">
                                    Descrição
                                </span>
                                <span class="nav-link tab-title" id="materials-tab" data-toggle="tab" href="#materials"
                                    role="tab" aria-controls="materials" aria-selected="true">
                                    Materiais
                                </span>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="class-description mt-4">
                                    <pre>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione odio commodi ut sit quae porro quisquam, deserunt, molestias ipsam repellendus harum repellat amet quia earum aliquam dolorem accusamus, odit debitis.</pre>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                <div class="class-material mt-4">
                                    <div class="file-list-item d-flex justify-content-between">
                                        <div class="file-icon me-3">
                                            <img height="30" src="{{ asset('images/icons/file-pdf.svg') }}">
                                        </div>
                                        <div class="file-details w-100">
                                            <b class="d-block">Arquivo</b>
                                            <small class="text-muted"> 200 </small>
                                        </div>
                                        <div class="file-actions">
                                            <a href="/file/material/1/view" target="_blank">
                                                <div class="btn bg-primary">
                                                    <img height="20" src="{{ asset('images/icons/eye.svg') }}">
                                                </div>
                                            </a>
                                            <a href="/file/material/1" target="_blank">
                                                <div class="btn bg-primary">
                                                    <img height="20" src="{{ asset('images/icons/download.svg') }}">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @desktop
                        <div class="">
                    @enddesktop
                    @tablet
                        <div class="col-md-12 pt-7 left-side" style="padding-left: 0px !important">
                    @endtablet
                    @mobile
                        <div class="col-md-12 pe-4 pt-3 left-side">
                    @endmobile
                        <div class="collapse collapse-horizontal pt-10" id="collapseClassesVideos">
                            <div class="d-flex align-items-center">
                                <h2 class="mt-2 d-inline">Nome do Módulo</h2>
                                @can('guardian')
                                    <div class="progress-area" style="width: 100%">
                                        <div class="progress mt-3 mb-2" style="height:7px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%;"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="progress-value">
                                            {{ round($statistics['percentage'], 0) }}%
                                        </span>
                                    </div>
                                @endcan
                            </div>
                            <hr style="border: 2px solid #daeef1c4">
                            <div class="video-classes-videos" style="overflow-y:scroll; height: 600px; margin-top:20px;">                                    
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex mb-5 align-items-stretch course-item" onclick="selectCourseAndScrollTop(1)">
                                    <div>
                                        <label class="d-flex">
                                            <img style="width: 120px; heigth:90px; border-radius:10px" src="//img.youtube.com/vi/gntOMJrT2zQ/0.jpg">
                                        </label>
                                    </div>
                                    @can('guardian')
                                        <input type="checkbox" class="course-checkbox" style="margin-left:10px; margin-right: 10px;" id="course_1"
                                            @checked($student->courseIsDone(true)) disabled/>
                                    @endcan
                                    <div @canany(['admin', 'teacher']) style="margin-left:20px; @endcanany">
                                        <label class="d-flex">
                                            <span class="course_name" id="course_name_1">Nome do Curso</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-styles')
    <style>
        .collapse-horizontal.collapse.show {
            min-width: 360px;
            border-left: 1px solid #F4F4F5;
            margin-left: 20px;
            padding-left: 20px;
        }
        [data-bs-toggle="collapse"][aria-expanded="false"] > svg {
            transform: rotate(-90deg);
        }
        [data-bs-toggle="collapse"][aria-expanded="true"] > svg {
            transform: rotate(-270deg);
        }
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
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/courses/recorded/index.js') }}"></script>
    <script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>
    <script>getUserRole();getStudent();</script>
@endsection
