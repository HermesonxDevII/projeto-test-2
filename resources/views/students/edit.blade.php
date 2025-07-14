@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Editar Aluno
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Editar Aluno</h1>
        </div>
    </div>

    <div class="card" style="border-radius: 24px;">
        <div class="student-tabs">
            <div class="container-fluid p-0">
                <div class="row edit-student-tabs">
                    <div class="col col-md-6 student-tab">
                        <div data-id-tab="student_tab" class="edit-student-tab student-active-tab">
                            <i class="classroom-tab-number">1</i>
                            <span>Aluno</span>
                            <small>Dados pessoais e plano</small>
                        </div>
                    </div>
                    <div class="col-md-6 class-tab">
                        <div data-id-tab="classroom_tab" class="edit-student-tab">
                            <i class="classroom-tab-number">2</i>
                            <span>Turmas</span>
                            <small>Selecione as turmas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="table-container p-0">
                    @include('students.forms.edit')
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-end mt-5">
        <button class="btn bg-primary btn-shadow text-white m-1 finish" style="width: 136px; height: 40px;">
            Salvar
        </button>
    </div>

@endsection

@section('extra-scripts')
    <script src="{{ asset('js/students/forms/student_edit.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/students/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>
@endsection
