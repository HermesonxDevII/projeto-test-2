@extends('layouts.app')

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">
                Nome do Curso
            </h1>
        </div>

        <div class="card mt-5">
            <div class="card-body pt-10 pb-9">
                <div class="container-fluid p-0">
                    <h1>Editar aula</h1>
                    @include('video-courses-classes.forms.edit')
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end gap-5 mt-5">
            <button class="btn bg-secondary btn-shadow text-white m-1 cancel" style="width: 136px; height: 40px;"
                onclick="window.location = `{{ route('video-courses.show', $videoCourse->id) }}`" >
                Cancelar
            </button>
            <button class="btn bg-primary btn-shadow text-white m-1 submit" style="width: 136px; height: 40px;">
                Salvar
            </button>
        </div>
    </div>
    {{-- begin: yt modal --}}
    <div class="modal fade" id="yt_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h3>Selecionar um vídeo da galeria</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <input type="hidden" id="yt_video_selected" value=""/>
                    <div class="text-center">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-content-between">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <button type="button" id="yt_system_confirm"
                        class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>Inserir vídeo</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- end: logout modal --}}
@endsection

@section('extra-scripts')
    <script src="{{ asset('vendor/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/shared/common.js') }}"></script>
    <script src="{{ asset('js/video-courses-classes/create.js') }}"></script>
    <script src="{{ asset('js/video-courses-classes/edit.js') }}"></script>
    <script src="{{ asset('js/shared/image_preview.js') }}"></script>
@endsection
