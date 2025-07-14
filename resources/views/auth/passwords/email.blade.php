@extends('layouts.blank')

@section('content')
    <div class="container login-container h-100">
        <div class="row justify-content-evenly">
            <div class="col-md-8 login-col">
                <div class="login-title text-center">
                    <img src="{{ asset('images/brand-02.svg') }}" height="90" alt="Melis Logo">
                    <h1>Recupere sua senha</h1>
                    <p>Insira seu email de cadastro para enviarmos sua senha</p>
                </div>
                <hr />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="email" class="login-label">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn bg-primary mt-3 text-white w-100 p-3">
                        {{ __('Redefinir senha') }}
                    </button>
                </form>
            </div>
            <div class="col-md-4 login-bg-col">

            </div>
        </div>
    </div>
@endsection
