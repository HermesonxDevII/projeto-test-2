@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Turma Selecionada
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <h1 class="p-0 m-0 classroom-title">
                {{ $videoCourse->title }}
            </h1>
            <input type="hidden" name="video_course_id" id="video_course_id" value="{{ $videoCourse->id }}">
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6 classroom-action-row d-flex justify-content-end">
            <div>
                <a href="{{ route('video-courses.show', $videoCourse->id) }}"
                    class="btn bg-danger btn-shadow py-3 px-10">
                    <img src="{{ asset('images/icons/video.svg') }}" alt="Video Icon" />
                    <span class="text-white align-middle ms-3">Aulas</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row align-items-center d-flex">
        <div class="col-md-6 align-sm-center">
            <div class="d-flex justify-content-start mt-5 mb-5">
                <button class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10" onclick="showAddStudents();">
                    Adicionar aluno
                </button>
            </div>
        </div>
        <div class="col-md-6 align-sm-center table-filters">
            <div class="d-flex justify-content-end mt-5 mb-5">
                <div style="text-align: end">
                    <div class="searchbox-table d-flex">
                        <input type="text" class="form-control m-auto" id="search_datatable" placeholder="Faça uma busca..." style="height: 20px">
                        <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                            <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-6" id="add-students" style="height: 170px; display: none;">
        <div class="card-body">
            <div class="justify-content-center mt-4">
                <h1>Adicione alunos</h1>

                <div class="row">
                    <div class="col-6">
                        <select class="form-select select2" id="students">
                            <option value="" selected>Selecione...</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <div>
                            <button class="btn bg-secondary btn-shadow text-white p-3 ps-10 pe-10 me-3" onclick="hideAddStudents();">
                                Cancelar
                            </button>
                            <button class="btn bg-primary btn-shadow text-white p-3 ps-10 pe-10" onclick="addStudent();">
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <span class="nav-link active tab-title" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Alunos</span>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="table-responsive-sm">
                            <table class="table table-curved mt-5" id="video_course_students">
                                <thead>
                                    <tr>
                                        <th>Data de início</th>
                                        <th>Nome do aluno</th>
                                        <th>Responsável</th>
                                        <th class="text-center">Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videoCourse->students as $student)
                                        <tr data-id-student="{{ $student->id }}">
                                            <td class="align-middle">
                                                @if(isset($student->pivot->created_at))
                                                    {{ \Carbon\Carbon::parse($student->pivot->created_at)->translatedFormat('d \\de M \\de Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($student->created_at)->translatedFormat('d \\de M \\de Y') }}
                                                @endif                                                
                                            </td>
                                            <td class="align-middle name">
                                                {{ $student->formatted_full_name }}
                                                @if($student->pivot->created_at && $student->pivot->created_at->diffInMonths() < 1)
                                                    <span class="badge badge-primary bg-primary ms-2">Novo</span> 
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                {{ $student->guardian?->name ?? 'Não definido' }}
                                            </td>
                                            <td class="align-middle text-center">
                                                <x-status-badge :status="$student->status" />
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn-action me-4" onclick="modalDeleteStudent({{ $student->id }});" href="javascript: void(0);">
                                                        <img src="{{ asset("images/icons/trash.svg") }}" alt="">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_video_course_student_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="student_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_video_course_student_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_video_course" type="button" onclick="deleteStudentConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')
    <script src="{{ asset('js/video-courses/students.js') }}"></script>
@endsection
