<div
    class="modal fade"
    id="createTransmissionModal"
    tabindex="-1"
    aria-labelledby="createTransmissionModal"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form
            action="{{ route('meetings.store') }}"
            method="POST"
            {{-- target="_blank" --}}
            class="modal-content custom-modal-content p-3"
        >
            @csrf()
            <div class="modal-header border-0">
                <h1
                    class="modal-title fs-2 custom-modal-title"
                    id="meuModalLabel"
                >Iniciar aula ao vivo</h1>

                <button
                    type="button"
                    class="btn-close custom-close-btn"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-3">
                        <label
                            for="tituloAula"
                            class="form-label custom-form-label"
                        >Título da aula</label>
                    </div>
                    <div class="col-md-9">
                        <input
                            type="text"
                            class="form-control custom-form-control"
                            name="name"
                            id="name"
                            placeholder="Nome da Aula"
                            required
                            value="{{ old('name') }}"
                        />
                    </div>
                </div>
                
                <div class="row align-items-start mb-3">
                    <div class="col-md-3">
                        <label
                            for="descricaoAula"
                            class="form-label custom-form-label pt-2"
                        >Descrição:</label>
                    </div>
                    <div class="col-md-9">
                        <textarea
                            class="form-control custom-form-control"
                            rows="4"
                            name="description"
                            id="description"
                            placeholder="Descrição da aula"
                            required
                        >{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-0 justify-content-end">
                <button
                    type="button"
                    class="btn btn-custom-cancel px-7 py-2 ps-5 pe-5"
                    data-bs-dismiss="modal"
                >Cancelar</button>

                <button
                    type="submit"
                    class="btn bg-primary px-7 py-2 ps-5 pe-5 text-white"
                >Iniciar aula ao vivo</button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-modal-content {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .custom-close-btn {
        background-color: #e9ecef;
        color: #A1A5B7;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: bold;
    }

    .custom-modal-title {
        font-weight: 600;
    }
    
    .custom-form-label {
        font-weight: 500;
        color: #495057;
    }

    .custom-form-control {
        background-color: #f8f9fa;
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
    }

    .custom-form-control:focus {
        background-color: #f8f9fa;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
    }
    
    .btn-custom-cancel {
        background-color: #e9ecef;
        color: #495057;
    }
</style>