@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Pré-inscrições
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px;
                align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Pré-inscrições</h1>
        </div>

        <div class="col" style="text-align: end;">
            <button id="external-link" data-link="{{ route('preRegistration.form',['courses' => 'courses']) }}" class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                <span class="text-white">Copiar Link</span>
            </button>
        </div>
    </div>

    <div class="table-filters" style="display: flex; justify-content: end">

        <div style="text-align: end; display: flex; ; margin-bottom: 30px">
            <div class="searchbox-table d-flex" style="width: 253px; height: 40px;">
                <input type="text" class="form-control m-auto" id="search_datatable" placeholder="Faça uma busca..." style="height: 20px">
                <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                    <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        @include('pre-registration.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_preRegistration_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir ?</h3>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <form action="{{ route('preRegistration.destroy') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input name="id" type="hidden" id="preRegistration_to_delete">
                        <button type="submit"
                            class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                            <span>EXCLUIR</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
         $(document).ready(function() {
            $('#external-link').on('click', function() {
                var link = $(this).data('link');

                var input = $('<input>');

                $('body').append(input);

                input.val(link).select();

                document.execCommand('copy');

                input.remove();

                notify('Link copiado com sucesso!');
            });
        });

        function modalDeletePreRegistration(preRegistration_id) {
            $('#preRegistration_to_delete').val(preRegistration_id);
            $('#delete_preRegistration_modal').modal('show');
        }
    </script>
@endsection
