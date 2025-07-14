@foreach ($classrooms as $classroom)
    @php $courses = $classroom->liveCourses; @endphp
    @foreach ($courses as $course)
        <div>
            <h5>{{ $classroom->formattedName }} ({{ $course->formattedName }})</h5>
        </div>
        <div class="classroom-list data-collapse" style="margin-bottom: 30px;">
            <div style="justify-content: space-around" class="row align-items-center card-aulas" data-course-id="{{ $course->id }}">
                <div class="col-xl-1 col-6 col-md-2">
                    <h5>{{ __('classroom.time') }}</h5>
                    <h5>
                        <span style="color:#a8a8a8;font-weight:normal">
                            {{ formatTime($course->start) }}
                        </span>
                    </h5>
                </div>

                <div class="col-xl-1 col-6 col-md-2">
                    <h5>{{ __('classroom.days') }}</h5>
                    <h5>
                        <span style="color:#a8a8a8;font-weight:normal">
                            {{ $course->weekdays == '' ? '-' : $course->weekdays }}
                        </span>
                    </h5>
                </div>
                @if ($course->link)
                    <div class="col-xl-4 col-md-5 link-aulas mr-3">
                        <h5>{{ __('classroom.lesson_link') }}</h5>
                        <h5>
                            <span id="link_{{ $course->id }}">
                                @if ($course->link == '')
                                    <span>-</span>
                                @else
                                    <a style="color:#329fba; font-size:15px; font-weight:400;" href="{{ $course->link }}" target="_blank">
                                        {{ $course->link }}
                                    </a>
                                @endif
                            </span>
                        </h5>
                    </div>
                    @desktop
                        <div class="col-xl-1 col-md-2">
                    @else
                        <div class="col-xl-1 col-md-2" style="margin-left: auto;">
                    @enddesktop
                        <button class="btn bg-primary btn-shadow text-white" onclick="copy('link_{{ $course->id }}')" style="width: 100%; height: 48.52px;">
                            {{ __('classroom.copy') }}
                        </button>
                    </div>
                @else
                    <div class="col-xl-4 col-md-1 link-aulas mr-3">
                    </div>
                    <div class="col-xl-1 col-md-1">
                    </div>
                @endif
                @tablet
                    @if($course->link)
                        <div class="teacher-photo-margin col-xl-2 col-md-4" style="margin-top: 10px; margin-bottom: 5px;">
                    @else
                        <div class="teacher-photo-margin col-xl-2 col-md-4">
                    @endif
                @else
                    <div class="teacher-photo-margin col-xl-2 col-md-4">
                @endtablet
                    <h5>{{ __('classroom.teacher') }}</h5>
                    <img class="classroom-teacher-photo {{ $course->teacher->trashed() ? 'teacher-deleted-photo' : '' }}"
                        src="{{ asset("storage/{$course->teacher->profile_photo}") }}"
                        style="width: 24.73px; height: 21.97px;"
                        alt="User Profile Photo"
                        data-toggle='tooltip' data-placement='top'
                        title='{{ $course->teacher->name }} {{ $course->teacher->trashed() ? '- Excluído' : '' }}'
                    >
                    <span style="margin-left:10px;color:#485558;font-weight:normal;word-wrap: break-word;">
                        {{ $course->teacher->name }} {{ $course->teacher->trashed() ? '- Excluído' : '' }}
                    </span>
                </div>
                @desktop
                    <div style="margin-top:0 !important" class="col-xl-2 col-lg-12 col-md-12">
                @enddesktop
                @tablet
                    <div style="margin-top:10px !important" class="col-xl-2 col-lg-12 col-md-12">
                @endtablet
                @mobile
                    <div style="margin-top:10 !important" class="col-xl-2 col-lg-12 col-md-12">
                @endmobile
                    <a href="{{ route('classrooms.recorded-courses', $classroom->id) }}"
                        style="width: 100%; height: 100%;"
                        class="btn bg-danger btn-shadow p-3 me-3">
                        <img src="{{ asset('images/icons/video.svg') }}" alt="Video Icon" />
                        <span class="text-white align-middle">
                            {{ __('classroom.recorded_lessons') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <script>
            $('document').ready(function () {
                $('.copy').on("click", function () {
                    $('.copy-icon').click();
                });
            });

            function copy(link_id){
                copyElementText(link_id);
                notify('Link copiado com sucesso!');
            }
            </script>
    @endforeach
@endforeach


<style>
    .teacher-photo-margin{
            margin-top:-6px;
        }
    .link-aulas{
        display: inline-block !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    @media (max-width: 575px) {
        .copy{
            margin-left: 0 !important;
        }
    }
    /* mobile */
    @media (max-width: 575px) {
        .card-aulas{
            justify-content: flex-start !important;
        }
        .copy{
            margin-left:0px !important;
            width: 185px !important;
        }
        .link-aulas{
            width: 180px;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .classroom-list div>div{
            margin-bottom:14px !important;
        }
    }


    /* tablet horizontal */
    @media (max-width: 1180px) {
        .card-aulas{
            justify-content: flex-start !important;
        }
        .link-aulas{
            display: inline-block !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        .link-aula{
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


    }

    /* tablet vertical */
    @media (max-width: 768px) {
        .link-aulas{
            display: inline-block !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        .card-aulas{
            justify-content: flex-start !important;
        }
        .link-aula{
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .copy{
            margin-left: 80%;
        }

    }


</style>


