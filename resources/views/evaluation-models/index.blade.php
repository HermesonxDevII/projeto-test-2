@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Modelos de avaliação
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Modelos de avaliações</h1>
        </div>

        <div class="col" style="text-align: end;">
            <a href="{{ route('evaluationModels.create') }}">
                <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                    <span class="text-white">Adicionar Modelo</span>
                </button>
            </a>
        </div>
    </div>

    <div class="table-filters" style="display: flex; justify-content: end">
        <div style="text-align: end; display: flex; ; margin-bottom: 30px">
            <div class="searchbox-table d-flex" style="width: 253px; height: 40px;">
                <input type="text" class="form-control m-auto" id="search_datatable" placeholder="Faça uma busca..."
                    style="height: 20px">
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
                    <div class="p-5">
                        @include('evaluation-models.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_evaluation_model_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="evaluation_model_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_evaluation_model_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_evaluation_model" type="button" onclick="deleteEvaluationModelConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
        function modalDeleteEvaluationModel(evaluationModel_id) {
            if (isValidVariable(evaluationModel_id)) {
                let evaluationModel_title = $(`table tbody tr[data-id-evaluation-model="${evaluationModel_id}"]`).find('.title').text();
                $('#delete_evaluation_model_modal_item').text(`a turma ${evaluationModel_title}?`);
                $('#evaluation_model_to_delete').val(evaluationModel_id);
                $('#delete_evaluation_model_modal').modal('show');
            }
        }

        function deleteEvaluationModelConfirmed() {
            let evaluationModel_id = $('#evaluation_model_to_delete').val();

            if (isValidVariable(evaluationModel_id)) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/evaluationModels/${evaluationModel_id}`,
                    type: 'DELETE',
                    success: function(response) {
                        $(`table tbody tr[data-id-evaluation_model="${evaluationModel_id}"]`).remove();
                        $('#delete_evaluation_model_modal').modal('hide');

                        notify(response.msg, response.icon);

                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        let data = error.responseJSON;
                        notify(data.msg, data.icon);
                        closeAllModals();
                    }
                });
                $('#evaluationModel_to_delete').val('');
            }
        }

        $('document').ready(function() {});
    </script>
@endsection
