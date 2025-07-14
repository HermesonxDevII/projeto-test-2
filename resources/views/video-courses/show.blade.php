@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $videoCourse->title }}
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <h1 class="p-0 m-0 classroom-title">
                {{ __('video-course.title') }}
            </h1>
            <input type="hidden" name="video_course_id" id="video_course_id" value="{{ $videoCourse->id }}">
        </div>

        @can('admin')
            <div class="col-sm-12 col-md-12 col-lg-6 classroom-action-row d-flex justify-content-end">
                <div>
                    <a href="{{ route('video-courses.students', $videoCourse->id) }}"
                        class="btn bg-danger btn-shadow py-3 px-10">
                        <img src="{{ asset('images/icons/users-white.svg') }}" alt="Users Icon" height="24px" width="24px" />
                        <span class="text-white align-middle ms-3">Alunos</span>
                    </a>
                </div>
            </div>
        @endcan
    </div>



    <div class="card mb-6 video_course_cover"
        @if($videoCourse->cover) style="background: linear-gradient(rgba(0,0,0,0.0), rgba(0,0,0,0.2)), url({{ asset("storage/{$videoCourse->cover}") }});"
        @else style="background:#825BE0" @endif
    >
        <div class="card-body px-10 pb-12 pt-17 d-flex align-items-end">
            <div class="row w-100">
                <div class="col-lg-6">
                    <h1 class="classroom-title text-white">{{ $videoCourse->title }}</h1>
                    @if ($videoCourse->description)
                        <p class="text-white">{{ $videoCourse->description }}</p>
                    @endif
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-8">
                            <ul class="list-unstyled text-white">
                                @can('admin')
                                    <li class="fw-bold">Total de alunos • {{ $videoCourse->students_count }}</li>
                                @endcan
                                <li class="fw-bold">{{ __('video-course.total_modules', ['total' => $videoCourse->modules_count]) }} • {{ __('video-course.total_lessons', ['total' => $videoCourse->classes_count]) }} • {{ $videoCourse->classes_duration_sum }}</li>
                            </ul>

                            @can('guardian')
                                <div class="d-flex align-items-center gap-4">
                                    <div class="progress w-100" style="height: 5px;">
                                        <div class="progress-bar bg-success-base" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="progress-percent">{{ $progress }}%</span>
                                </div>
                            @endcan
                        </div>

                        @can('guardian')
                            @if ($progress < 100)
                                <div class="col-md-6 col-sm-2 d-flex justify-content-sm-end justify-content-start flex-fill">
                                    <a href="{{ $nextClassLink }}" class="btn d-flex align-items-center bg-danger btn-shadow py-3 px-7 w-md-auto w-100 ms-md-0 ms-sm-10 mt-sm-0 mt-6">
                                        <span class="text-white align-middle">
                                            {{ $progress > 0 ? __('video-course.continue') : __('video-course.start') }}
                                        </span>
                                    </a>
                                </div>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('admin')
        <div class="d-flex justify-content-end gap-5 mb-6">
            <a href="{{ route('video-courses.modules.create', $videoCourse->id) }}" class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10">
                Adicionar Módulo
            </a>
            <a href="{{ route('video-courses.classes.create', $videoCourse->id) }}" class="btn bg-primary btn-shadow p-3 text-white ps-10 pe-10">
                Adicionar Aula
            </a>
        </div>
    @endcan

    @if ($modules->isNotEmpty())
        <div
            class="accordion video-courses-classes-accordion"
            @if ($modules->count() > 1) id="video_courses_modules_accordion" @endif
        >
            @foreach ($modules as $i => $module)
                <div class="accordion-item" data-id="{{ $module->id }}">
                    <h2 class="accordion-header" id="videoCoursesClasses-heading-{{ $i }}">
                        <button
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#videoCoursesClasses-collapse-{{ $i }}"
                            aria-expanded="{{ $module->open ? 'true' : 'false' }}"
                            aria-controls="videoCoursesClasses-collapse-{{ $i }}"
                            @class([
                                'accordion-button',
                                'collapsed' => !$module->open
                            ])
                        >
                            <div class="w-100 d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <span>{{ $module->name }}</span>
                                    @canany(['admin', 'teacher'])
                                        <span class="module-classes-count ms-2">
                                            {{ $module->classes_count > 1 ? "{$module->classes_count} aulas" : "{$module->classes_count} aula" }}
                                        </span>
                                    @endcanany
                                </div>
                                <div class="d-flex align-items-center gap-3 me-9">
                                    @can ('admin')
                                        <x-btn-action class="classes-btn" :action="route('video-courses.modules.edit', ['video_course' => $videoCourse->id, 'module' => $module->id])" icon="pen"/>
                                        <x-btn-action class="classes-btn" action="javascript: void(0);" icon="trash"
                                            onclick="deleteModuleModal({{ $module->id }});"
                                        />
                                    @endcan
                                    @can('guardian')
                                        <span class="module-classes-count">{{ "{$module->viewedClassesCount()}/{$module->classes_count}" }}</span>

                                        @if ($module->classes_count > 0 && $module->viewedClassesCount() === $module->classes_count)
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.2188 11.8281H8.78125V17.8284H11.2188V11.8281Z" fill="#FFCE47"/>
                                                <path d="M9.02094 11.8281H8.78125V17.8284H9.02094V11.8281Z" fill="#FFDA75"/>
                                                <path d="M8.78125 11.8281V14.3916C9.22472 14.5719 9.68858 14.6975 10.1625 14.7653C10.2989 14.7839 10.4241 14.8509 10.5152 14.9543C10.6062 15.0576 10.6569 15.1903 10.6581 15.328V17.8264H11.2188V11.8281H8.78125Z" fill="#F69652"/>
                                                <path d="M15.4033 12.0759H13.1445V10.4509H15.4033C16.1787 10.4499 16.9221 10.1413 17.4704 9.59304C18.0187 9.04473 18.3272 8.30137 18.3283 7.52594V5.98219C18.3283 5.87444 18.2855 5.77111 18.2093 5.69493C18.1331 5.61874 18.0298 5.57594 17.922 5.57594H15.1047V3.95094H17.922C18.4608 3.95094 18.9774 4.16494 19.3583 4.54588C19.7393 4.92681 19.9533 5.44347 19.9533 5.98219V7.52594C19.9517 8.73218 19.4718 9.88855 18.6188 10.7415C17.7659 11.5944 16.6095 12.0743 15.4033 12.0759Z" fill="#FFCE47"/>
                                                <path d="M19.2505 4.45062C19.8598 5.15547 19.7502 5.74453 19.7502 7.32281C19.7486 8.30688 19.4287 9.26404 18.8381 10.0512C18.2476 10.8384 17.4181 11.4133 16.4738 11.69C16.3896 11.7145 16.3006 11.7165 16.2154 11.6958C16.1303 11.675 16.0522 11.6323 15.9888 11.5718C15.9254 11.5113 15.879 11.4352 15.8544 11.3511C15.8297 11.267 15.8275 11.178 15.8481 11.0928C15.9053 10.8621 15.948 10.6281 15.9761 10.392C15.5983 10.4672 15.6003 10.4489 13.1445 10.4489V12.0739H15.4033C16.6097 12.0739 17.7667 11.5948 18.6199 10.742C19.4731 9.88911 19.9527 8.73232 19.9533 7.52594C19.9533 6.03297 20.1138 5.20016 19.2505 4.45062Z" fill="#F69652"/>
                                                <path d="M6.85359 12.0759H4.59688C3.39064 12.0743 2.23426 11.5944 1.38132 10.7415C0.528378 9.88855 0.0484873 8.73218 0.046875 7.52594V5.98219C0.046875 5.44347 0.260881 4.92681 0.641814 4.54588C1.02275 4.16494 1.5394 3.95094 2.07812 3.95094H4.89547V5.57594H2.07812C1.97038 5.57594 1.86705 5.61874 1.79086 5.69493C1.71468 5.77111 1.67188 5.87444 1.67188 5.98219V7.52594C1.67295 8.30137 1.98146 9.04473 2.52977 9.59304C3.07809 10.1413 3.82145 10.4499 4.59688 10.4509H6.85359V12.0759Z" fill="#FFCE47"/>
                                                <path d="M4.69272 3.95094V5.37281H4.07115L4.08537 3.95094L3.90662 4.92188C3.88464 5.04706 3.81924 5.16049 3.7219 5.24222C3.62457 5.32395 3.50153 5.36875 3.37444 5.36875H1.87537C1.76763 5.36875 1.6643 5.41155 1.58811 5.48774C1.51192 5.56392 1.46912 5.66726 1.46912 5.775C1.46912 7.31672 1.29037 8.44609 2.43397 9.48203C1.9456 8.94744 1.67402 8.25001 1.67225 7.52594V5.98219C1.67225 5.87444 1.71505 5.77111 1.79124 5.69493C1.86742 5.61874 1.97075 5.57594 2.0785 5.57594H4.89584V3.95094H4.69272Z" fill="#F69652"/>
                                                <path d="M4.89703 3.95094H4.27344V5.57594H4.89703V3.95094Z" fill="#F69652"/>
                                                <path d="M4.3759 10.4408C4.44208 10.7876 4.53999 11.1275 4.6684 11.4564C4.68633 11.5015 4.69295 11.5502 4.68766 11.5984C4.68238 11.6466 4.66537 11.6928 4.6381 11.7329C4.61084 11.7729 4.57416 11.8057 4.53128 11.8284C4.48841 11.851 4.44063 11.8628 4.39215 11.8627C3.23524 11.8633 2.1219 11.4214 1.28027 10.6277C2.85043 12.2973 4.53027 12.0658 6.85199 12.0658V10.4408C4.31293 10.4509 4.58106 10.455 4.3759 10.4408Z" fill="#F69652"/>
                                                <path d="M15.915 1.93594H4.08496V8.59844C4.08496 10.1675 4.70825 11.6722 5.81772 12.7817C6.92719 13.8912 8.43195 14.5145 10.001 14.5145C11.57 14.5145 13.0748 13.8912 14.1842 12.7817C15.2937 11.6722 15.917 10.1675 15.917 8.59844L15.915 1.93594Z" fill="#FFC219"/>
                                                <path d="M17.7187 5.37281H16.9062C16.7166 5.37277 16.5333 5.30435 16.39 5.18011C16.2468 5.05587 16.1531 4.88413 16.1262 4.69641L16.0206 3.95094H15.1045V5.57594C18.1351 5.57594 17.9645 5.55563 18.0884 5.6125C18.0564 5.54122 18.0044 5.4807 17.9389 5.43819C17.8733 5.39567 17.7969 5.37298 17.7187 5.37281Z" fill="#F69652"/>
                                                <path d="M4.46277 8.59844V1.93594H4.08496V8.59844C4.08482 9.3911 4.24405 10.1757 4.5532 10.9056C4.86234 11.6355 5.31509 12.2958 5.88451 12.8472C6.45394 13.3986 7.12842 13.8299 7.86786 14.1155C8.60731 14.401 9.39662 14.535 10.1889 14.5094C8.65379 14.4603 7.19797 13.8161 6.12934 12.713C5.0607 11.6098 4.46305 10.1343 4.46277 8.59844Z" fill="#FFCE47"/>
                                                <path d="M15.131 1.93594V3.14047H4.46289L14.3084 3.68281C14.5289 3.69727 14.7357 3.79521 14.8867 3.95671C15.0376 4.11821 15.1213 4.33114 15.1209 4.55219V8.59844C15.1207 10.0975 14.5514 11.5406 13.5281 12.6359C12.5047 13.7313 11.1036 14.3973 9.60805 14.4992C10.416 14.5532 11.2265 14.4406 11.9892 14.1685C12.7518 13.8964 13.4505 13.4705 14.0418 12.9172C14.6332 12.364 15.1046 11.6952 15.4268 10.9523C15.749 10.2094 15.9152 9.40822 15.9151 8.59844V1.93594H15.131Z" fill="#F47C27"/>
                                                <path d="M15.6875 0.25H4.3125C3.86377 0.25 3.5 0.613769 3.5 1.0625V2.32594C3.5 2.77467 3.86377 3.13844 4.3125 3.13844H15.6875C16.1362 3.13844 16.5 2.77467 16.5 2.32594V1.0625C16.5 0.613769 16.1362 0.25 15.6875 0.25Z" fill="#FFCE47"/>
                                                <path d="M16.1489 0.394219C16.3338 0.662344 16.2931 0.77 16.2931 2.11875C16.2931 2.33424 16.2075 2.5409 16.0552 2.69327C15.9028 2.84565 15.6961 2.93125 15.4806 2.93125C3.16109 2.93125 3.94313 2.99219 3.64453 2.78703C3.97969 3.2725 3.38453 3.13844 15.6878 3.13844C15.9033 3.13844 16.11 3.05284 16.2623 2.90046C16.4147 2.74809 16.5003 2.54143 16.5003 2.32594C16.5003 1.04016 16.5917 0.698906 16.1489 0.394219Z" fill="#F69652"/>
                                                <path d="M15.0559 19.75H4.94437C4.8618 19.7498 4.78067 19.7285 4.70876 19.6879C4.63684 19.6473 4.57657 19.589 4.53374 19.5184C4.4909 19.4478 4.46693 19.3674 4.46414 19.2849C4.46135 19.2023 4.47983 19.1205 4.5178 19.0472L5.88687 16.4228C5.9681 16.2673 6.09036 16.137 6.2404 16.0461C6.39043 15.9551 6.56251 15.907 6.73796 15.9069H13.2603C13.4358 15.907 13.6078 15.9551 13.7579 16.0461C13.9079 16.137 14.0302 16.2673 14.1114 16.4228L15.4845 19.0472C15.5226 19.1207 15.541 19.2027 15.5382 19.2854C15.5353 19.3681 15.5111 19.4486 15.4681 19.5192C15.425 19.5899 15.3644 19.6482 15.2922 19.6886C15.2201 19.7291 15.1387 19.7502 15.0559 19.75Z" fill="#333333"/>
                                                <path d="M4.6296 19.0472L5.99866 16.4228C6.0799 16.2673 6.20216 16.137 6.3522 16.0461C6.50223 15.9551 6.67431 15.907 6.84976 15.9069C6.42319 15.9069 6.08601 16.0409 5.88694 16.4228L4.51585 19.0472C4.47788 19.1205 4.4594 19.2023 4.46219 19.2849C4.46498 19.3674 4.48894 19.4478 4.53178 19.5184C4.57462 19.589 4.63489 19.6473 4.7068 19.6879C4.77871 19.7285 4.85985 19.7498 4.94241 19.75H5.05413C4.97174 19.7495 4.89086 19.7279 4.81922 19.6872C4.74759 19.6464 4.6876 19.588 4.645 19.5175C4.6024 19.447 4.57861 19.3667 4.57592 19.2844C4.57322 19.202 4.5917 19.1203 4.6296 19.0472Z" fill="#4D4D4D"/>
                                                <path d="M15.4845 19.0472L14.1134 16.4228C14.0322 16.2673 13.9099 16.137 13.7599 16.0461C13.6098 15.9551 13.4378 15.907 13.2623 15.9069H6.73996L12.9292 16.4127C13.0781 16.4249 13.2212 16.4757 13.3444 16.5601C13.4677 16.6445 13.5668 16.7596 13.632 16.8941L14.4648 18.6166C14.495 18.6771 14.5096 18.7442 14.5072 18.8119C14.5049 18.8795 14.4857 18.9454 14.4514 19.0037C14.4171 19.062 14.3687 19.1109 14.3108 19.1458C14.2528 19.1807 14.1871 19.2005 14.1195 19.2036L4.94434 19.75H15.0559C15.1386 19.7502 15.22 19.7291 15.2922 19.6886C15.3644 19.6482 15.425 19.5899 15.468 19.5192C15.5111 19.4486 15.5353 19.3681 15.5381 19.2854C15.541 19.2027 15.5225 19.1207 15.4845 19.0472Z" fill="#1F1F1F"/>
                                                <path d="M15.6875 0.25H4.3125C4.09701 0.25 3.89035 0.335603 3.73798 0.487976C3.5856 0.640349 3.5 0.847012 3.5 1.0625V2.32594L3.7925 0.926406C3.81448 0.819461 3.87202 0.723107 3.95574 0.653029C4.03947 0.582952 4.14445 0.543279 4.25359 0.540469L15.6875 0.25Z" fill="#FFDA75"/>
                                            </svg>
                                        @else
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#A4AAAC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 4L12 14.01L9 11.01" stroke="#A4AAAC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @endif

                                        <!-- <div class="{{ $module->classes_count > 0 && $module->viewedClassesCount() === $module->classes_count ? 'text-success-base' : 'text-gray-40' }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 4L12 14.01L9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div> -->
                                    @endcan
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div
                        id="videoCoursesClasses-collapse-{{ $i }}"
                        aria-labelledby="videoCoursesClasses-heading-{{ $i }}"
                        @class([
                            'accordion-collapse collapse',
                            'show' => $module->open
                        ])
                    >
                        <div class="accordion-body border-gray-10 pt-4 pb-3 px-1">
                            <ul @class([
                                'list-group rounded-0',
                                'video_courses_classes_list' => $module->classes->count() > 1
                            ])>
                                @foreach ($module->getClassesOrdered() as $class)
                                    <li class="list-group-item border-start-0 border-end-0" data-id="{{ $class->id }}">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <a @if($class->link) href="{{ route('video-courses.classes.show', ['video_course' => $videoCourse->id, 'class' => $class->id]) }}" @endif>
                                                <div class="d-flex align-items-center">
                                                    @if ($class->viewed)
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12" cy="12" r="12" fill="#B4CF04"/>
                                                            <path d="M17.8284 8.22852L10.2855 15.7714L6.85693 12.3428" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    @else
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6EC1D5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M10 8L16 12L10 16V8Z" stroke="#6EC1D5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    @endif

                                                    <div class="module-classes-titles ms-6">
                                                        <div>{{ $class->furigana_title }}</div>
                                                        <div>{{ $class->translated_title ? "{$class->original_title} - {$class->translated_title}" : $class->original_title }}</div>
                                                    </div>
                                                </div>
                                            </a>

                                            <div class="d-flex gap-3 align-items-center">
                                                <span class="class-duration">{{ $class->duration }}</span>

                                                @can('admin')
                                                    <x-btn-action class="classes-btn" :action="route('video-courses.classes.edit', ['video_course' => $videoCourse->id, 'class' => $class->id])" icon="pen" style="z-index: 99;"/>
                                                    <x-btn-action class="classes-btn" action="javascript: void(0);" icon="trash"
                                                        onclick="deleteClassModal({{ $class->id }});" style="z-index: 99;"
                                                    />
                                                @endcan
                                            </div>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="class-video">
            <img class="mb-3" height="62" src="{{ asset('images/icons/video-circle.svg') }}" alt="Video Icon">
            <h1 class="p-4 text-center">Não existem módulos e aulas cadastrados</h1>
        </div>
    @endif

    {{-- begin:delete Module Modal Confirmation --}}
    <div class="modal fade" id="delete_module_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="module_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_module_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_module" type="button" onclick="deleteModuleConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:delete Module Modal Confirmation --}}

    {{-- begin:delete Class Modal Confirmation --}}
    <div class="modal fade" id="delete_class_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="text-center">
                        <input type="hidden" id="class_to_delete">
                        <img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
                        <h3 class="my-3">Você tem certeza que <br> gostaria de excluir</h3>
                        <p id="delete_class_modal_item"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                        <span>Cancelar</span>
                    </button>
                    <a id="delete_class" type="button" onclick="deleteClassConfirmed();"
                        class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
                        <span>EXCLUIR</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- end:delete Course Modal Confirmation --}}

