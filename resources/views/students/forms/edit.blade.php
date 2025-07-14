@php
    $student = $data['student'];
    $student_classrooms = $data['student_classrooms'];
    $classrooms = $data['all_classrooms'];
@endphp


@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Por favor, verifique os campos abaixo:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<form action="{{ route('students.update', $student->id) }}" method="POST" id="student_form">
    @method('PUT')
    @csrf
    <div id="student_tab" class="mt-3" data-tab-num="2">
        <div class="row align-items-center">
            <div class="col-6">
                <h1>Aluno</h1>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div class="form-check form-switch">
                    @php $status = $student->status == 1 ? true : false; @endphp
                    <input class="form-check-input" type="checkbox" role="switch" id="student_status" name="student[status]"
                        {{ $status ? 'checked' : 'unchecked'}}>
                    <label class="form-check-label align-middle text-center" for="student_status" id="label_student_status"
                        style="width: 90px;">
                        {{ $status ? 'Ativado' : 'Desativado'}}
                    </label>
                  </div>
            </div>

        </div>
        <div class="row mt-8">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="full_name">Nome Completo</label>
                <input type="text" class="form-control @error ('student.full_name') is-invalid @enderror" id="full_name"
                    name="student[full_name]" aria-describedby="student_full_name_feedback"
                    placeholder="Insira o nome completo" value="{{ $student->formatted_full_name }}" required>

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
                    value="{{ $student->email }}" required>

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

                    @foreach ($data['grades'] as $grade)
                        <option value="{{ $grade->id }}" @selected($student->grade_id == $grade->id)>
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
                    @foreach ($data['languages'] as $language)
                        <option value="{{ $language->id }}" @selected($student->domain_language_id == $language->id)>
                            {{ $language->name }}
                        </option>
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
                <input type="hidden" name="student[avatar_id]" value="{{ $student->avatar_id }}">

                @for ($i = 1; $i <= 6; $i++)
                    @if ($i == $student->avatar_id)
                        <img src="{{ asset('images/avatars/avatar' . $i . '.svg') }}"
                            data-id-avatar="{{ $i }}" class="avatar me-2 cursor-pointer"
                            style="border: 2px solid #229FBA; box-shadow: 0px 0px 5px #40404080;">
                    @else
                        <img src="{{ asset('images/avatars/avatar' . $i . '.svg') }}" data-id-avatar="{{ $i }}"
                            class="avatar me-2 cursor-pointer"
                            style="border: 2px solid transparent;">
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
                    placeholder="00/00/0000" value="{{ old('student.expires_at') ?? $student->expires_at ?? '' }}">

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
                >{{ old('student.notes') ?? $student->notes ?? '' }}</textarea>

                @error('student.notes')
                    <div id="student_notes_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div id="classroom_tab" class="mt-3 d-none" data-tab-num="3">
        <h1>Turmas</h1>
        <h5 class="mt-5 mb-4">Aluno(a) {{ $student->formatted_full_name }}</h5>
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="classroom">{{ __('Selecione as turmas') }}</label>
                <select class="form-select @error ('student.classroom') is-invalid @enderror" id="classroom"
                    aria-describedby="student_classroom_feedback">
                    <option value="" selected>Selecione...</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">
                            {{ $classroom->name }}
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
                <table class="table table-curved " id="student_classrooms">
                    <thead>
                        <tr>
                            <th>Turma</th>
                            <th>Qtd. Alunos</th>
                            <th>Aulas</th>
                            <th>Data de Início</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student_classrooms as $classroom)
                            <tr data-id-classroom="{{ $classroom->id }}" class="align-middle">
                                <td>{{ $classroom->name }}</td>
                                <td>{{ $classroom->students->count() }} Alunos</td>
                                <td>{{ $classroom->weekdays == '' ? '-' : $classroom->weekdays }}</td>
                                <td>{{ $classroom->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a class="btn-action text-white" onclick="removeClassroom('{{ $classroom->id }}');">
                                        <img src="/images/icons/trash.svg" alt="">
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="result_tab" class="mt-3 d-none mt-3" data-tab-num="4">
        <div>
            <div class="text-center">
                <img src="{{ asset('images/icons/success.svg') }}" alt="success">
                <h2 class="my-6">Aluno editado com sucesso!</h2>
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
        </div>
    </div>
</form>
