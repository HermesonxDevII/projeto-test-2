@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Meu Perfil
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Meu perfil</h1>
        </div>
    </div>

    @if ($user->can('guardian') && $user->studentsCount > 0)
        <div class="card mt-5">
            <div class="card-body pt-10 pb-9">
                <div class="container-fluid p-0">
                    <div class="row classroom-info">
                        @if ($people->avatar_id != 0)
                        <img class="profile-photo" src="{{ asset("images/avatars/avatar{$people->avatar_id}.svg") }}"
                            alt="Student Avatar">
                        @else
                            <img class="profile-photo" src="{{ asset('storage/default.png') }}" alt="Student Avatar">
                        @endif
                        <div class="col" style="display: grid; align-content: center;">
                            <h4 class="p-0">{{ $people->formatted_fullname }}</h4>
                            <p class="pb-0 mb-0">{{ $people->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-7">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="table-container p-0">

                        <form action="{{ route('students.update', $people->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div id="user_tab" class="mt-3">
                                <h1>{{ __('my-profile.personal_info') }}</h1>
                                <input type="hidden" name="id" id="user_id" value="{{ $people->id }}">

                                <div class="row mt-8">
                                    <div class="col-lg-4 col-md-3 col-sm-12 pe-3 pt-2">
                                        <label for="user_name">{{ __('my-profile.full_name') }}</label>
                                        <input type="text"
                                            class="form-control @error('student.full_name') is-invalid @enderror"
                                            id="user_name" name="student[full_name]"
                                            aria-describedby="student_name_feedback"
                                            value="{{ $people->formattedFullName }}" readonly required>

                                        @error('student.name')
                                            <div id="student_name_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3 pt-2">
                                        <label for="user_email">{{ __('my-profile.email') }}</label>
                                        <input type="email"
                                            class="form-control @error('student.email') is-invalid @enderror"
                                            id="user_email" name="student[email]" readonly
                                            aria-describedby="student_email_feedback" value="{{ $people->email }}">

                                        @error('student.email')
                                            <div id="student_email_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3 pt-2">
                                        <label for="user_nickname">{{ __('my-profile.nickname') }}</label>
                                        <input type="text"
                                            class="form-control @error('student.nickname') is-invalid @enderror"
                                            id="user_nickname" name="student[nickname]"
                                            aria-describedby="student_nickname_feedback" value="{{ $people->nickname }}">

                                        @error('student.nickname')
                                            <div id="student_nickname_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 pt-4 row" style="display: grid">
                                        <label class="col">Avatar</label>
                                        <input type="hidden" name="student[avatar_id]" value="{{ $people->avatar_id }}">

                                        <div class="col">
                                            @for ($i = 1; $i <= 6; $i++)
                                                @if ($i == $people->avatar_id)
                                                    <img src="{{ asset("images/avatars/avatar{$i}.svg") }}"
                                                        data-id-avatar="{{ $i }}"
                                                        class="avatar me-2 cursor-pointer"
                                                        style="border: 2px solid #229FBA; box-shadow: 0px 0px 5px #40404080;">
                                                @else
                                                    <img src="{{ asset("images/avatars/avatar{$i}.svg") }}"
                                                        data-id-avatar="{{ $i }}"
                                                        class="avatar me-2 cursor-pointer"
                                                        style="border: 2px solid transparent;">
                                                @endif
                                            @endfor
                                        </div>

                                    </div>
                                </div>

                                <div class="w-100 d-flex justify-content-end align-items-center mt-5">
                                    <a href="{{ url()->previous() }}" class="pe-8">
                                        {{ __('my-profile.cancel') }}
                                    </a>

                                    <button type="submit" class="btn bg-primary btn-shadow text-white m-1"
                                        style="width: 136px; height: 40px;">
                                        {{ __('my-profile.save') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @elseif($user->can('admin') || $user->studentsCount == 0)
        <div class="card mt-5 d-none">
            <div class="card-body pt-10 pb-9">
                <div class="container-fluid p-0">
                    <div class="row classroom-info">
                        <img class="profile-photo" src="{{ url("storage/{$people->profile_photo}") }}" alt="">
                        <div class="col" style="display: grid; align-content: center;">
                            <h4 class="p-0">{{ $people->formatted_name }}</h4>
                            <p class="pb-0 mb-0">{{ $people->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-7">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="table-container p-0">
                        <form action="{{ route('users.update', $people->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div id="user_tab" class="mt-3">
                                <h1>Suas Informações</h1>
                                <input type="hidden" name="id" id="user_id" value="{{ $people->id }}">

                                <div class="row mt-8">
                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                                        <label for="user_name">Nome Completo</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="user_name" name="name" aria-describedby="user_name_feedback"
                                            value="{{ $people_type == 'User' ? $people->formattedName : $people->formattedFullName }}"
                                            {{ loggedUser()->is_teacher && loggedUser()->id === (int) $user->id ? 'disabled' : '' }}
                                            required>

                                        @error('name')
                                            <div id="user_name_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                                        <label for="user_phone_number">Telefone</label>
                                        <input type="text"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="user_phone_number" name="phone_number"
                                            aria-describedby="user_phone_number_feedback"
                                            value="{{ $people->phone_number }}" required>
                                        @error('phone_number')
                                            <div id="user_phone_number_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-8">
                                    <div class="col-12">
                                        <label for="profile_photo">Foto</label><br />
                                        <button type="button" onclick="$('#profile_photo').click()"
                                            class="btn profile-picture-btn">Escolha um arquivo do computador</button>
                                        <input type="file"
                                            class="form-control d-none @error('profile_photo') is-invalid @enderror"
                                            id="profile_photo" name="profile_photo"
                                            aria-describedby="profile_photo_feedback">
                                        @error('profile_photo')
                                            <div id="profile_photo_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <img src="{{ url("storage/{$people->profile_photo}") }}"
                                            id="profile_photo_upload" alt="profile image" class="profile-photo ms-2"
                                            width="49px" height="49px" alt="User Profile Photo">

                                    </div>
                                </div>

                                <h3 class="mt-8">Login</h3>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                                        <label for="user_email">E-mail</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="user_email" name="email" aria-describedby="user_email_feedback"
                                            value="{{ $people->email }}"
                                            {{ loggedUser()->is_teacher && loggedUser()->id === (int) $user->id ? 'disabled' : '' }}
                                            required>
                                        @error('email')
                                            <div id="user_email_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                                        <label for="password">Senha</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" aria-describedby="user_password_feedback"
                                            placeholder="********">
                                        @error('password')
                                            <div id="user_password_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                                        <label for="password_confirmation">Repita a Senha</label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation"
                                            aria-describedby="user_password_confirmation_feedback" placeholder="********">
                                        @error('password_confirmation')
                                            <div id="user_password_confirmation_feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-100 d-flex justify-content-end align-items-center mt-5">
                                    <a href="{{ url()->previous() }}" class="pe-8">
                                        Cancelar
                                    </a>

                                    <button type="submit" class="btn bg-primary btn-shadow text-white m-1"
                                        style="width: 136px; height: 40px;">
                                        Salvar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('extra-scripts')
    <script src="{{ asset('js/users/forms/forms_shared.js') }}?version={{ getAppVersion() }}"></script>

    <script>
        $('.avatar').on('click', function() {
            let avatarId = $(this).data('id-avatar');

            $('input[name="student[avatar_id]"]').val(avatarId);
            $('.avatar').css({
                'border': '2px solid transparent',
                'box-shadow': 'none'
            });
            $(this).css({
                'border': '2px solid #329FBA',
                'box-shadow': '0px 0px 5px #40404080'
            });
        });
    </script>
@endsection
