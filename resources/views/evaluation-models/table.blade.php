<div class="table-responsive-md">
    <table class="table table-curved default-datatable">
        <thead>
            <tr>
                <th>Titulo</th>
                <th style='width: 150px;'>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluationModels as $evaluationModel)
                <tr data-id-evaluation-model="{{ $evaluationModel->id }}">
                    <td class="align-middle title">{{ $evaluationModel->title }}</td>

                    <td class="align-middle">
                        {{-- <x-btn-action :action="route('evaluationModels.show', $evaluationModel->id)" icon="eye" /> --}}
                        <x-btn-action :action="route('evaluationModels.edit', $evaluationModel->id)" icon="pen" />
                        <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                            onclick="modalDeleteEvaluationModel('{{ $evaluationModel->id }}');" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
