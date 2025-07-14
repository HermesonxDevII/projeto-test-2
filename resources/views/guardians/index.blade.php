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
    </style>
@endsection

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Responsáveis
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Responsáveis</h1>
        </div>
        <div class="col" style="text-align: end;">
            <a href="{{ route('guardians.create') }}">
                <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                    <span class="text-white">Adicionar Novo</span>
                </button>
            </a>
        </div>
    </div>
    

    <div class="table-filters" style="display: flex; justify-content: end;">
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
        <div style="text-align: end; display: flex; ; margin-bottom: 30px">
            <div class="searchbox-table d-flex" style="width: 253px; height: 40px;">
                <input type="text" class="form-control m-auto" id="search_datatable" placeholder="Faça uma busca..."
                    style="height: 20px">
                <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                    <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        @include('guardians.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- begin:Delete Guardian Modal --}}
    <div class="modal fade" id="delete_guardian_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="guardian_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_guardian_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_guardian" type="button" onclick="deleteGuardianComfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:Delete Guardian Modal --}}

    {{-- begin:Delete consultancy Guardian Modal --}}
    <div class="modal fade" id="delete_consultancy_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="guardian_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você gostaria de desmarcar a<br> consultoria?</h3>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_guardian" type="button" onclick="updateConsultancyGuardian(false, 'delete');"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>Desmarcar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:Delete consultancy Guardian Modal --}}

    {{-- begin:Guardian Has Students --}}
    <div class="modal fade" id="guardian_has_students" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="guardian_to_edit">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Não é possível excluir <br> este responsável.</h3>
                        <p>Este responsável possui <span id="guardian_has_students_item"></span> aluno(s) vinculado(s).
                            Remova os alunos vinculados para apagá-lo.
                        </p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_guardian" type="button" onclick="editGuardian();"
                        class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>Editar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:Guardian Has Students --}}

    {{-- begin:Confirm consultancy Guardian --}}
    <div class="modal fade" id="confirm_consultancy_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="guardian_to_confirm">
                        <img src="{{ asset('images/icons/check-circle.png') }}" alt="warning" class="my-2" style="width: 64px; height: 64px;">
                        {{-- <i class="fa-regular fa-circle-check icon-check-true my-2"> --}}
                        <h3 class="my-3">Você gostaria de marcar essa<br> consultoria como realizada?</h3>
                        </p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="confirm_consultancy_guardian" type="button" onclick="updateConsultancyGuardian(true, 'confirm');"
                        class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>Sim</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:Confirm consultancy Guardian --}}
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/guardians/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection
