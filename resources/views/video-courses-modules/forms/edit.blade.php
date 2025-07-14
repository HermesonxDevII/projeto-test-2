<form action="{{ route('video-courses.modules.update', ['video_course' => $videoCourse->id, 'module' => $module->id]) }}" method="POST" id="module_edit_form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body pb-11">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">
                        <div class="mt-3 modules">
                            <h1>Editar Módulo</h1>

                            <div class="row mt-8 align-items-center">
                                <div class="col-md-6 col-sm-12 pe-10">
                                    <label for="module_name">Nome</label>
                                    <input type="text" name="name" class="form-control @error ('name') is-invalid @enderror"
                                        id="module_name" aria-describedby="module_name_feedback"
                                        value="{{ old('name', $module->name) }}"
                                        placeholder="Insira o nome do módulo..."
                                        required>
                                    @error('name')
                                        <div id="module_name_feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 pt-5">
                                    <!-- <input class="form-check-custom" type="checkbox" name="open" id="module_open" @checked(old('open', $module->open))>
                                    <label for="module_open">Exibir aberto</label> -->

                                    <div class="form-check form-switch d-flex align-items-center gap-3">
                                        <input class="form-check-input w-50px" type="checkbox" role="switch" name="open" id="module_open"  @checked(old('open', $module->open))>
                                        <label for="module_open">Exibir aberto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 d-flex justify-content-end gap-6 mt-5 pe-10">
        <a href="{{ route('video-courses.show', $videoCourse->id) }}" class="btn bg-secondary btn-shadow text-white d-flex justify-content-center align-items-center" 
            style="width: 155px; height: 49px;">
            Cancelar
        </a>
        <button class="btn bg-primary btn-shadow text-white finish" type="submit"
            style="width: 155px; height: 49px;">
            Salvar
        </button>
    </div>

</form>

<!-- <style>
    .form-check-custom {        
        height: 24px; 
        width: 24px; 
        border-radius:4px !important;
        background: transparent; 
    }
    .form-check-custom:checked {
        background: #329FBA !important;
    }
</style> -->
