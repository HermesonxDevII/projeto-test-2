<template id="parameter_template">
    <div class="parameter mb-4 p-3" style="border: 1px solid #e0e0e0; border-radius: 8px;"
        data-parameter-index="__INDEX__">
        <div class="mb-3">
            <label class="form-label m-0">Nome do Parâmetro</label>
            <div class="d-flex align-items-center justify-content-between mb-3 gap-2">
                <input type="text" name="parameters[__INDEX__][title]" class="form-control parameter-title"
                    value="{{ old('parameters[__INDEX__][title]') }}" required
                    placeholder="Digite o Nome do Parâmetro...">
                <div class="checkboxes">
                    <input type="checkbox" name="parameters[__INDEX__][required]"
                        id="parameter_required___INDEX__" value="1">
                    <label class="form-check-label" for="parameter_required___INDEX__">
                        Parâmetro Obrigatório
                    </label>
                </div>
            </div>
        </div>
        <div style="padding-left: 20px;">
            <div class="values_section mb-3">
                <h4>Valores Possíveis</h4>
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
</template>

<template id="value_template">
    <div class="value mb-2 d-flex align-items-center">
        <input type="text" name="parameters[__INDEX__][values][__VALUE_INDEX__][title]"
            class="form-control value-title me-2"
            value="{{ old('parameters[__INDEX__][values][__VALUE_INDEX__][title]') }}" required
            placeholder="Digite o Valor...">
        <button type="button" class="btn btn-remove-value">
            <img src="{{ asset('images/icons/trash.svg') }}" alt="" />
        </button>
    </div>
</template>
