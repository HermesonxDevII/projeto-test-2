@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Turmas
@endsection

@section('content')
    @canany(['admin', 'teacher'])
        <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
            <div class="col">
                <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Turmas</h1>
            </div>

            @can('admin')
                <div class="col" style="text-align: end;">
                    <a href="{{ route('classrooms.create') }}">
                        <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                            <span class="text-white">Adicionar Turma</span>
                        </button>
                    </a>
                </div>
            @endcan
        </div>

        <div class="table-filters" style="display: flex; justify-content: end">
            {{-- <div style="width: 124px; height: 40px; margin-right: 15px;">
                <select class="form-select-sm" aria-label="select example" style="width: 100%; height: 100%; border: none;">
                    <option value="">Classroom</option>
                </select>
            </div> --}}

            <div style="text-align: end; display: flex; ; margin-bottom: 30px">
                <div class="searchbox-table d-flex" style="width: 253px; height: 40px;">
                    <input type="text" class="form-control m-auto" id="search_datatable" placeholder="Faça uma busca..."
                        style="height: 20px">
                    <button type="submit" class="btn bg-primary btn-shadow" style="width: 28px; height: 26px;">
                        <img src="{{ asset('images/icons/find.svg') }}" alt="Find Icon" />
                    </button>
                </div>
            </div>
        </div>
    @endcanany

    @can('guardian')
        <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
            <div class="col @handheld
d-flex justify-content-between
@endhandheld">
                <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">{{ __('classroom.title') }}</h1>
                @handheld
                    <div class="navbar-item"
                        style="width: 56px; height: 56px; background-color: white; border-radius: 12px; text-align: center;"
                        onclick="showOnbClassroomModal()">
                        <button class="btn" style="height: 100%; width: 100%">
                            <img src="{{ asset('images/icons/help-circle.svg') }}" alt="">
                        </button>
                    </div>
                @endhandheld
            </div>
        </div>

        <div id="courses-notifications"></div>
    @endcan

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="p-5">
                        @canany(['admin', 'teacher'])
                            @include('classrooms.table')
                        @endcanany
                        @can('guardian')
                            @if ($classrooms->count() == 0)
                                <h3 class="mb-0" style="font-weight: 400">
                                    Você não está cadastrado em nenhuma turma, por favor entre em contato conosco.
                                </h3>
                            @else
                                @include('classrooms.classrooms')
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_classroom_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="classroom_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_classroom_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                        data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_classroom" type="button" onclick="deleteClassroomConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/classrooms/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection
