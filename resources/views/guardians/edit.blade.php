@extends('layouts.app')

@section('title')
    Editar Responsável
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Editar responsável</h1>
        </div>

        <div class="card mt-5">
            <div class="card-body">
                <div class="container-fluid p-0">
                    @include('guardians.forms.edit')
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end mt-5">
            <button class="btn bg-secondary btn-shadow text-white m-1" onclick="history.back();"
                style="width: 136px; height: 40px;">
                Voltar
            </button>
            <button class="btn bg-primary btn-shadow text-white m-1 next finish"
                style="width: 136px; height: 40px;">
                Salvar
            </button>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/guardians/forms/guardian_edit.js') }}?version={{ getAppVersion() }}"></script>  
    <script src="{{ asset('js/guardians/forms/guardian_shared.js') }}?version={{ getAppVersion() }}"></script>  
@endsection