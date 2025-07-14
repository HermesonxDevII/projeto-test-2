<div class="mb-4">
    <label for="evaluation_model_title" class="form-label">Nome do Modelo</label>
    <input type="text" name="title" id="evaluation_model_title" class="form-control"
        value="{{ old('title', $evaluationModel->title ?? '') }}" required placeholder="Digite o Nome do Modelo...">
    @error('title')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div id="parameters_section" class="mb-4">
    {{-- <div class="d-flex align-items-center justify-content-between"> --}}
    <h3 class="mb-3">Parâmetros de Avaliação</h3>
    {{-- <button type="button" id="add_parameter_button" class="btn btn-add-parameter mb-3">Adicionar Parâmetro</button>
    </div> --}}

    @if (isset($evaluationModel) && $evaluationModel->parameters->count() > 0)
        @foreach ($evaluationModel->parameters as $pIndex => $parameter)
            <div class="parameter mb-4 p-3" style="border: 1px solid #e0e0e0; border-radius: 8px;"
                data-parameter-index="{{ $pIndex }}">
                <div class="mb-3">
                    <label class="form-label m-0">Nome do Parâmetro</label>
                    <div class="d-flex align-items-center justify-content-between mb-3 gap-2">
                        <input type="text" name="parameters[{{ $pIndex }}][title]"
                            class="form-control parameter-title"
                            value="{{ old('parameters.' . $pIndex . '.title', $parameter->title) }}" required
                            placeholder="Digite o Nome do Parâmetro...">
                        <div class="checkboxes">
                            <input type="checkbox"
                                name="parameters[{{ $pIndex }}][required]"
                                id="parameter_required_{{ $pIndex }}"
                                {{ old('parameters.' . $pIndex . '.required', $parameter->required ?? false) ? 'checked' : '' }} value="1">
                            <label class="form-check-label" for="parameter_required_{{ $pIndex }}">
                                Parâmetro Obrigatório
                            </label>
                        </div>
                    </div>
                </div>
                <div style="padding-left: 20px;">
                    <div class="values_section mb-3">
                        <h4>Valores Possíveis</h4>
                        @foreach ($parameter->values as $vIndex => $value)
                            <div class="value mb-2 d-flex align-items-center">
                                <input type="text"
                                    name="parameters[{{ $pIndex }}][values][{{ $vIndex }}][title]"
                                    class="form-control value-title me-2"
                                    value="{{ old('parameters.' . $pIndex . '.values.' . $vIndex . '.title', $value->title) }}"
                                    required placeholder="Digite o Valor...">
                                <button type="button" class="btn btn-remove-value">
                                    <img src="{{ asset('images/icons/trash.svg') }}" alt="" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-add-value mb-2">Adicionar Valor</button>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-remove-parameter">
                        Remover Parâmetro
                    </button>
                </div>
            </div>
        @endforeach
    @endif
    <div class="d-flex align-items-center justify-content-between">
        <button type="button" id="add_parameter_button" class="btn btn-add-parameter">Adicionar Parâmetro</button>
    </div>
</div>


@include('evaluation-models.forms.templates')
