@extends('layouts.blank')

@section('content')
    <div class="container login-container h-100">
        <div class="row justify-content-evenly">
            <div class="col-md-8 login-col">
                <div class="login-title text-center">
                    <img src="{{ asset('images/brand-02.svg') }}" height="90" alt="Melis Logo">
                    <h1>Crie uma nova senha</h1>
                    <p>Insira uma nova senha e repita a mesma para atualização dos seus acessos</p>
                </div>
                <hr />

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}" >

                    <div class="row mb-3">
                        <label for="password" class="login-label">{{ __('Senha') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="login-label">{{ __('Confirmar Senha') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn bg-primary mt-3 text-white w-100 p-3">
                        {{ __('Redefinir') }}
                    </button>
                </form>
            </div>
            <div class="col-md-4 login-bg-col">

            </div>
        </div>
    </div>
@endsection
