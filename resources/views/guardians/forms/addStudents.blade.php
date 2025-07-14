@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Adicionar Responsável
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Adicionar Aluno</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('guardians.addStudentToGuardian', $data['guardian']->id) }}" method="POST" id="student_form">
                            @csrf
                            <div id="student_tab" class="mt-3 visible" data-tab-num="1">
                                <h1>Aluno</h1>
                                <div class="row mt-8">
                                    <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                        <label for="full_name">Nome Completo</label>
                                        <input type="text" class="form-control @error ('student.full_name') is-invalid @enderror" id="full_name"
                                            name="student[full_name]" aria-describedby="student_full_name_feedback"
                                            placeholder="Insira o nome completo" value="{{ old('student.full_name') }}" required>

                                        @error('student.full_name')
                                            <div id="student_full_name_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                        <label for="email">E-Mail</label>
                                        <input type="text" class="form-control @error ('student.email') is-invalid @enderror" id="email"
                                            name="student[email]" aria-describedby="student_email_feedback" placeholder="Insira o e-mail"
                                            value="{{ old('student.email') }}" required>

                                        @error('student.email')
                                            <div id="student_email_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                        <label for="grade">Série</label>
                                        <select class="form-select @error ('student.grade_id') is-invalid @enderror" id="grade"
                                            name="student[grade_id]" aria-describedby="student_grade_feedback" placeholder="Insira a série">

                                            @foreach ($data['grades']  as $grade)
                                                <option value="{{ $grade->id }}" @selected(old('student.grade_id') == $grade->id)>
                                                    {{ $grade->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('student.grade_id')
                                            <div id="student_grade_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                        <label for="language">Idioma que domina</label>
                                        <select class="form-select @error ('student.domain_language_id') is-invalid @enderror" id="language"
                                            name="student[domain_language_id]" aria-describedby="student_domain_language_id_feedback">
                                            @foreach ($data['languages'] as $language)
                                                <option value="{{ $language->id }}" @selected(old('student[domain_language_id]') == $language->id)>{{ $language->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('student.domain_language_id')
                                            <div id="student_domain_language_id_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-8">
                                    <div class="col-lg-5 col-md-5 col-sm-12 pe-5">
                                        <p>Avatar</p>
                                        <input type="hidden" name="student[avatar_id]" value="2">

                                        @for ($i = 1; $i <= 6; $i++)
                                            @if ($i == 2)
                                                <img src="{{ asset('images/avatars/avatar' . $i . '.svg') }}"
                                                    data-id-avatar="{{ $i }}" class="avatar me-2 mb-2 cursor-pointer"
                                                    style="border: 2px solid #229FBA; box-shadow: 0px 0px 5px #40404080">
                                            @else
                                                <img src="{{ asset('images/avatars/avatar' . $i . '.svg') }}" data-id-avatar="{{ $i }}"
                                                    class="avatar me-2 mb-2 cursor-pointer" style="border: 2px solid transparent;">
                                            @endif
                                        @endfor
                                    </div>

                                    <div class="col-lg-5 col-md-5 col-sm-12 pe-5">
                                        <p>Enviar e-mail com acessos ao salvar?</p>
                                        <div class="form-check ps-0 d-flex pt-2 align-items-center">
                                            <input class="emailRadio" type="radio" id="emailConfirm" value="1" name="student[send_email]">
                                            <label class="form-check-label ms-1 me-0" for="emailConfirm">
                                            Sim
                                            </label>

                                            <input class="emailRadio ms-3" type="radio" id="emailDeny" value="0" name="student[send_email]" checked>
                                            <label class="form-check-label ms-1 me-0" for="emailDeny">
                                                Não
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="classroom_tab" class="mt-3 d-none hide" data-tab-num="2">
                                <h1>Turmas</h1>
                                <div class="row mt-8 align-items-center">
                                    <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                        <label for="classroom">{{ __('Turmas') }}</label>
                                        <select class="form-select @error ('student.classrooms') is-invalid @enderror" id="classroom"
                                            aria-describedby="student_classroom_feedback">
                                            <option value="" selected>Selecione...</option>
                                            @foreach ($data['classrooms'] as $classroom)
                                                <option value="{{ $classroom->id }}">
                                                    {{ $classroom->formatted_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('student.classrooms')
                                            <div id="student_classroom_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                                        <a class="btn bg-primary btn-shadow text-white add-classroom"
                                            style="width: 136px; height: 49.75px; margin-top: 23px;" onclick="addClassroom();">
                                            <span class="d-flex align-items-center h-100 justify-content-center">Adicionar</span>
                                        </a>
                                    </div>

                                    <div class="table-responsive my-4">
                                        <table class="table table-curved d-none" id="student_classrooms">
                                            <thead>
                                                <tr>
                                                    <th>Turma</th>
                                                    <th>Qtd. Alunos</th>
                                                    <th>Aulas</th>
                                                    <th>Data de Início</th>
                                                    <th>Opções</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="result_tab" class="mt-3 d-none hide mt-3" data-tab-num="3">
                                <div>
                                    <div class="text-center">
                                        <img src="{{ asset('images/icons/success.svg') }}" alt="success">
                                        <h2 class="my-6">Aluno adicionado com sucesso!</h2>
                                    </div>

                                    <div class="p-8 d-flex justify-content-between align-items-center"
                                        style="border: 1px solid lightgray; border-radius: 8px">
                                        <div class="d-flex text-left">
                                            <div class="me-20">
                                                <span>Nome do Aluno</span>
                                                <p class="m-0" id="student_name" style="color: #8C9497;"></p>
                                            </div>
                                            <div>
                                                <span>Turmas</span>
                                                <p class="m-0" id="student_classrooms" style="color: #8C9497;"></p>
                                            </div>
                                        </div>
                                        <div>
                                            <a class="btn bg-primary text-white d-flex align-items-center justify-content-center"
                                                style="width: 155px; height: 40px;">
                                                Ver Aluno
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-center pt-6">
                                        <a href="{{ route('students.create') }}" style="color: #329FBA;">Adicionar outro aluno</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 d-flex justify-content-end mt-5">
        <button class="btn bg-secondary btn-shadow text-white m-1 back" style="width: 136px; height: 40px;">
            Voltar
        </button>
        <button class="btn bg-primary btn-shadow text-white m-1 next" style="width: 136px; height: 40px;">
            Prosseguir
        </button>
        <button class="btn bg-primary btn-shadow text-white m-1 finish d-none" style="width: 136px; height: 40px;">
            Concluir
        </button>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/students/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/guardians/forms/guardian_shared.js') }}?version={{ getAppVersion() }}"></script>

    <script>
        $('.back').on('click', function () {
            let tabId = $('.visible').attr('id'),
                tabNum = $(`#${tabId}`).attr('data-tab-num');

            if (tabNum > 1) {
                if (tabNum != 1) {
                    $('.finish').addClass('d-none');
                    $('.next').show();
                }
                $(`#${tabId}`).removeClass('visible').addClass('d-none');
                $(`[data-tab-num="${parseInt(tabNum) - 1}"]`).removeClass('d-none').addClass('visible');
            } else {
                history.back();
            }
        });

        $('.next').on('click', function () {
            let tabId = $('.visible').attr('id'),
                tabNum = $(`#${tabId}`).attr('data-tab-num');

            if (tabNum < 2) {
                if (tabNum == 1) {
                    $('.next').hide();
                    $('.finish').removeClass('d-none');
                }
                $(`#${tabId}`).removeClass('visible').addClass('d-none');
                $(`[data-tab-num="${parseInt(tabNum) + 1}"]`).removeClass('d-none').addClass('visible');
            }
        });
    </script>
@endsection
