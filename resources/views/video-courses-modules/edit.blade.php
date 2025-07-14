@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Adicionar Módulo
@endsection

@section('content')

    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">
                Nome do Curso
            </h1>
        </div>
    </div>

    @include('video-courses-modules.forms.edit')
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/video-courses-modules/form.js') }}"></script>
    <script src="{{ asset('js/shared/common.js') }}"></script>
@endsection
