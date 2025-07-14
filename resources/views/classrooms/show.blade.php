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
                {{ $classroom->formatted_name }}
            </h1>
            <input type="hidden" name="classroom_id" id="classroom_id" value="{{ $classroom->id }}">
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6 classroom-action-row d-flex justify-content-end">
            <div>
                <a href="{{ route('classrooms.recorded-courses', $classroom->id) }}"
                    class="btn bg-danger btn-shadow p-3 me-3">
                    <img src="{{ asset('images/icons/video.svg') }}" alt="Video Icon" />
                    <span class="text-white align-middle">Aulas gravadas</span>
                </a>

                @can('admin')
                    <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn bg-primary btn-shadow p-3 ps-10 pe-10">
                        <span class="text-white">Editar</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    @canany(['admin', 'teacher'])
        <div class="card">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="justify-content-center">
                        <div class="table-container p-0">
                            <div class="row classroom-info">
                                <div class="col-6 col-md-3">
                                    <h4 class="">Quantidade de alunos:</h4>
                                    <h5 class="subtitle-info">{{ $classroom->students->count() }}</h5>
                                </div>
                                <div class="col-6 col-md-3">
                                    {{-- <span class="sub-title">Matérias:</span>
                                    <span class="subtitle-info">Shougakko 6, Japonês</span> --}}
                                </div>
                                <div class="col-6 col-md-3">
                                    {{-- <span class="sub-title">Qtd. de alunos:</span>
                                    <span class="subtitle-info">30</span> --}}
                                </div>
                                <div class="col-6 col-md-3 text-lg-end">
                                    <button class="circle-action-btn expand-profile">
                                        <i class="fas fa-angle-up"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- Lista de horários de aula --}}
                            <div class="classroom-list data-collapse">
                                @php $courses = $classroom->liveCourses; @endphp

                                @foreach ($courses as $key => $course)
                                    <div class="row" data-course-id="{{ $course->id }}">
                                        <div class="col-6 col-md-2">
                                            <span class="sub-title">Nome:</span>
                                            <span class="subtitle-info">{{ $course->formattedName }}</span>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <span class="sub-title">Horário:</span>
                                            <span class="subtitle-info">
                                                {{ formatTime($course->start) }}
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2">
                                            <span class="sub-title">Dias:</span>
                                            <span class="subtitle-info">
                                                {{ $course->weekdays == '' ? '-' : $course->weekdays }}
                                            </span>
                                        </div>
                                        <div class="col-6 col-md-4 pe-5">
                                            <span class="sub-title">Link da aula:</span>
                                            <span class="subtitle-info classroom_link" id="link_{{ $course->id }}">
                                                @if ($course->link == '')
                                                    <span>-</span>
                                                @else
                                                    <a href="{{ $course->link }}" target="_blank">
                                                        {{ $course->link }}
                                                    </a>
                                                    <img class="copy-icon copy-classrom-link"
                                                        src="{{ asset('images/icons/copy.svg') }}" />
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <span class="sub-title">Professor:</span>
                                            <img class="classroom-teacher-photo {{ $course->teacher->trashed() ? 'teacher-deleted-photo' : '' }}"
                                                src="{{ asset("storage/{$course->teacher->profile_photo}") }}" height="30"
                                                alt="User Profile Photo" data-toggle='tooltip' data-placement='top'
                                                title='{{ $course->teacher->name }} {{ $course->teacher->trashed() ? '- Excluído' : '' }}'>
                                        </div>
                                    </div>

                                    @if ($key + 1 < $courses->count())
                                        <hr class="classroom-divider">
                                    @endif
                                @endforeach

                            </div>
                            {{-- Lista de horários de aula --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center d-flex">
            <div class="col-md-6 align-sm-center">
                @canany(['admin', 'teacher'])
                    <div class="d-flex justify-content-start mt-5 mb-5">
                        @can('admin')
                        <button class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10" onclick="showAddStudents();">
                            Adicionar aluno
                        </button>
                        @endcan
                        @if ($classroom->evaluationModel)
                            <a href="{{ route('evaluations.create', $classroom) }}">
                                <button class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10 ms-3">
                                    Nova Avaliação
                                </button>
                            </a>
                        @endif
                    </div>
                @endcanany
            </div>
            <div class="col-md-6 align-sm-center table-filters">
                <div class="d-flex justify-content-end mt-5 mb-5">
                    <div style="text-align: end">
                        <div class="searchbox-table d-flex">
                            <input type="text" class="form-control m-auto" id="search_datatable"
                                placeholder="Faça uma busca..." style="height: 20px">
                            <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                                <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (loggedUser()->can('addStudent', App\Models\Classroom::class))
            <div class="card mb-6" id="add-students" style="height: 170px; display: none;">
                <div class="card-body">
                    <div class="justify-content-center mt-4">
                        <h1>Adicione alunos</h1>

                        <div class="row">
                            <div class="col-6">
                                {{-- <label for="students">Selecione os alunos</label> --}}
                                <select class="form-select select2" id="students">
                                    <option value="" selected>Selecione...</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 d-flex justify-content-end">
                                <div>
                                    <button class="btn bg-secondary btn-shadow text-white p-3 ps-10 pe-10 me-3"
                                        onclick="hideAddStudents();">
                                        Cancelar
                                    </button>
                                    <button class="btn bg-primary btn-shadow text-white p-3 ps-10 pe-10"
                                        onclick="addStudent();">
                                        Adicionar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active tab-title" id="nav-alunos-tab" data-toggle="tab" href="#nav-alunos"
                                role="tab" aria-controls="nav-alunos" aria-selected="true">Alunos</a>
                            @if ($classroom->evaluationModel)
                                <a class="nav-link tab-title" id="nav-avaliacoes-tab" data-toggle="tab"
                                    href="#nav-avaliacoes" role="tab" aria-controls="nav-avaliacoes"
                                    aria-selected="false">Avaliações</a>
                            @endif
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-alunos" role="tabpanel"
                            aria-labelledby="nav-alunos-tab">
                            <div class="table-responsive-sm">
                                <table class="table table-curved mt-5" id="classroom_students">
                                    <thead>
                                        <tr>
                                            <th>Data de início</th>
                                            <th>Nome do aluno</th>
                                            <th>Série</th>
                                            <th class="text-center">Status</th>
                                            @if (loggedUser()->can('removeStudent', App\Models\Classroom::class))
                                                <th>Ações</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classroom->students as $student)
                                            <tr data-id-student="{{ $student->id }}">
                                                <td class="align-middle">
                                                    {{ \Carbon\Carbon::parse($student->pivot->created_at)->format('d/m/Y') }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $student->formatted_full_name }}
                                                    @if($student->pivot->created_at && $student->pivot->created_at->diffInMonths() < 1)
                                                        <span class="badge badge-primary bg-primary ms-2">Novo</span> 
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    {{ $student->grade->name }}
                                                </td>
                                                <td class="align-middle text-center">
                                                    <x-status-badge :status="$student->status" />
                                                </td>
                                                @if (loggedUser()->can('removeStudent', App\Models\Classroom::class))
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="btn-action me-4"
                                                                onclick="removeStudent({{ $student->id }});"
                                                                href="javascript: void(0);">
                                                                <img src="{{ asset('images/icons/trash.svg') }}"
                                                                    alt="">
                                                            </a>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($classroom->evaluationModel)
                            <div class="tab-pane fade" id="nav-avaliacoes" role="tabpanel"
                                aria-labelledby="nav-avaliacoes-tab">
                                <div class="table-responsive-sm">
                                    <table class="table table-curved mt-5" id="classroom_evaluations">
                                        <thead>
                                            <tr>
                                                <th>Data da Aula</th>
                                                <th>Título da aula</th>
                                                <th>Professor</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($classroom->evaluations as $evaluation)
                                                <tr data-id-evaluation="{{ $evaluation->id }}">
                                                    <td class="align-middle">
                                                        {{ $evaluation->date }}
                                                    </td>
                                                    <td class="align-middle title">
                                                        {{ $evaluation->title }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $evaluation->author }}
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <x-btn-action :action="route('evaluations.edit', [
                                                            $classroom->id,
                                                            $evaluation->id,
                                                        ])" icon="pen" />
                                                        <x-btn-action :action="route('evaluations.show', $evaluation->id)" icon="eye" />
                                                        <x-btn-action class="me-4" action="javascript: void(0);"
                                                            icon="trash"
                                                            onclick="modalDeleteEvaluation('{{ $evaluation->id }}');" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endcanany

    @can('guardian')
        <div class="card">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="justify-content-center">
                        <div class="table-container p-0">
                            <h1>Programação</h1>

                            <div class="classroom-list data-collapse">
                                @php $courses = $classroom->liveCourses; @endphp

                                @foreach ($courses as $key => $course)
                                    <div class="row" data-course-id="{{ $course->id }}">
                                        <div class="col-6 col-md-2">
                                            <span class="sub-title">Horário:</span>
                                            <span class="subtitle-info">
                                                {{ formatTime($course->start) }}
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-2">
                                            <span class="sub-title">Dias:</span>
                                            <span class="subtitle-info">
                                                {{ $course->weekdays == '' ? '-' : $course->weekdays }}
                                            </span>
                                        </div>

                                        <div class="col-6 col-md-4 pe-5">
                                            <span class="sub-title">Link da aula:</span>
                                            <span class="subtitle-info classroom_link" id="link_{{ $course->id }}">
                                                @if ($course->link == '')
                                                    <span>-</span>
                                                @else
                                                    <a href="{{ $course->link }}" target="_blank">
                                                        {{ $course->link }}
                                                    </a>
                                                    <img class="copy-icon copy-classrom-link"
                                                        src="{{ asset('images/icons/copy.svg') }}" />
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <span class="sub-title">Professor:</span>
                                            <img class="classroom-teacher-photo"
                                                src="{{ asset("storage/{$course->teacher?->profile_photo}") }}"
                                                height="30" alt="User Profile Photo" data-toggle='tooltip'
                                                data-placement='top' title='{{ $course->teacher?->name }}'>
                                        </div>
                                    </div>

                                    @if ($key + 1 < $courses->count())
                                        <hr class="classroom-divider">
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <div class="modal fade" id="delete_evaluation_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="evaluation_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_evaluation_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_evaluation" type="button" onclick="deleteEvaluationConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/classrooms/show.js') }}?version={{ getAppVersion() }}"></script>
@endsection
