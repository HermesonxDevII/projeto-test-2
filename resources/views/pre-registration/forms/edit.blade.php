@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    .row label {
        font-weight: bold;
    }

    .mt-17 {
        margin-top: 17px !important;
    }

    select {
        background: url("{{ asset('images/icons/arrow-down.svg') }}") no-repeat right 10px center !important;
        background-size: 18px !important;
    }

    .textarea:not(.table-filters select):focus {
        border: none !important;
    }
</style>

<div id="guardian_tab" class="mt-3">
    <h1>Responsável</h1>
    <input type="hidden" name="id" value="{{ $preRegistration->id }}">

    <div class="row mt-8">

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label >Email</label>
            <input type="email" class="form-control @error('guardian_email') is-invalid @enderror"
                name="guardian_email" aria-describedby="guardian_email_feedback" placeholder="Insira o email"
                value="{{ old('guardian_email', $preRegistration->guardian_email) }}" required>

            @error('guardian_email')
                <div id="guardian_email_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Nome Completo</label>
            <input type="text" class="form-control @error('guardian_name') is-invalid @enderror"
                name="guardian_name" aria-describedby="guardian_name_feedback" placeholder="Insira o nome completo"
                value="{{ old('guardian_name', $preRegistration->guardian_name) }}" required>

            @error('guardian_name')
                <div id="guardian_name_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Telefone</label>
            <input type="text" class="form-control @error('guardian_phone') is-invalid @enderror"
                name="guardian_phone" aria-describedby="guardian_phone_feedback"
                placeholder="Insira o telefone" value="{{ old('guardian_phone', $preRegistration->guardian_phone) }}" required>

            @error('guardian_phone')
                <div id="guardian_phone_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </div>

    <h1 style="margin-top: 30px;">Dados do Aluno</h1>

    <div class="row mt-8">

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Nome Completo</label>
            <input type="text" class="form-control @error('student_name') is-invalid @enderror"
                name="student_name" aria-describedby="student_name_feedback" placeholder="Insira o Nome"
                value="{{ old('student_name', $preRegistration->student_name) }}" required>

            @error('student_name')
                <div id="student_name_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Série Atual</label>
            <select id="student-class" class="form-control @error('student_class') is-invalid @enderror" name="student_class" required>
                <option value="">Selecione</option>
                <option value="Shougakko 1" {{ old('student_class', $preRegistration->student_class) == 'Shougakko 1' ? 'selected' : '' }}>Shougakko 1</option>
                <option value="Shougakko 2" {{ old('student_class', $preRegistration->student_class) == 'Shougakko 2' ? 'selected' : '' }}>Shougakko 2</option>
                <option value="Shougakko 3" {{ old('student_class', $preRegistration->student_class) == 'Shougakko 3' ? 'selected' : '' }}>Shougakko 3</option>
                <option value="Shougakko 4" {{ old('student_class', $preRegistration->student_class) == 'Shougakko 4' ? 'selected' : '' }}>Shougakko 4</option>
                <option value="Shougakko 5" {{ old('student_class', $preRegistration->student_class) == 'Shougakko 5' ? 'selected' : '' }}>Shougakko 5</option>
                <option value="Shougakko 6" {{ old('student_class', $preRegistration->student_class) == 'Shougakko 6' ? 'selected' : '' }}>Shougakko 6</option>
                <option value="Chugakko 1" {{ old('student_class', $preRegistration->student_class) == 'Chugakko 1' ? 'selected' : '' }}>Chugakko 1</option>
                <option value="Chugakko 2" {{ old('student_class', $preRegistration->student_class) == 'Chugakko 2' ? 'selected' : '' }}>Chugakko 2</option>
                <option value="Chugakko 3" {{ old('student_class', $preRegistration->student_class) == 'Chugakko 3' ? 'selected' : '' }}>Chugakko 3</option>
            </select>

            @error('student_class')
                <div id="student_class_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Idioma que domina</label>
            <select id="student-language" class="form-control @error('student_language') is-invalid @enderror" name="student_language" required>
                <option value="">Selecione</option>
                <option value="Português" {{ old('student_language', $preRegistration->student_language) == 'Português' ? 'selected' : '' }}>Português</option>
                <option value="Japonês" {{ old('student_language', $preRegistration->student_language) == 'Japonês' ? 'selected' : '' }}>Japonês</option>
                <option value="Espanhol" {{ old('student_language', $preRegistration->student_language) == 'Espanhol' ? 'selected' : '' }}>Espanhol</option>
                <option value="Inglês" {{ old('student_language', $preRegistration->student_language) == 'Inglês' ? 'selected' : '' }}>Inglês</option>
            </select>

            @error('student_language')
                <div id="student_language_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Plano de Estudos</label>
            <select class="form-control @error('study_plan') is-invalid @enderror" name="study_plan[]" id="study_plan" multiple="multiple" required>
                <option value="Kokugo" {{ in_array('Kokugo', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Kokugo (Língua Nacional do Japão)</option>
                <option value="Sansuu" {{ in_array('Sansuu', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Sansuu (Matemática nível Shougakko)</option>
                <option value="Suugaku" {{ in_array('Suugaku', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Suugaku (Matemática nível Chugakko)</option>
                <option value="Suugaku Revisão 1 e 2" {{ in_array('Suugaku Revisão 1 e 2', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Suugaku Revisão 1 e 2 (Preparação do vestibular)</option>
                <option value="Suugaku Chu 3" {{ in_array('Suugaku Chu 3', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Suugaku Chu 3 (Matemática conteúdo 3 série do Chugakko)</option>
                <option value="Shakai" {{ in_array('Shakai', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Shakai (Estudos Sociais)</option>
                <option value="Japanese" {{ in_array('Japanese', explode(', ', $preRegistration->study_plan)) ? 'selected' : '' }}>Aula de Japonês (Gramática, Conversação e Kanji)</option>
            </select>

            @error('study_plan')
                <div id="study_plan_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </div>

    <h3 class="mt-8">Endereço</h3>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label>Zip Code</label>
            <input type="text" class="form-control @error('zipcode') is-invalid @enderror"
                name="zipcode" aria-describedby="guardian_zip_code_feedback"
                placeholder="Insira o zip code" value="{{ old('zipcode', $preRegistration->zipcode)}}" required>

            @error('zip_code')
                <div id="guardian_zipcode_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label for="province">Província</label>
            <input type="text" class="form-control @error('province') is-invalid @enderror"
                id="province" name="province" aria-describedby="province_feedback"
                placeholder="Insira a província" value="{{ old('province', $preRegistration->province) }}" required>

            @error('province')
                <div id="guardian_province_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label for="city">Cidade</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                name="city" aria-describedby="city_feedback" placeholder="Insira a cidade"
                value="{{ old('city', $preRegistration->city) }}" required>

            @error('city')
                <div id="city_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3">
            <label for="district">Bairro</label>
            <input type="text" class="form-control @error('district') is-invalid @enderror"
                id="district" name="district" aria-describedby="district_feedback"
                placeholder="Insira o bairro" value="{{ old('district', $preRegistration->district) }}" required>

            @error('district')
                <div id="district_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3 mt-17">
            <label for="address">Número</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                name="address" aria-describedby="address_feedback" placeholder="Insira o número"
                value="{{ old('address', $preRegistration->address) }}">

            @error('address')
                <div id="number_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 pe-3 mt-17">
            <label for="complement">Complemento</label>
            <input type="text" class="form-control @error('complement') is-invalid @enderror"
                id="complement" name="complement" aria-describedby="complement_feedback"
                placeholder="Insira o complemento" value="{{ old('complement', $preRegistration->complement) }}" required>

            @error('complement')
                <div id="complement_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<script src="https://unpkg.com/imask"></script>

<script>
    const element = $('input[name="guardian_phone"]')[0];

    const maskOptions = {
        mask: '+00 (00) 00000-0000'
    };

    const mask = IMask(element, maskOptions);

    $(document).ready(function() {
        $('#study_plan').select2({
            placeholder: 'Selecione os planos de estudo',
            allowClear: true
        });
    });
</script>
