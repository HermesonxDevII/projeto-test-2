@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Nova Avaliação
@endsection

@section('content')
    <div class="row align-items-center mb-4" style="width: 100%;" >
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">🗓️ {{ $evaluation->date }} -
                {{ $evaluation->classroom->name }}
            </h1>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('evaluations.edit', [$classroom->id, $evaluation->id]) }}">
                <button class="btn bg-danger btn-shadow text-white m-1 finish" style="width: 136px; height: 40px;">
                    Editar
                </button>
            </a>
            <a href="{{ route('classrooms.show', $classroom) }}">
                <button class="btn bg-primary btn-shadow text-white m-1 finish" style="width: 136px; height: 40px;">
                    Voltar
                </button>
            </a>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <h5>{{ $evaluation->title }}</h5>
                <span class="content">Tarefa: {{ $evaluation->content }}</span>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="table-responsive-md">
                    <table class="table table-curved default-datatable">
                        <thead>
                            <tr>
                                <th>Alunos</th>
                                @foreach ($evaluation->evaluationModel->parameters as $parameter)
                                    <th>{{ $parameter->title }}</th>
                                @endforeach
                                <th>Comentários</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentEvaluations as $studentEvaluation)
                                <tr data-id-student="{{ $studentEvaluation->student->id }}">
                                    <td class="align-middle">{{ $studentEvaluation->student->full_name }}</td>
                                    @foreach ($evaluation->evaluationModel->parameters as $parameter)
                                        <td class="align-middle">
                                            <div class="col-lg-12 col-md-12 col-sm-12 pe-3">
                                                @php
                                                    $found = false;
                                                @endphp

                                                @foreach ($parameter->values as $value)
                                                    @if (isset($existingEvaluations[$studentEvaluation->student->id][$parameter->id]) &&
                                                            $existingEvaluations[$studentEvaluation->student->id][$parameter->id] == $value->id)
                                                        <span class="option">{{ $value->title }}</span>
                                                        @php
                                                            $found = true;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if (!$found)
                                                    <span class="option">—</span>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="align-middle text-center">
                                        <x-btn-action
                                            onclick="commentModal({{ $studentEvaluation->student->id }}, '{{ $studentEvaluation->student->full_name }}')"
                                            icon="message-square" :hasComment="!empty($existingComments[$studentEvaluation->student->id])"
                                            action="javascript: void(0);" />
                                        <input type="hidden" name="comments[{{ $studentEvaluation->student->id }}]"
                                            value="{{ old('comments.' . $studentEvaluation->student->id, $existingComments[$studentEvaluation->student->id] ?? '') }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="comment-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h3 id="comment-title"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <textarea class="form-control" name="comment" cols="30" rows="10" placeholder="Digite Aqui..."
                        style="height: 100px"></textarea @disabled(true)>
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                            <button type="button" class="btn bg-secondary btn-shadow text-white" style="padding: 10px 30px;"
                                data-bs-dismiss="modal">
                                <span>Cancelar</span>
                            </button>
                            <button id="comment-modal-confirm" type="button" class="btn bg-primary btn-shadow text-white"
                                style="padding: 10px 40px;">
                                <span>Incluir</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('extra-scripts')
    <script>
        const evaluationDate = $('input[name="date"]');

        let evaluationDateFp = evaluationDate.flatpickr({
            dateFormat: "d/m/Y",
            allowInput: true,
            locale: {
                weekdays: {
                    shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira',
                        'Quinta-feira', 'Sexta-feira', 'Sábado'
                    ],
                },
                months: {
                    shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                        'Out', 'Nov', 'Dez'
                    ],
                    longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                        'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                    ],
                },
                rangeSeparator: ' até ',
                weekAbbreviation: 'Sem',
            },
        });

        var currentStudentId = null;

        function commentModal(student_id, student_name) {
            if (student_id) {
                currentStudentId = student_id;
                $('#comment-title').text(`Comentários: ${student_name}`);
                var existingComment = $('tr[data-id-student="' + currentStudentId + '"] input[name="comments[' +
                    currentStudentId + ']"]').val();
                if (existingComment == '' || existingComment == null) {
                    existingComment = 'Sem comentários...';
                }
                $('#comment-modal textarea[name="comment"]').val(existingComment).prop('disabled', true);
                $('#comment-modal').modal('show');
            }
        }


        $('#comment-modal-confirm').on('click', function() {
            var comment = $('#comment-modal textarea[name="comment"]').val();
            if (currentStudentId) {
                $('tr[data-id-student="' + currentStudentId + '"] input[name="comments[' + currentStudentId + ']"]')
                    .val(comment);

                var button = $('tr[data-id-student="' + currentStudentId + '"] x-btn-action');
                if (comment.trim() !== '') {
                    $('tr[data-id-student="' + currentStudentId + '"] .btn-action').addClass('btn-comment');
                } else {
                    $('tr[data-id-student="' + currentStudentId + '"] .btn-action').removeClass('btn-comment');
                }

                $('#comment-modal').modal('hide');
            }
        });
    </script>
@endsection

@section('extra-styles')
    <style>
                .option {
                    font-weight: 500 !important;
                }

                .content {
                    color: #767F82;
                    font-size: 14px;
                    font-weight: 600;
                }

                .btn-comment {
                    background-color: #329fba !important;
                }
            </style>
@endsection
