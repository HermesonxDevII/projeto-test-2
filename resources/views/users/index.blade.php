@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Usuários
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Usuários</h1>
        </div>

        <div class="col d-flex justify-content-end">
            <div class="searchbox-table d-flex me-4 table-filters" style="width: 253px; height: 40px;">
                <input type="text" class="form-control m-auto" id="search_datatable" placeholder="Faça uma busca..." style="height: 20px">
                {{-- <button type="submit" class="btn bg-primary btn-shadow">
                    <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
                </button> --}}
                <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                    <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon">
                </button>
            </div>

            <div class="">
                <a href="{{ route('users.create') }}">
                    <button class="btn bg-primary btn-shadow" style="width: 168px; height: 40px; border-radius: 10px">
                        <span class="text-white">Adicionar Usuário</span>
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        @include('users.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="user_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_user_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_user" type="button" onclick="deleteUserComfirmed();"
                        class="btn bg-danger btn-shadow btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/users/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection
