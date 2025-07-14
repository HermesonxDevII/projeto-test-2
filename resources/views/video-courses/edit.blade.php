@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Editar Curso
@endsection

@section('content')
<div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
    <div class="col">
        <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Editar Curso</h1>
    </div>
</div>

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
    @include('video-courses.forms.edit')
</div>

@endsection

@section('extra-scripts')
<script src="{{ asset('js/shared/image_preview.js') }}"></script>
<script src="{{ asset('js/classrooms/edit.js')}}"></script>
@endsection
