@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <form action="{{ route('evaluationModels.store') }}" method="POST" id="evaluation_model_form">
                    @csrf
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-4">Adicionar Modelo de Avaliação</h1>

                        <button type="submit" class="btn btn-save">Salvar Modelo</button>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Por favor, verifique os erros abaixo:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('evaluation-models.forms.form')
                </form>
            </div>
        </div>
    </div>
@endsection
@section('extra-scripts')
    <script>
        $(document).ready(function() {
            let parameterIndex = 0;

            $('#add_parameter_button').on('click', function() {
                const parameterTemplate = $($('#parameter_template').html());
                parameterTemplate.html(parameterTemplate.html().replace(/__INDEX__/g, parameterIndex));

                parameterTemplate.attr('data-parameter-index', parameterIndex);

                // Atualize os IDs dos elementos para garantir unicidade
                parameterTemplate.find('[id]').each(function() {
                    const newId = $(this).attr('id').replace(/__INDEX__/g, parameterIndex);
                    $(this).attr('id', newId);
                });

                parameterTemplate.find('[for]').each(function() {
                    const newFor = $(this).attr('for').replace(/__INDEX__/g, parameterIndex);
                    $(this).attr('for', newFor);
                });

                // Adicione os event listeners necessários
                parameterTemplate.find('.btn-add-value').on('click', function() {
                    addValue($(this).closest('.parameter'));
                });

                parameterTemplate.find('.btn-remove-parameter').on('click', function() {
                    $(this).closest('.parameter').remove();
                });

                $('#add_parameter_button').closest('div').before(parameterTemplate);
                parameterIndex++;
            });

            function addValue(parameterElement) {
                let parameterIndex = parameterElement.attr('data-parameter-index');
                let valueIndex = parameterElement.find('.value').length;

                const valueTemplate = $($('#value_template').html());
                valueTemplate.html(valueTemplate.html()
                    .replace(/__INDEX__/g, parameterIndex)
                    .replace(/__VALUE_INDEX__/g, valueIndex));

                valueTemplate.find('.btn-remove-value').on('click', function() {
                    $(this).closest('.value').remove();
                });

                parameterElement.find('.values_section').append(valueTemplate);
            }
        });
    </script>
@endsection

@section('extra-styles')
    <style>
        .checkboxes {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .checkboxes input:not(.other) {
            width: 18px;
            height: 18px;
            margin-right: 11px;
            border-radius: 3px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            appearance: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFF;
            transition: background 0.2s ease-in-out;
        }

        .checkboxes label {
            display: flex;
            align-items: center;
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .checkboxes input:checked::before {
            content: '✔';
        }

        .checkboxes input:checked {
            background: var(--colors-brand-primary, #50B4D8);
            border: 0;
        }

        .btn-add-parameter,
        .btn-add-value,
        .btn-save {
            background-color: #329fba;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 8px 12px !important;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-add-parameter:hover,
        .btn-add-value:hover,
        .btn-save:hover {
            background-color: #287f98;
            color: #ffffff !important;
        }

        .btn-remove-parameter,
        .btn-remove-value {
            background-color: #dc1d54;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 6px 10px !important;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-remove-parameter:hover,
        .btn-remove-value:hover {
            background-color: #a6143d;
            color: #FFFFFF;
        }

        #parameters_section {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .parameter {
            background: #ffffff;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
        }

        .form-label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        h1,
        h3,
        h4 {
            color: #329fba;
        }

        h1 {
            font-size: 28px;
            line-height: 36px;
        }

        h3 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .invalid-feedback {
            color: #dc1d54;
            font-size: 13px;
        }
    </style>
@endsection
