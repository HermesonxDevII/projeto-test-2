<form action="{{ route('modules.store') }}" method="POST" id="module_form">
    @csrf
    <div class="mt-3 modules">
        <h1>Adicionar Módulo</h1>

        <input type="hidden" name="classroom_id" id="classroom_id" value="{{ $classroom == null ? '' : $classroom->id }}">

        <div class="row mt-8 align-items-end">
            <div class="col-lg-8 col-md-8 col-sm-12 pe-3">
                <label for="module_name">Nome</label>
                <input type="text" class="form-control @error ('name') is-invalid @enderror"
                    id="module_name" aria-describedby="module_name_feedback"
                    value="{{ old('name') }}"
                    placeholder="Insira o nome do módulo..."
                    required>
                @error('name')
                    <div id="module_name_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-4 d-flex justify-content-end">
                <a class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center" onclick="addModule()"
                    style="width: 155px; height: 49px;">
                    Adicionar novo
                </a>
            </div>
        </div>
        <hr class="hr-divider">

        <div class="w-100 d-flex justify-content-end mt-5">
        </div>
    </div>
</form>