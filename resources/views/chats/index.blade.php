@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Usuários
@endsection

@section('extra-styles')
<style>

    .card {
        margin: 0;
        border: none;
        box-shadow: none;
        height: calc(100vh - 180px); /* subtrai altura do header fixo */
    }

    .card-body {
        padding: 0 !important;
        height: 100%; /* ocupa toda a altura da tela */
    }

    .card-body iframe {
        height: 100%;
        width: 100%;
        display: block;
    }
</style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <iframe src="{{ $chatUrl }}"></iframe>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/users/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection
