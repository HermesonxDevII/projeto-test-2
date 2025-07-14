@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Editar Turma
@endsection

@section('content')
<div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
    <div class="col">
        <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Editar Turma</h1>
    </div>
</div>

<div class="card" style="border-radius: 24px;">
    <div class="student-tabs">
        <div class="container-fluid p-0">
            <div class="row edit-student-tabs">
                <div class="col col-md-6 student-tab">
                    <div data-id-tab="classroom_info_tab" class="edit-student-tab student-active-tab">
                        <i class="classroom-tab-number">1</i>
                        <span>Dados da Turma</span>
                        <small>Informações</small>
                    </div>
                </div>
                <div class="col-md-6 class-tab">
                    <div data-id-tab="schedule_tab" class="edit-student-tab edit-schedule-tab">
                        <i class="classroom-tab-number">2</i>
                        <span>Aulas ao vivo</span>
                        <small>Programe as aulas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-fluid p-0">
            <div class="table-container p-0">
                @include('classrooms.forms.edit')
            </div>
        </div>
    </div>
</div>
</div>


@endsection

@section('extra-scripts')
<script src="{{ asset('js/classrooms/classrooms.js')}}"></script>
<script src="{{ asset('js/classrooms/edit.js')}}"></script>
@endsection
