<form action="{{ route('modules.update', $module->id) }}" method="POST" id="module_edit_form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mt-3 modules">
        <h1>Editar Módulo</h1>

        <div class="row mt-8 align-items-end">
            <div class="col-lg-8 col-md-8 col-sm-12 pe-3">
                <label for="module_name">Nome</label>
                <input type="text" name="name" class="form-control @error ('name') is-invalid @enderror"
                    id="module_name" aria-describedby="module_name_feedback"
                    value="{{ $module->name }}"
                    placeholder="Insira o nome do módulo..."
                    required>
                @error('name')
                    <div id="module_name_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn bg-primary btn-shadow text-white m-1 mt-5 finish" type="submit"
                style="width: 155px; height: 49px;">
                Salvar
            </button>
        </div>
    </div>
</form>