@endsection

@section('extra-scripts')
    <script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/shared/sortablejs/sortable.min.js') }}"></script>
    <script src="{{ asset('js/video-courses/show.js') }}"></script>

    @can('admin')
        <script>
            let modulesAccordionEl = document.getElementById('video_courses_modules_accordion');

            let modulesSortable = Sortable.create(modulesAccordionEl, {
                group: "modules",
                animation: 150,
                store: {
                    set: function (sortable) {
                        var order = sortable.toArray();

                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: `/video-course-modules/reorderPositions`,
                            type: 'PUT',
                            data: {
                                'orderIds': order
                            },
                            success: function (response) {
                                let data = response;

                                notify(data.msg, data.icon);
                            },
                            error: function (error) {
                                let data = error.responseJSON;
                                notify(data.msg, data.icon);
                            }
                        });
                    }
                }
            });

            let classesListsEl = document.querySelectorAll('.video_courses_classes_list');

            classesListsEl.forEach((classesListEl, i) => {
                Sortable.create(classesListEl, {
                    group: `classes-${i}`,
                    animation: 150,
                    store: {
                        set: function (sortable) {
                            var order = sortable.toArray();

                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                url: `/video-course-classes/reorderPositions`,
                                type: 'PUT',
                                data: {
                                    'orderIds': order
                                },
                                success: function (response) {
                                    let data = response;

                                    notify(data.msg, data.icon);
                                },
                                error: function (error) {
                                    let data = error.responseJSON;
                                    notify(data.msg, data.icon);
                                }
                            });
                        }
                    }
                });
            });
        </script>
    @endcan

@endsection

<style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@600&display=swap');

    .video_course_cover {
        background-size: cover !important;
        min-height: 350px;
    }

    .video-courses-classes-accordion .accordion-item {
        border-radius: 10px !important;
        margin-bottom: 20px !important;
        box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .video-courses-classes-accordion .accordion-header .accordion-button {
        padding: 18px 20px !important;
        background-color: #FFF !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #485558 !important;
    }

    .video-courses-classes-accordion .accordion-button:not(.collapsed)::after,
    .video-courses-classes-accordion .accordion-button::after {
        display: block;
        flex-shrink: 0;
        width: 10px;
        height: 18px;
        margin-left: auto;
        content: "";
        background-image: url("data:image/svg+xml,%3Csvg width='10' height='18' viewBox='0 0 10 18' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L9 9L1 17' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-color: transparent !important;
        background-size: 100%;
        transition: transform .2s ease-in-out;
    }
    .video-courses-classes-accordion .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3Csvg width='10' height='18' viewBox='0 0 10 18' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L9 9L1 17' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        transform: rotate(90deg);
    }

    .video-courses-classes-accordion .accordion-body {
        margin-bottom: 0;
        background-color: #FFF;
        border-top: 1px solid #EFF0F0;
    }

    .accordion-body.border-gray-10 .list-group-item {
        border-color: #EFF0F0 !important;
    }

    .module-classes-count {
        font-weight: 400;
        font-size: 18px;
        color: #8C9497;
    }

    .module-classes-titles {
        font-weight: 400;
        font-size: 14px;
        line-height: 30px;
        color: #485558;
    }

    .class-duration {
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;
        color: #329FBA
    }

    .btn-action.classes-btn {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .bg-success-base {
        background-color: #B4CF04 !important;
    }
    .progress-bar {
        border-radius: 50px !important;
    }
    .progress-percent {
        font-family: 'Raleway', serif;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #FAFBF4;
    }

    .text-gray-40 {
        color: #A4AAAC;
    }
    .text-success-base {
        color: #B4CF04;
    }
</style>
