@extends('layouts.app')

@section('title')
    Adicionar Responsável
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Adicionar responsável</h1>
        </div>

        <div class="card mt-5">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <x-guardians.forms.create />
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end mt-5">
            <button class="btn bg-primary text-white m-1 finish" style="width: 136px; height: 40px;">
                Salvar
            </button>
        </div>
    </div>
@endsection

@section('extra-scripts')
    {{-- <script src="{{ asset('js/guardians/forms/.js') }}?version={{ getAppVersion() }}"></script>   --}}
    <script src="{{ asset('js/guardians/forms/guardian_shared.js') }}?version={{ getAppVersion() }}"></script>  
@endsection