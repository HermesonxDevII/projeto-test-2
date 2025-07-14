@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ __('video-course.title') }}
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">{{ __('video-course.title') }}</h1>
        </div>

        @can('admin')
            <div class="col" style="text-align: end;">
                <a href="{{ route('video-courses.create') }}">
                    <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                        <span class="text-white">Adicionar Curso</span>
                    </button>
                </a>
            </div>
        @endcan
    </div>

    @canany(['admin', 'teacher'])
        <div class="table-filters" style="display: flex; justify-content: end">
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

        <div class="card">
            <div class="card-body">
                <div class="container-fluid p-0">
                    <div class="justify-content-center">
                        <div class="p-5">
                            @include('video-courses.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('admin')
            <div class="modal fade" id="delete_video_course_modal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="text-center">
                                <input type="hidden" id="video_course_to_delete">
                                <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                                <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                                <p id="delete_video_course_modal_item"></p>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button"
                                data-bs-dismiss="modal">
                                <span>Cancelar</span>
                            </button>
                            <a id="delete_video_course" type="button" onclick="deleteVideoCourseConfirmed();"
                                class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                                <span>EXCLUIR</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    @endcanany

    @can('guardian')
        @if ($videoCourses != null && $videoCourses->count() > 0)
            <div class="responsive-grid">
                @foreach ($videoCourses as $videoCourse)
                    <a href="{{ route('video-courses.show', $videoCourse->id) }}" class="card-container">
                        <div class="card">
                            @php
                                $thumbnail = $videoCourse->thumbnail ?? '';
                                $thumbnailUrl = !empty($thumbnail)
                                    ? url("storage/{$thumbnail}")
                                    : url('storage/thumbnails/default_thumbnail.png');
                            @endphp
                            <img class="card-img-top" src="{{ $thumbnailUrl }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ $videoCourse->title }}</h5>
                                <span class="text-gray-50">
                                    {{ __('video-course.lessons_attended', [
                                        'attended' => $videoCourse->viewed_classes_count,
                                        'total' => $videoCourse->classes_count,
                                    ]) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <h3 class="mb-0">Não há cursos recentes para exibir.</h3>
        @endif
    @endcan

@endsection

@section('extra-scripts')
    <script src="{{ asset('js/video-courses/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection

<style>
    .text-gray-50 {
        color: #8C9497;
    }

    .card-img-top {
        width: 100% !important;
        height: 15rem !important;
        border-radius: 10px !important;
    }

    .card .card-body {
        padding: 16px 24px !important;
    }

    .responsive-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }

    .card-container {
        display: flex;
        justify-content: center;
    }

    .card {
        border-radius: 10px !important;
        width: 100% !important;
    }

    .section-title {
        font-size: 24px;
        line-height: 32px;
        margin-bottom: 20px;
    }
</style>

<script>
    function prevVideoCourse() {
        console.log(document.querySelector('.video-course-list.owl-carousel .owl-prev'))
        document.querySelector('.video-course-list.owl-carousel .owl-prev').click();
    }

    function nextVideoCourse() {
        document.querySelector('.video-course-list.owl-carousel .owl-next').click();
    }
</script>
