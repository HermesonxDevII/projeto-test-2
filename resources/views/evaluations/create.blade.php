@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Nova Avaliação
@endsection

@section('content')
    <form action="{{ route('evaluations.store', $classroom) }}" method="POST" id="user_form" enctype="multipart/form-data">
        @csrf
        <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
            <div class="col d-flex justify-content-between">
                <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Nova Avaliação</h1>
                <button class="btn bg-primary btn-shadow text-white m-1 finish" type="submit"
                    style="width: 136px; height: 40px;">
                    Salvar
                </button>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="table-container p-0">
                        @include('evaluations.forms.create')
                    </div>
                </div>
            </div>
        </div>
    </form>

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
                        style="height: 100px"></textarea>
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
                var existingComment = $('tr[data-id-student="' + currentStudentId + '"] input[name="comments[' + currentStudentId + ']"]').val();
                $('#comment-modal textarea[name="comment"]').val(existingComment);
                $('#comment-modal').modal('show');
            }
        }

        $('#comment-modal-confirm').on('click', function() {
            var comment = $('#comment-modal textarea[name="comment"]').val();
            if (currentStudentId) {
                // Set the comment in the hidden input
                $('tr[data-id-student="' + currentStudentId + '"] input[name="comments[' + currentStudentId + ']"]').val(comment);

                // Change button color if there is a comment
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
        option {
            font-weight: 400 !important;
        }

        .btn-comment {
            background-color: #329fba !important;
        }
    </style>
@endsection
