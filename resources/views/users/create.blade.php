@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Adicionar Usuário
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Adicionar usuário</h1>
        </div>
    </div>

    <div class="card card-form-user mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="table-container p-0">
                    @include('users.forms.create')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    {{-- <script src="{{ asset('js/students/forms/student_edit.js') }}?version={{ getAppVersion() }}"></script> --}}
    <script src="{{ asset('js/users/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>
@endsection