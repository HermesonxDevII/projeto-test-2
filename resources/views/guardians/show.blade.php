@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Responsável Selecionado
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">{{ $guardian->name }}</h1>
        </div>

        <div class="card mt-5">
            <div class="card-body pt-10 pb-9">
                <div class="container-fluid p-0">
                    <div class="row classroom-info">
                        <div class="col-6 col-md-3">
                            <span class="sub-title">Email:</span>
                            <span class="subtitle-info">{{ $guardian->email }}</span>
                            @if( optional($guardian->consultancy)->has_consultancy )
                                <span class="consultancy-badge">
                                    Consultoria realizada
                                </span>
                            @endif
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="sub-title">Telefone:</span>
                            <span class="subtitle-info">{{ $guardian->phone_number }}</span>
                            <a href="https://api.whatsapp.com/send?1=pt_BR&phone=55{{$guardian->phone_number}}" target="_blank"
                                class="btn btn-whats ms-2">
                                <img src="{{asset('images/icons/whatsapp_icon.svg')}}" class="whats_icon" alt="whatsapp logo"/>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="sub-title">Endereço:</span>
                            <span class="subtitle-info">{{ $guardian->full_address }}</span>
                        </div>
                        <div class="col-6 col-md-3 text-lg-end">
                            <button class="square-action-btn expand-profile">
                                <a href="{{ route('guardians.edit', $guardian->id) }}" class="btn action-btn">
                                    <img src="{{ asset('images/icons/pen.svg') }}" alt="Edit Guardian Icon">
                                </a>
                            </button>
                            <button class="btn btn-access btn-shadow call-chat ms-2">
                                <span>Enviar acessos</span>
                                <img src="{{ asset('images/icons/send.svg') }}" alt="">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="row mb-8">
                        <div class="col">
                            <h1 class="p-0 mb-5">Alunos vinculados</h1>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('guardians.addStudent', $guardian->id) }}">
                                <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                                    <span class="text-white">Adicionar Aluno</span>
                                </button>
                            </a>
                        </div>
                    </div>

                    @foreach ($guardian->students as $student)
                        <div class="row row-info">
                            <div class="col-6 col-md-3">
                                <span class="sub-title">Nome do aluno:</span>
                                <span class="subtitle-info">
                                    {{ $student->formattedFullName }}
                                </span>
                            </div>
                            <div class="col-6 col-md-3">
                                <span class="sub-title">Dia das aulas:</span>
                                <span class="subtitle-info">
                                    {{ $student->coursesWeekdays }}
                                </span>
                            </div>
                            <div class="col-6 col-md-5">
                                <span class="sub-title">Turmas:</span>
                                <span class="subtitle-info">{{ $student->classroomsList }}</span>
                            </div>
                            <div class="col-6 col-md-1 text-lg-end d-flex align-items-center justify-content-end">
                                <button class="square-action-btn btn-shadow expand-profile">
                                    <a href="{{ route('students.show', $student->id) }}" class="btn action-btn">
                                        <img src="{{ asset('images/icons/eye.svg') }}" alt="Show Student Icon">
                                    </a>
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="send_access_guardian_modal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="guardian_to_send_access" value="{{$guardian->id}}">
                        <img src="{{ asset('images/icons/send-2.svg') }}" alt="send" class="my-2">
                        <h3 class="my-3">Você tem certeza que gostaria de gerar e enviar uma nova senha?</h3>
                        <p>{{$guardian->email}}</p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
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
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/guardians/forms/guardian_edit.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/guardians/forms/guardian_shared.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/guardians/show.js') }}?version={{ getAppVersion() }}"></script>
@endsection
