@php
    $languages = $data['languages'];
    $classrooms = $data['classrooms'];
@endphp

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('students.store') }}" method="POST" id="student_form">
    @csrf
    <div id="guardian_tab" class="visible mt-3" data-tab-num="1">
        <h1>Responsável</h1>
        <div class="row mt-8">
            <input type="hidden" name="guardian[id]" id="guardian_id" value="{{ old('guardian.id') }}">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="guardian_email">E-Mail</label>
                <input type="text" class="form-control @error ('guardian.email') is-invalid @enderror"
                    id="guardian_email" name="guardian[email]" aria-describedby="guardian_email_feedback"
                    placeholder="Insira o E-mail" value="{{ old('guardian.email') }}" required>

                @error('guardian.email')
                    <div id="guardian_email_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="guardian_name">Nome Completo</label>
                <input type="text" class="form-control @error ('guardian.name') is-invalid @enderror" id="guardian_name"
                    name="guardian[name]" aria-describedby="guardian_name_feedback" placeholder="Insira o nome completo"
                    value="{{ old('guardian.name') }}" required>

                @error('guardian.name')
                    <div id="guardian_name_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="guardian_phone_number">Telefone</label>
                <input type="text" class="form-control @error ('guardian.phone_number') is-invalid @enderror"
                    id="guardian_phone_number" name="guardian[phone_number]"
                    aria-describedby="guardian_phone_number_feedback" placeholder="Insira o telefone"
                    value="{{ old('guardian.phone_number') }}" required>

                @error('guardian.phone_number')
                    <div id="guardian_phone_number_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <h3 class="mt-8">Endereço</h3>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="zip_code">Zip Code</label>
                <input type="text" class="form-control @error ('guardian.address.zip_code') is-invalid @enderror"
                    id="zip_code" name="guardian[address][zip_code]" aria-describedby="guardian_zip_code_feedback"
                    placeholder="Insira o zip code" value="{{ old('guardian.address.zip_code') }}" required>

                @error('guardian.address.zip_code')
                    <div id="guardian_zip_code_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="province">Província</label>
                <input type="text" class="form-control @error ('guardian.address.province') is-invalid @enderror"
                    id="province" name="guardian[address][province]" aria-describedby="guardian_province_feedback"
                    placeholder="Insira a província" value="{{ old('guardian.address.province') }}" required>

                @error('guardian.address.province')
                    <div id="guardian_province_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="city">Cidade</label>
                <input type="text" class="form-control @error ('guardian.address.city') is-invalid @enderror" id="city"
                    name="guardian[address][city]" aria-describedby="guardian_city_feedback"
                    placeholder="Insira a cidade" value="{{ old('guardian.address.city') }}" required>

                @error('guardian.address.city')
                    <div id="guardian_city_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="district">Bairro</label>
                <input type="text" class="form-control @error ('guardian.address.district') is-invalid @enderror"
                    id="district" name="guardian[address][district]" aria-describedby="guardian_district_feedback"
                    placeholder="Insira o bairro" value="{{ old('guardian.address.district') }}" required>

                @error('guardian.address.district')
                    <div id="guardian_district_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3 mt-3">
                <label for="number">Número</label>
                <input type="text" class="form-control @error ('guardian.address.number') is-invalid @enderror"
                    id="number" name="guardian[address][number]" aria-describedby="guardian_number_feedback"
                    placeholder="Insira o número" value="{{ old('guardian.number.district') }}" >

                @error('guardian.address.number')
                    <div id="guardian_number_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3 mt-3">
                <label for="complement">Complemento</label>
                <input type="text" class="form-control @error ('guardian.address.complement') is-invalid @enderror"
                    id="complement" name="guardian[address][complement]" aria-describedby="guardian_complement_feedback"
                    placeholder="Insira o complemento" value="{{ old('guardian.address.complement') }}" required>

                @error('guardian.address.complement')
                    <div id="guardian_complement_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

    </div>

    <div id="student_tab" class="mt-3 d-none hide" data-tab-num="2">
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
                    name="student[domain_language_id]" aria-describedby="student_language_feedback">
                    @foreach ($languages as $language)
                        <option value="{{ $language->id }}" @selected(old('student[domain_language_id]') == $language->id)>{{ $language->name }}</option>
                    @endforeach
                </select>

                @error('student.language')
                    <div id="student_language_feedback" class="invalid-feedback">
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
                <p>Enviar e-mail de boas vindas ao salvar?</p>
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

        <div class="row mt-8">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="expires_at">Expirar acessos em:</label>
                <input type="date" class="form-control @error ('student.expires_at') is-invalid @enderror" id="expires_at"
                    name="student[expires_at]" aria-describedby="student_expires_at_feedback"
                    placeholder="00/00/0000" value="{{ old('student.expires_at') }}">

                @error('student.expires_at')
                    <div id="student_expires_at_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-9 col-md-9 col-sm-12 pe-3">
                <label for="notes">Observação</label>
                <textarea type="text" class="form-control resize-none @error('student.notes') is-invalid @enderror" 
                    id="notes"name="student[notes]" placeholder="Digite aqui" rows="5"
                    aria-describedby="student_notes_feedback"
                ></textarea>

                @error('student.notes')
                    <div id="student_notes_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div id="classroom_tab" class="mt-3 d-none hide" data-tab-num="3">
        <h1>Turmas</h1>
        <div class="row mt-8 align-items-center">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="classroom">{{ __('Turmas') }}</label>
                <select class="form-select @error ('student.classroom') is-invalid @enderror" id="classroom"
                    aria-describedby="student_classroom_feedback">
                    <option value="" selected>Selecione...</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">
                            {{ $classroom->formatted_name }}
                        </option>
                    @endforeach
                </select>

                @error('student.classroom')
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

    <div id="result_tab" class="mt-3 d-none hide mt-3" data-tab-num="4">
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
