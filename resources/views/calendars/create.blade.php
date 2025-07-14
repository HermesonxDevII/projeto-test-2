@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Adicionar Calendário
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Adicionar Calendário</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        @include('calendars.forms.create', ['calendar'])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 d-flex justify-content-end mt-5">
        <button class="btn bg-primary btn-shadow text-white m-1" id="finish_button" style="width: 136px; height: 40px;">
            Salvar
        </button>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/calendars/form.js') }}?version={{ getAppVersion() }}"></script>
@endsection
