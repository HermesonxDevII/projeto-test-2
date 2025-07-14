@php
    $guardian = $data['guardian'];
    $address = $data['address'];
@endphp

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form action="{{ route('guardians.update', $guardian->id) }}" method="POST" id="guardian_form">
    @method('PUT')
    @csrf
    <div id="guardian_tab" class="mt-3">
        <h1>Responsável</h1>
        <input type="hidden" name="id" id="guardian_id" value="{{ $guardian->id }}">

        <div class="row mt-8">

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="guardian_name">Nome Completo</label>
                <input type="text" class="form-control @error ('name') is-invalid @enderror" id="guardian_name"
                    name="name" aria-describedby="guardian_name_feedback" placeholder="Insira o nome completo"
                    value="{{ $guardian->name }}" required>

                @error('name')
                    <div id="guardian_name_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="guardian_phone_number">Telefone</label>
                <input type="text" class="form-control @error ('phone_number') is-invalid @enderror"
                    id="guardian_phone_number" name="phone_number"
                    aria-describedby="guardian_phone_number_feedback" placeholder="Insira o telefone"
                    value="{{ $guardian->phone_number }}" required>

                @error('phone_number')
                    <div id="guardian_phone_number_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

        <h3 class="mt-8">Endereço</h3>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="zip_code">Zip Code</label>
                <input type="text" class="form-control @error ('address.zip_code') is-invalid @enderror"
                    id="zip_code" name="address[zip_code]" aria-describedby="guardian_zip_code_feedback"
                    placeholder="Insira o zip code" value="{{ $address->zip_code }}" required>

                @error('address.zip_code')
                    <div id="guardian_zip_code_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="province">Província</label>
                <input type="text" class="form-control @error ('address.province') is-invalid @enderror"
                    id="province" name="address[province]" aria-describedby="guardian_province_feedback"
                    placeholder="Insira a província" value="{{ $address->province }}" required>

                @error('address.province')
                    <div id="guardian_province_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="city">Cidade</label>
                <input type="text" class="form-control @error ('address.city') is-invalid @enderror" id="city"
                    name="address[city]" aria-describedby="guardian_city_feedback"
                    placeholder="Insira a cidade" value="{{ $address->city }}" required>

                @error('address.city')
                    <div id="guardian_city_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="district">Bairro</label>
                <input type="text" class="form-control @error ('address.district') is-invalid @enderror"
                    id="district" name="address[district]" aria-describedby="guardian_district_feedback"
                    placeholder="Insira o bairro" value="{{ $address->district }}" required>

                @error('address.district')
                    <div id="guardian_district_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3 mt-3">
                <label for="number">Número</label>
                <input type="text" class="form-control @error ('address.number') is-invalid @enderror"
                    id="number" name="address[number]" aria-describedby="guardian_number_feedback"
                    placeholder="Insira o número" value="{{ $address->number }}" >

                @error('address.number')
                    <div id="guardian_number_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 pe-3 mt-3">
                <label for="complement">Complemento</label>
                <input type="text" class="form-control @error ('address.complement') is-invalid @enderror"
                    id="complement" name="address[complement]" aria-describedby="guardian_complement_feedback"
                    placeholder="Insira o complemento" value="{{ $address->complement }}" required>

                @error('address.complement')
                    <div id="guardian_complement_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <h3 class="mt-8">Login</h3>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
                <label for="guardian_email">E-Mail</label>
                <input type="text" class="form-control @error ('email') is-invalid @enderror"
                    id="guardian_email" name="email" aria-describedby="guardian_email_feedback"
                    placeholder="Insira o E-mail" value="{{ $guardian->email }}" required>

                @error('email')
                    <div id="guardian_email_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
    </div>
</form>
