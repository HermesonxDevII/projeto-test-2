@extends('layouts.app')
@section('extra-styles')
    <style>
        .filter-input {
            width: auto;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: #FFF;
            padding: 11px 18px;
            font-family: Roboto, sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #1B2A2E;
        }

        .filter-input::placeholder {
            color: #1B2A2E;
        }

        .filter-select {
            font-family: Roboto, sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #1B2A2E;
            width: auto !important;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: #FFF;
            padding: 9px 30px 11px 18px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("{{ asset('images/icons/angle_down_icon.svg') }}");
            background-repeat: no-repeat;
            background-position: right 5px center;
            background-size: 20px;
        }

        .filter-select:active {
            background-image: url("{{ asset('images/icons/angle_up_icon.svg') }}");
            background-position: right 5px center;
            outline: none;
            box-shadow: none;
        }

        .filter-select:focus,
        .filter-input {
            border: none;
            outline: none;
            box-shadow: none;
        }

        .filter-select option:hover {
            background: #329FBA;
            color: #FFF;
        }

        .export a {
            font-family: Roboto;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            text-align: center;
            color: #767F82;
            transition: color 400ms ease;
            margin-right: 21px;
            cursor: pointer;
        }

        .export a:hover {
            color: #329FBA;
        }

        .checkboxes {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .checkboxes input:not(.other) {
            width: 18px;
            height: 18px;
            margin-right: 11px;
            border-radius: 3px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            appearance: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFF;
            transition: background 0.2s ease-in-out;
            font-weight: 500;
            font-size: 13px;
        }

        .checkboxes label {
            display: flex;
            align-items: center;
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .checkboxes input:checked::before {
            content: '✔';
        }

        .checkboxes input:checked {
            background: var(--colors-brand-primary, #50B4D8);
            border: 0;
        }

        /* Estilo do "select" customizado */
        /* Estilo do "select" customizado */
        .custom-select-box {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 40px;
            border: 1px solid #D1D4D5;
            border-radius: 12px;
            padding: 10px 18px;
            background-color: #FFF;
            cursor: pointer;
            font-family: Roboto, sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #1B2A2E;
        }

        /* Placeholder para a caixa */
        #select-placeholder {
            color: #5e6278;
            font-weight: 500;
        }

        /* Dropdown escondido inicialmente */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #FFF;
            min-width: 100%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 12px;
            z-index: 1;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #D1D4D5;
            border-radius: 12px;
            left: 0px;
            top: 38px;
            gap: 10px;
        }

        .custom-select-box.active .dropdown-content {
            display: flex;
        }
    </style>
@endsection

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Alunos
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px;
                align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Alunos</h1>
        </div>

        @if (loggedUser()->can('delete', App\Models\Student::class))
            <div class="col" style="text-align: end;">
                <span class="export">
                    <a href="{{ route('students.export', request()->all()) }}">
                        Exportar alunos
                    </a>
                </span>
                <a href="{{ route('students.create') }}">
                    <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                        <span class="text-white">Adicionar Aluno</span>
                    </button>
                </a>
            </div>
        @endif
    </div>

    <div class="table-filters d-flex justify-content-end align-items-center mb-4">
        @if (loggedUser()->is_administrator)
            <div id="actions-container" class="me-4" style="display: none;">
                <select id="student-actions" class="filter-select" style="width: 150px; height: 40px;">
                    <option value="">Ações</option>
                    <option value="change-classroom">Incluir em Turma</option>
                    <option value="remove-classroom">Remover de Turma</option>
                    <option value="include-in-courses">Incluir em Cursos</option>
                    <option value="change-serie">Alterar Serie</option>
                </select>
            </div>
        @endif
        <div class="me-4">
            <input id="period" type="text" class="filter-input" placeholder="Período" autocomplete="off" />
        </div>
        <div class="me-4">
            <select id="filter_grade" class="filter-select" style="width: 150px; height: 40px;">
                <option value="">Série</option>
                @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="me-4">
            <select id="filter_classroom" class="filter-select" style="width: 150px; height: 40px;">
                <option value="">Turma</option>
                @foreach ($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->formatted_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="me-4">
            <select id="filter_status" class="filter-select" style="width: 150px; height: 40px;">
                <option value="">Status</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        <div class="searchbox-table d-flex" style="width: 253px; height: 40px;">
            <input
                type="text"
                class="form-control m-auto"
                id="search_datatable"
                placeholder="Faça uma busca..."
                style="height: 20px"
            />
            
            <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
            </button>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        @include('students.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Exclusão de Estudante -->
    <div
        class="modal fade"
        id="delete_student_modal"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="student_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_student_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal"
                    >
                        <span> Cancelar </span>
                    </button>

                    <a
                        id="delete_student"
                        type="button"
                        onclick="deleteStudentComfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button"
                    >
                        <span> EXCLUIR </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Inclusão de Turma -->
    <div
        class="modal fade"
        id="change_classroom_modal"
        tabindex="-1"
        aria-labelledby="changeClassroomModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px !important;">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 d-flex align-items-center justify-content-center align-text">
                        <span
                            id="changeClassroomModalLabel"
                            style="text-align: center; margin-bottom: 15px; color: #485558;font-size: 20px; font-weight: 600;"
                        >
                            Selecione uma turma para inclusão<br> do(s) aluno(s)
                        </span>
                    </div>

                    <form id="change-classroom-form">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <select
                                id="classroom-select"
                                class="form-control"
                                style="width: 327px !important; height: 40px !important; font-size:14px; border: 1px solid #8C9497; border-radius: 12px;"
                            ></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="justify-content: center !important;">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal"
                    > Cancelar </button>
                    
                    <button
                        type="button"
                        class="btn bg-primary btn-shadow"
                        style="width: 155px; height: 40px; color: #FFF"
                        onclick="submitClassroomChange()"
                    > Confirmar </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Inclusão de Curso -->
    <div
        class="modal fade"
        id="include_courses_modal"
        tabindex="-1"
        aria-labelledby="includeCoursesModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px !important;">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 d-flex align-items-center justify-content-center align-text">
                        <span
                            id="changeClassroomModalLabel"
                            style="text-align: center; margin-bottom: 15px; color: #485558; font-size: 20px; font-weight: 600;"
                        >
                            Selecione um ou mais cursos para<br> inclusão do(s) aluno(s)
                        </span>
                    </div>
                    <form id="include-courses-form">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <div
                                class="custom-select-box"
                                style="width: 327px !important; height: 40px !important; font-size:14px; border: 1px solid #8C9497; border-radius: 12px;"
                                onclick="toggleDropdown(event)"
                            >
                                <span id="select-placeholder">Selecione os Cursos</span>
                                <div id="course-dropdown" class="dropdown-content checkboxes">
                                    @foreach ($courses as $course)
                                        <label onclick="stopCheckboxPropagation(event)">
                                            <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                                onclick="stopCheckboxPropagation(event)">
                                            {{ $course->title }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="justify-content: center !important;">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"    
                        data-bs-dismiss="modal"
                    > Cancelar </button>
                    
                    <button
                        type="button"
                        class="btn bg-primary btn-shadow"
                        style="width: 155px; height: 40px; color: #FFF"
                        onclick="submitCoursesSelection()"
                    > Confirmar </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Remoção de Turma -->
    <div
        class="modal fade"
        id="remove_classroom_modal"
        tabindex="-1"
        aria-labelledby="removeClassroomModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px !important;">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 d-flex align-items-center justify-content-center align-text">
                        <span
                            id="removeClassroomModalLabel"
                            style="text-align: center; margin-bottom: 15px; color: #485558; font-size: 20px; font-weight: 600;"
                        >
                            Selecione uma ou mais turmas para<br> remover do(s) aluno(s)
                        </span>
                    </div>
                    <form id="remove-classroom-form">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <div
                                class="custom-select-box"
                                id="remove-classroom-select-box"
                                style="width: 327px !important; height: 40px !important; font-size:14px; border: 1px solid #8C9497; border-radius: 12px;"
                                onclick="toggleClassroomDropdown(event)"
                            >
                                <span id="select-placeholder">Selecione as Turmas</span>
                                <div id="classroom-dropdown" class="dropdown-content checkboxes"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="justify-content: center !important;">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal"
                    > Cancelar </button>
                    
                    <button
                        type="button"
                        class="btn bg-primary btn-shadow"
                        style="width: 155px; height: 40px; color: #FFF"
                        onclick="submitClassroomRemoval()"
                    > Confirmar </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Remoção -->
    <div
        class="modal fade"
        id="removal_confirmation_modal"
        tabindex="-1"
        aria-labelledby="removalConfirmationModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <img
                            src="{{ asset('images/icons/x-circle.svg') }}"
                            alt="warning"
                            class="my-2"
                            style="width: 80px; height: 80px;"
                        />
                        
                        <p class="my-3" style="color: #485558; font-size: 18px; font-weight: 500; line-height: 1.4;">
                            Você tem certeza, que gostaria de remover <span id="student-count" style="color: #329FBA; font-weight: 600;">0</span> alunos da <span id="classroom-name" style="color: #329FBA; font-weight: 600;">turma</span> ?
                        </p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal"
                        style="width: 120px; height: 40px; font-size: 14px; font-weight: 600;"
                    >
                        <span> Cancelar </span>
                    </button>

                    <button
                        type="button"
                        id="confirm-removal-btn"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button"
                        style="width: 120px; height: 40px; font-size: 14px; font-weight: 600;"
                    >
                        <span> Confirmar </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Mudança de Série -->
    <div
        class="modal fade"
        id="change_series_modal"
        tabindex="-1"
        aria-labelledby="changeClassroomModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px !important;">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 d-flex align-items-center justify-content-center align-text">
                        <span
                            id="changeClassroomModalLabel"
                            style="text-align: center; margin-bottom: 15px; color: #485558;font-size: 20px; font-weight: 600;"
                        >
                            Selecione a próxima série<br> do(s) aluno(s)
                        </span>
                    </div>

                    <form id="change-classroom-form">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <select
                                id="series-select"
                                class="form-control"
                                style="width: 327px !important; height: 40px !important; font-size:14px; border: 1px solid #8C9497; border-radius: 12px;"
                            >   
                                <option value="">Selecione a série</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="justify-content: center !important;">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal"
                    > Cancelar </button>
                    
                    <button
                        type="button"
                        class="btn bg-primary btn-shadow"
                        style="width: 155px; height: 40px; color: #FFF"
                        onclick="submitSeriesChange()"
                    > Confirmar </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Relatório de Avaliações -->
    <div
        class="modal fade"
        id="export_modal"
        tabindex="-1"
        aria-labelledby="exportModalLabel"
        aria-hidden="true"
        data-route="{{ route('students.evaluations.download') }}"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px !important;">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 d-flex align-items-center justify-content-center align-text">
                        <span
                            id="exportModalLabel"
                            style="text-align: center; margin-bottom: 15px; color: #485558; font-size: 20px; font-weight: 600;"
                        >
                            Relatório de avaliações
                        </span>
                    </div>
                    <form id="report-download-form">
                        @csrf
                        <div class="form-group d-flex flex-column align-items-center justify-content-center gap-2">
                            <!-- Input para o período (Date Range) -->
                            <input
                                type="text"
                                id="evaluation-period"
                                class="form-control"
                                style="width: 327px; height: 40px; font-size:14px; border: 1px solid #8C9497; border-radius: 12px;"
                                placeholder="Selecione o período"
                                data-route="{{  route('classrooms.getClassroomWithEvaluationsByPeriod') }}"
                            />

                            <!-- Select de turmas -->
                            <select
                                id="export-classroom-select"
                                class="form-control filter-select"
                                style="width: 327px !important; height: 40px; font-size:14px; border: 1px solid #8C9497; border-radius: 12px; transition: none !important; color: #5e6278 !important;"
                            ></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="justify-content: center !important;">
                    <button
                        type="button"
                        class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal"
                    > Cancelar </button>
                    
                    <button
                        type="button"
                        id="evaluation-download"
                        class="btn bg-primary btn-shadow"
                        style="width: 155px; height: 40px; color: #FFF"
                        onclick="submitEvaluationReportDownload()"
                    > Baixar </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/students/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection