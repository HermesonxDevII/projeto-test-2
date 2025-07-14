@extends('layouts.app')

@section('extra-styles')
    <link rel="stylesheet" href="{{ asset('css/site/dashboard.css') }}">
@endsection

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div style="width: 100%; align-items: center;" class="row mb-2">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">
                @canany(['admin', 'teacher'])
                    Olá, {{ Auth::user()->firstName }}!
                @endcanany
            </h1>
        </div>
    </div>

    @canany(['admin', 'teacher'])
        <div class="row">
            <div class="col-md-6 col-lg-3 g-3" onclick="window.location = '{{ route('students.index') }}'">
                <div class="dashboard-card">
                    <img src="{{ asset('images/icons/dashboard/users.svg') }}" alt="Students Icon">
                    <div class="d-grid ms-8">
                        <h3 class="text-white fw-normal m-0">Alunos</h3>
                        <h3 class="text-white font-weight-bold">
                            {{ $statistics['students'] }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 g-3" onclick="window.location = '{{ route('classrooms.index') }}'">
                <div class="dashboard-card">

                    <img src="{{ asset('images/icons/dashboard/file-text.svg') }}" alt="Classrooms Icon">
                    <div class="d-grid ms-8">
                        <h3 class="text-white fw-normal m-0">Turmas</h3>
                        <h3 class="text-white font-weight-bold">
                            {{ $statistics['classrooms'] }}
                        </h3>
                    </div>
                </div>
            </div>

            @can('admin')
                <div class="col-md-6 col-lg-3 g-3" onclick="window.location = '{{ route('video-courses.index') }}'">
                    <div class="dashboard-card">

                        <img src="{{ asset('images/icons/dashboard/play-circle.svg') }}" alt="Video Courses Icon">
                        <div class="d-grid ms-8">
                            <h3 class="text-white fw-normal m-0">{{ __('dashboard.courses') }}</h3>
                            <h3 class="text-white font-weight-bold">
                                {{ $statistics['videoCourses'] }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 g-3" onclick="window.location = '{{ route('users.index') }}'">
                    <div class="dashboard-card">
                        <img src="{{ asset('images/icons/dashboard/users-check.svg') }}" alt="Users Icon">
                        <div class="d-grid ms-8">
                            <h3 class="text-white fw-normal m-0">Usuários</h3>
                            <h3 class="text-white font-weight-bold">
                                {{ $statistics['users'] }}
                            </h3>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-md-6 col-lg-3 g-3" onclick="window.location = '{{ route('classrooms.index') }}'">
                <div class="dashboard-card">
                    <img src="{{ asset('images/icons/dashboard/play-circle.svg') }}" alt="Courses Icon">
                    <div class="d-grid ms-8">
                        <h3 class="text-white fw-normal m-0">Aulas</h3>
                        <h3 class="text-white font-weight-bold">
                            {{ $statistics['courses'] }}
                        </h3>
                    </div>
                </div>
            </div>

        </div>
    @endcanany

    @can('guardian')
        <div id="courses-notifications"></div>

        @notmobile
            <div class="container-fluid" style="margin-bottom: 27px">
                <img class="dashboard-banner" src="{{ asset('images/banner-dashboard.svg') }} " />
            </div>
        @endnotmobile

        @php $user = Auth::user(); @endphp

        <div style="width: 100%; align-items: center;"
            class="row mb-2 container-fluid @handheld
d-flex flex-column
@endhandheld">
            @if ($student != null && $student->grade != null && $student->grade->count() > 0)
                @if ($classrooms->count() != 0 || $videoCourses->count() != 0)
                    @handheld
                        <div class="col d-flex justify-content-between align-items-center">
                            <h1 style="font-size: 20px; line-height: 28px; font-weigth: 600;">
                                @can('guardian')
                                    @if ($user->studentsCount > 0 && isset($student))
                                        Olá, {{ $student->formattedFullName }}!
                                    @else
                                        Olá,
                                    @endif
                                @endcan
                            </h1>
                            <div class="navbar-item"
                                style="width: 56px; height: 56px; background-color: white; border-radius: 12px; text-align: center;"
                                onclick="showOnbClassroomModal()">
                                <button class="btn" style="height: 100%; width: 100%">
                                    <img src="{{ asset('images/icons/help-circle.svg') }}" alt="">
                                </button>
                            </div>
                        </div>
                    @endhandheld
                    @desktop
                        <h1 style="font-size: 24px; line-height: 32px; font-weigth: 700; margin-bottom: 20px">
                            @can('guardian')
                                @if ($user->studentsCount > 0 && isset($student))
                                    Olá, {{ $student->formattedFullName }}!
                                @else
                                    Olá,
                                @endif
                            @endcan
                        </h1>
                    @enddesktop
                @endif

                @if ($classrooms->count() == 0 && $videoCourses->count() == 0)
                    <h3 class="mb-0" style="font-weight: 400">
                        Você não está cadastrado em nenhuma turma, por favor entre em contato conosco.
                    </h3>
                @elseif ($classrooms->count() > 0)
                    <div class="responsive-grid">
                        @foreach ($classrooms as $classroom)
                            <a href="{{ route('classrooms.recorded-courses', $classroom->id) }}" class="card-container">
                                <div class="card">
                                    <img class="card-img-top" src="{{ url("storage/{$classroom->thumbnail}") }}"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $classroom->formattedName }}</h5>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                <h3 class="mb-3">Sua conta está desativada, por favor entre em contato conosco!</h3>
            @endif
        </div>

        @if ($videoCourses != null && $videoCourses->count() != 0)
            <div class="container-fluid mb-lg-20 mb-5">
                <h1 class="section-title">{{ __('dashboard.courses') }}</h1>
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
                                        {{ __('dashboard.lessons_attended', [
                                            'attended' => $videoCourse->viewed_classes_count,
                                            'total' => $videoCourse->classes_count,
                                        ]) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endcan

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


@can('guardian')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var studentId = {{ $student->id }};

            var showClassroomOnboarding = {{ $student->classroom_onboarding_preference }}
            var classroomsCount = {{ $student->classrooms()->count() }}

            if (showClassroomOnboarding === 1 && classroomsCount > 0) {
                var classroomModal = document.getElementById('classroom-onb-modal');
                var classroomModalInstance = new bootstrap.Modal(classroomModal);
                classroomModalInstance.show();
                $('#classroom-onb-checkbox').prop('checked', false);

                $('#classroom-onb-modal').on('hidden.bs.modal', function() {

                    var onboardingPreference = $('#classroom-onb-checkbox').is(':checked') ? 0 : 1;

                    $.ajax({
                        url: '/students/' + studentId + '/update-classroom-onboarding-preference',
                        method: 'GET',
                        data: {
                            preference: onboardingPreference
                        }
                    });
                });
            }

            var showCourseOnboarding = {{ $student->course_onboarding_preference }}
            var coursesCount = {{ $student->videoCourses()->count() ?? 0 }}

            if (showCourseOnboarding === 1 && coursesCount > 0) {
                var courseModal = document.getElementById('course-onb-modal');
                var courseModalInstance = new bootstrap.Modal(courseModal);
                courseModalInstance.show();
                $('#course-onb-checkbox').prop('checked', false);
                $('#course-onb-modal').on('hidden.bs.modal', function() {
                    // Verificando o estado do checkbox
                    var onboardingPreference = $('#course-onb-checkbox').is(':checked') ? 0 : 1;

                    // Fazendo a requisição Ajax
                    $.ajax({
                        url: '/students/' + studentId + '/update-course-onboarding-preference',
                        method: 'GET',
                        data: {
                            preference: onboardingPreference
                        }
                    });
                });
            }
        });
    </script>
@endcan
<script>
    function prevClassroom() {
        document.getElementsByClassName('owl-prev')[0].click();
    }

    function nextClassroom() {
        document.getElementsByClassName('owl-next')[0].click();
    }

    function prevVideoCourse() {
        console.log(document.querySelector('.video-course-list.owl-carousel .owl-prev'))
        document.querySelector('.video-course-list.owl-carousel .owl-prev').click();
    }

    function nextVideoCourse() {
        document.querySelector('.video-course-list.owl-carousel .owl-next').click();
    }
</script>
