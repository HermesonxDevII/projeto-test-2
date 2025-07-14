@extends('layouts.app')

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">
                {{ $data['classroom']->formatted_name }}
            </h1>
        </div>

        <div class="card mt-5">
            <div class="card-body pt-10 pb-9">
                <div class="container-fluid p-0">
                    <h1>Editar aula</h1>
                    @include('courses.recorded.forms.edit')
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end mt-5">
            <button class="btn bg-secondary btn-shadow text-white m-1 cancel" style="width: 136px; height: 40px;"
                onclick="window.location = '{{ url()->previous() }}'" >
                Cancelar
            </button>
            <button class="btn bg-primary btn-shadow text-white m-1 submit" style="width: 136px; height: 40px;">
                Salvar
            </button>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('vendor/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/courses/recorded/create.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/courses/recorded/edit.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/courses/shared/common.js') }}?version={{ getAppVersion() }}"></script>
@endsection
