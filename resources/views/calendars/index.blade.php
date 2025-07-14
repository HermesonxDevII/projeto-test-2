@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Calendários
@endsection

@section('content')
    @canany(['admin', 'teacher'])
        <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
            <div class="col">
                <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Calendários</h1>
            </div>

            @can('admin')
                <div class="col" style="text-align: end;">
                    <a href="{{ route('calendars.create') }}">
                        <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                            <span class="text-white">Adicionar Calendário</span>
                        </button>
                    </a>
                </div>
            @endcan
        </div>
    @endcanany

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        @include('calendars.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_calendar_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <div class="text-center">
                    <input type="hidden" id="calendar_to_delete">
                    <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                    <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                    <p id="delete_calendar_modal_item"></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                    <span>Cancelar</span>
                </button>
                <a id="delete_calendar" type="button"
                    class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                    <span>EXCLUIR</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/calendars/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection
