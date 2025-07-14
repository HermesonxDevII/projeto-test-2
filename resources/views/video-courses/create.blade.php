@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Adicionar Turma
@endsection

@section('content')
    @if (!Session::has('success'))
        <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
            <div class="col">
                <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Adicionar Curso</h1>
            </div>
        </div>

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

        @include('video-courses.forms.create')
        
    @else
        <div class="card mt-4 p-10">
            <div class="text-center">
                <img src="{{ asset('images/icons/success.svg') }}" alt="success">
                <h2 class="my-6">Turma cadastrada com sucesso!</h2>
            </div>

            <div class="p-8 align-itens-center" style="border: 1px solid #f4f4f5; border-radius: 8px">
                <div class="row">

                    @if (Session::get('courses') == null)
                        <h3 class="text-center">Turma cadastrada sem aulas.</h3>
                    @else
                        @foreach (Session::get('courses') as $course)
                            <div class="col-12 mt-3 col-md-2">
                                <span class="d-block">Nome:</span>
                                <span class="subtitle-info">{{ $course->formattedName }}</span>
                            </div>
                            <div class="col-12 mt-3 col-md-2">
                                <span class="d-block">Dias:</span>
                                <span class="subtitle-info">{{ $course->weekdays }}</span>
                            </div>
                            <div class="col-12 mt-3 col-md-2">
                                <span class="d-block">Horário:</span>
                                <span class="subtitle-info">{{ $course->start }}</span>
                            </div>
                            <div class="col-12 mt-3 col-md-4 pe-5">
                                <span class="d-block">Link da aula:</span>
                                <span class="subtitle-info">
                                    @if ($course->link != '')
                                        {{ $course->link }}
                                        <img class="copy-icon" src="{{ asset("images/icons/copy.svg") }}" alt="Copy Icon"/>
                                    @else
                                        <span>-</span>
                                    @endif
                                </span>
                            </div>
                            <div class="col-7 col-md-2 d-none d-md-flex justify-content-end align-items-center">
                                <a href="{{ route('classrooms.edit', Session::get('classroom_id')) }}" class="square-action-btn">
                                    <img src="{{ asset('images/icons/pen.svg') }}" alt="Edit Icon">
                                </a>
                            </div>
                        @endforeach
                        <hr class="classroom-divider"/>
                    @endif

                </div>
                <a href="{{ route('classrooms.show', Session::get('classroom_id')) }}"
                    class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center mx-auto mt-5"
                    style="width: 155px; height: 40px;">
                    Ver turma
                </a>
            </div>
            <div class="text-center pt-6">
                <a href="{{ route('classrooms.create') }}" style="color: #329FBA;">Cadastrar nova turma</a>
            </div>
        </div>
    @endif
@endsection

@section('extra-scripts')
    <!-- <script src="{{ asset('js/classrooms/classrooms.js') }}"></script> -->
    <script src="{{ asset('js/shared/image_preview.js') }}"></script>
    <script src="{{ asset('js/video-courses/create.js') }}"></script>
@endsection
