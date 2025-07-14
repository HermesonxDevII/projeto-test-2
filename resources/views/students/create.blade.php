@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Adicionar Aluno
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
                        @include('students.forms.create')
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
    <script src="{{ asset('js/students/forms/student_create.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/students/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>
@endsection
