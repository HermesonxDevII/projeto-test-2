@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Aluno Selecionado
@endsection

@section('content')
    @php
        $student = $data['student'];
        $guardian = $data['guardian'];
        $classrooms = $data['classrooms'];
        $address = $data['address'];
    @endphp

    <div class="card student-card">
        <div class="card-body student-card-body">
            <div class="container-fluid p-0">
                <div class="row student-data">
                    <div class=" @if ($student->access_until) col-md-4 @else col-md-5 @endif student-profile-col">
                        <div class="d-flex">
                            @if ($student->avatar_id != 0)
                                <img class="student-avatar"
                                    src="{{ asset('images/avatars/avatar' . $student->avatar_id . '.svg') }}" alt="">
                            @else
                                <img class="student-avatar" src="{{ asset('storage/default.png') }}" alt="">
                            @endif
                            <div class="d-flex flex-column">
                                <b class="student-name title">
                                    {{ $student->full_name }}
                                </b>

                                <div class="d-flex action-line">
                                    <div class="d-flex">
                                        <button class="btn btn-chat btn-shadow call-chat me-2 d-flex d-none">
                                            <span>Chamar no chat</span>
                                            <img src="{{ asset('images/icons/message.svg') }}" alt="">
                                        </button>

                                        @can('admin')
                                            <button class="btn btn-access btn-shadow call-chat me-2 d-flex">
                                                <span>Enviar acessos</span>
                                                <img src="{{ asset('images/icons/send.svg') }}" alt="">
                                            </button>
                                        @endcan

                                        @if (loggedUser()->can('update', $student))
                                            <a href="{{ route('students.edit', $student->id) }}" class="square-action-btn">
                                                <img src="{{ asset('images/icons/pen.svg') }}" alt="">
                                            </a>
                                        @endif

                                        @if ($student->hasValidPreRegistration())
                                            @canany(['teacher', 'admin'])
                                                <a href="{{ route('preRegistration.show', $student->preRegistration->id) }}">
                                                    <button class="btn bg-primary btn-shadow text-white me-2"
                                                        style="width: 148px;
                                                    height: 35px; @can('admin') margin-left: 14px !important @endcan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 16 16" fill="none" style="margin-right: 5px">
                                                            <path
                                                                d="M9.33366 1.3335H4.00033C3.6467 1.3335 3.30756 1.47397 3.05752 1.72402C2.80747 1.97407 2.66699 2.31321 2.66699 2.66683V13.3335C2.66699 13.6871 2.80747 14.0263 3.05752 14.2763C3.30756 14.5264 3.6467 14.6668 4.00033 14.6668H12.0003C12.3539 14.6668 12.6931 14.5264 12.9431 14.2763C13.1932 14.0263 13.3337 13.6871 13.3337 13.3335V5.3335L9.33366 1.3335Z"
                                                                stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path d="M9.33301 1.3335V5.3335H13.333" stroke="white"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path d="M10.6663 8.6665H5.33301" stroke="white" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M10.6663 11.3335H5.33301" stroke="white" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M6.66634 6H5.99967H5.33301" stroke="white"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <span>Questionário</span>
                                                    </button>
                                                </a>
                                            @endcanany
                                        @endif

                                        @if ($student->hasValidPreRegistrationTemporary())
                                            @canany(['teacher', 'admin'])
                                                <a href="{{ route('preRegistrationTemporary.show', $student->preRegistrationTemporary->id) }}">
                                                    <button class="btn bg-primary btn-shadow text-white me-2"
                                                        style="width: 148px;
                                                    height: 35px; @can('admin') margin-left: 14px !important @endcan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 16 16" fill="none" style="margin-right: 5px">
                                                            <path
                                                                d="M9.33366 1.3335H4.00033C3.6467 1.3335 3.30756 1.47397 3.05752 1.72402C2.80747 1.97407 2.66699 2.31321 2.66699 2.66683V13.3335C2.66699 13.6871 2.80747 14.0263 3.05752 14.2763C3.30756 14.5264 3.6467 14.6668 4.00033 14.6668H12.0003C12.3539 14.6668 12.6931 14.5264 12.9431 14.2763C13.1932 14.0263 13.3337 13.6871 13.3337 13.3335V5.3335L9.33366 1.3335Z"
                                                                stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path d="M9.33301 1.3335V5.3335H13.333" stroke="white"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path d="M10.6663 8.6665H5.33301" stroke="white" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M10.6663 11.3335H5.33301" stroke="white" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M6.66634 6H5.99967H5.33301" stroke="white"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <span>Questionário</span>
                                                    </button>
                                                </a>
                                            @endcanany
                                        @endif
                                    </div>
                                    <button class="circle-action-btn expand-profile-mobile d-md-none">
                                        <i class="fas fa-angle-up"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    @if ($student->access_until)
                        <div class="col-md-2">
                            <span class="sub-title">Acesso até</span>
                            <span class="student-info">{{ $student->access_until }}</span>
                        </div>
                    @endif

                    @if ($student->lastAccessLog?->accessed_at)
                        <div class="col-md-2">
                            <span class="sub-title">Último acesso</span>
                            <span class="student-info">{{ $student->lastAccessLog?->accessed_at?->format('d/m/Y \á\s H:i') }}</span>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <span class="sub-title">Série</span>
                        <span class="student-info">{{ $student->grade->name }}</span>
                    </div>
                    <div class="col-md-2">
                        <span class="sub-title">Idioma que domina</span>
                        <span class="language-badge">
                            <img height="25"
                                src="{{ asset('images/icons/languages/language_' . $student->domain_language_id . '.svg') }}"
                                alt="language-flag">
                            {{ $student->domain_language->name }}
                        </span>
                    </div>

                    @can('admin')
                        <div class="col-md-1 d-flex justify-content-end">
                            <button class="circle-action-btn expand-profile d-none d-md-block">
                                <i class="fas fa-angle-up"></i>
                            </button>
                        </div>
                    @endcan

                </div>

                @can('admin')
                    <div class="row student-data student-data-collapse">
                        <hr class="hr-divider collapse-divider" />
                        @if ($student->notes)
                            <div class="col-12">
                                <span class="sub-title">Observação</span>
                                <span class="student-info">{!! nl2br(htmlspecialchars($student->notes)) !!}</span>
                            </div>
                        @endif
                        <hr class="hr-divider collapse-divider" />
                        <div class="col-md-3">
                            <span class="sub-title">Nome do responsável</span>
                            <span class="student-info">{{ optional($guardian)->name }}</span>
                            @if( optional($guardian->consultancy)->has_consultancy )
                                <span class="consultancy-badge">
                                    Consultoria realizada
                                </span>
                            @endif                            
                        </div>
                        <div class="col-md-2">
                            <span class="sub-title">Email</span>
                            <span class="student-info">{{ optional($guardian)->email }}</span>
                        </div>
                        <div class="col-md-2">
                            <span class="sub-title">Telefone</span>
                            <span class="student-info">{{ optional($guardian)->phone_number }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="sub-title">Endereço completo</span>
                            <span class="student-info">{{ optional($guardian)->full_address }}</span>
                        </div>
                        <div class="col-md-1 d-flex justify-content-end">
                            <a href="{{ $guardian ? route('guardians.edit', $guardian->id) : '#' }}" class="square-action-btn">
                                <img src="{{ asset('images/icons/pen.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                @endcan
                @can('teacher')
                    <div class="row student-data student-data-collapse">
                        <hr class="hr-divider collapse-divider" />
                        @if ($student->notes)
                            <div class="col-12">
                                <span class="sub-title">Observação</span>
                                <span class="student-info">{!! nl2br(htmlspecialchars($student->notes)) !!}</span>
                            </div>
                        @endif
                    </div>
                @endcan

            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a 
                            class="nav-link active tab-title" 
                            id="nav-classrooms-tab" 
                            data-toggle="tab" 
                            href="#nav-classrooms-home" 
                            role="tab" 
                            aria-controls="nav-classrooms-home" 
                            aria-selected="true"
                        >
                            Turmas
                        </a>
                        <a 
                            class="nav-link tab-title" 
                            id="nav-evaluations-tab" 
                            data-toggle="tab" 
                            href="#nav-evaluations" 
                            role="tab" 
                            aria-controls="nav-evaluations" 
                            aria-selected="false"
                        >
                            Avaliações
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div id="nav-classrooms-home" class="tab-pane fade show active"  role="tabpanel" aria-labelledby="nav-classrooms-tab">
                        <div class="table-responsive-md">
                            <table class="table table-curved mt-5" id="table-student-classrooms">
                                <thead>
                                    <tr>
                                        <th>Turma</th>
                                        <th>Qtd. Alunos</th>
                                        <th>Aulas</th>
                                        <th>Horários</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classrooms as $classroom)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $classroom->formatted_name }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $classroom->students->count() }} Alunos
                                            </td>
                                            <td class="align-middle">
                                                {{ $classroom->weekdays == '' ? '-' : $classroom->weekdays }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $classroom->startEnd }}
                                            </td>
                                            <td class="align-middle">
                                                {{-- <i class="fas fa-link link text-muted"></i> --}}
                                                @if (loggedUser()->can('view', $classroom))
                                                    <x-btn-action class="me-2" disabled :action="route('classrooms.show', $classroom->id)"
                                                        icon="eye" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="nav-evaluations" class="tab-pane fade"  role="tabpanel" aria-labelledby="nav-evaluations-tab" data-student-id="{{ $student->id }}">
                        <div class="mt-5 pt-5" id="select-evaluations">
                            <form id="report-download-form">
                                @csrf
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center gap-2">
                                        <!-- Input para o período (Date Range) -->
                                        <input type="text" id="evaluation-period" class="form-control"
                                            style="width: 327px; height: 40px; font-size:14px;
                                        border: 1px solid #8C9497; border-radius: 12px;"
                                            placeholder="Selecione o período" data-route="{{  route('classrooms.getClassroomWithEvaluationsByPeriod') }}"/>

                                        <!-- Select de turmas -->
                                        <select 
                                            id="export-classroom-select" 
                                            class="form-control filter-select"
                                            style="width: 327px !important; height: 40px; font-size:14px; border: 1px solid #8C9497; border-radius: 12px; transition: none !important; color: #5e6278 !important;"
                                            data-fetch-route="{{ route('students.evaluations.byPeriodAndClassroom') }}"
                                        >
                                        </select>
                                    </div>
                                    
                                    <button  
                                        type="button" 
                                        id="evaluation-download"
                                        onclick="submitEvaluationReportDownload()"
                                    >
                                        <img src="{{ asset('images/icons/download.png') }}" alt="">
                                    </button >
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-curved mt-5" id="table-student-evaluations">
                                <thead>
                                    <tr>
                                        <th>Aula</th>
                                        <th>Participação</th>
                                        <th>Tarefas</th>
                                        <th>Comportamento</th>
                                        <th>Câmera</th>
                                        <th>Comentários</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="send_access_guardian_modal" tabindex="-1" role="dialog"
        aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="guardian_to_send_access" value="{{ optional($guardian)->id }}">
                        <img src="{{ asset('images/icons/send-2.svg') }}" alt="send" class="my-2">
                        <h3 class="my-3">Você tem certeza que gostaria de gerar e enviar uma nova senha?</h3>
                        <p>{{ optional($guardian)->email }}</p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="btn_guardian_access_send" type="button"
                        class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>ENVIAR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="comment-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h3 id="comment-title"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <textarea id="comment-textarea" class="form-control" name="comment-textarea" cols="30" rows="10" placeholder="Digite Aqui..."
                        style="height: 100px"></textarea @disabled(true)>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn bg-secondary btn-shadow text-white" style="padding: 10px 30px;"
                        data-bs-dismiss="modal">
                        <span>Fechar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
        const messageIconUrl = "{{ asset('images/icons/message-square.svg') }}";
        const evaluationsDownloadUrl = "{{ route('students.evaluations.download') }}";
    </script>
    <script src="{{ asset('js/students/forms/student_create.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/students/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/students/show.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/guardians/show.js') }}?version={{ getAppVersion() }}"></script>
@endsection

@section('extra-styles')
    <style>
        .btn-comment {
            background-color: #329fba !important;
        }
    </style>
@endsection
