@extends('layouts.blank')

@section('extra-styles')
    <style>
        body {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endsection

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active text-center" id="nav-home" role="tabpanel"
                        aria-labelledby="nav-home-tab">

                        <div class="logo">
                            <img src="{{ asset('images/brand-02.svg') }}" alt="Melis Logo">
                        </div>

                        <h1 style="margin-bottom: 53px" class="title">Selecione o perfil de acesso a plataforma:</h1>

                        <div class="row justify-content-center students">
                            @foreach ($students as $student)
                                <div class="col-lg-2 col-md-5 col-sm-5 row text-center justify-content-center
                                    student pb-3 {{ $student->is_expired ? 'opacity-50' : '' }}"
                                    id="student-{{ $student->id }}"
                                    @if (!$student->is_expired) onclick="selectStudent({{ $student->id }})" @endif>
                                    @if ($student->avatar_id != 0)
                                        <img class="student-avatar"
                                            src="{{ asset('images/avatars/avatar' . $student->avatar_id . '.svg') }}"
                                            alt="">
                                    @else
                                        <img class="student-avatar" src="{{ asset('storage/default.png') }}" alt="">
                                    @endif
                                    <span class="pt-3 student-name">
                                        <b>{{ $student->full_name }}</b>
                                    </span>
                                    <span>Aluno(a)</span>
                                    @if ($student->is_expired)
                                        <span class="text-danger">
                                            Expirado em: {{ $student->expires_at_formatted }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/students/choose_student.js') }}?version={{ getAppVersion() }}"></script>
@endsection

@section('footer')
    <footer class="choose-student-footer">
        Caso tenha dificuldades para acessar a plataforma entre em contato no <br> email: suporte@meliseducation.com
    </footer>
@endsection

@section('extra-scripts')
    <script>
        Pusher.logToConsole = false;

        var pusher = new Pusher('e528eab965ecb3bf4599', {
            cluster: 'sa1'
        });
    </script>
@endsection
