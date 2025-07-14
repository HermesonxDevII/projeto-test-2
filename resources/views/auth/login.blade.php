@extends('layouts.blank')

@section('extra-styles')
    <style>
        .eye-icon-off,
        .eye-icon-on {
            left: 362px;
            position: relative;
            top: -36px;
        }

        .eye-icon-on {
            display: none;
        }

        .eye-icon-off:hover,
        .eye-icon-on:hover {
            transform: scale(1.1);
        }
    </style>
@endsection

@section('content')
    <div class="container login-container h-100">
        <div class="row justify-content-evenly">
            <div class="col-md-8 login-col">
                <div class="login-title text-center">
                    <img src="{{ asset('images/brand-02.svg') }}" height="90" alt="Melis Logo">
                    <h1>Faça o login</h1>
                    <p>E inicie sua jornada de estudos!</p>
                </div>
                <hr />
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->has('login_error'))
                        <div class="alert alert-danger mb-4" style="margin-bottom: 20px;">
                            <strong>{{ $errors->first('login_error') }}</strong>
                        </div>
                    @endif

                    <label for="email" class="login-label">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="password" class="login-label">{{ __('Senha') }}</label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    <img src="{{ asset('images/icons/eye-off.svg') }}"
                        class="eye-icon-off @error('password') d-none @enderror">
                    <img src="{{ asset('images/icons/seeing.svg') }}"
                        class="eye-icon-on @error('password') d-none @enderror">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div>
                                <input class="square-checkbox" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label remember-password-label"
                                    style="position: relative; top: -5px;" for="remember">
                                    {{ __('Lembrar senha') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Esqueci a senha') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn bg-primary text-white btn-login w-100 p-3">
                        {{ __('Entrar') }}
                    </button>
                </form>
            </div>
            <div class="col-md-4 login-bg-col">

            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
        const eyeOff = $('.eye-icon-off')
        const eyeOn = $('.eye-icon-on')
        const passwordInput = $('#password');

        eyeOff.on('click', function() {
            $(this).hide()
            eyeOn.show()
            passwordInput.attr('type', 'text')
        });

        eyeOn.on('click', function() {
            $(this).hide()
            eyeOff.show()
            passwordInput.attr('type', 'password')
        });

        passwordInput.on('input', function() {
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
            }

            eyeOff.removeClass('d-none');
            eyeOn.removeClass('d-none');
        });
    </script>
@endsection
