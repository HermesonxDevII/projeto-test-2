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

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">

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

                        @include('video-courses-modules.forms.create')
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="w-100 d-flex justify-content-end gap-6 mt-5 pe-10">
        <a href="{{ route('video-courses.show', $videoCourse->id) }}" class="btn bg-secondary btn-shadow text-white d-flex justify-content-center align-items-center" 
            style="width: 155px; height: 49px;">
            Cancelar
        </a>
        <button class="btn bg-primary btn-shadow text-white finish" type="submit" onclick="saveModules()"
            style="width: 155px; height: 49px;">
            Salvar
        </button>
    </div>

@endsection

@section('extra-scripts')
    <script src="{{ asset('js/video-courses-modules/form.js') }}"></script>
    <script src="{{ asset('js/shared/common.js') }}"></script>
@endsection