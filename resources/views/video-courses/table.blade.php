<div class="table-responsive-md">
    <table class="table table-curved default-datatable">
        <thead>
            <tr>
                <th>Curso</th>
                @can('admin')
                    <th>Qtd. Alunos</th>
                @endcan
                <th>Qtd. Aulas</th>
                <th data-orderable="false"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($videoCourses as $video_course)
                <tr data-id-video-course="{{ $video_course->id }}">
                    <td class="align-middle name">{{ $video_course->title }}</td>
                    @can('admin')
                        <td class="align-middle">{{ $video_course->students_count }}</td>
                    @endcan
                    <td class="align-middle">{{ $video_course->classes_count }}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2 pe-3">
                            <x-btn-action :action="route('video-courses.show', $video_course->id)" icon="video"/>
                            @can('admin')
                                <x-btn-action :action="route('video-courses.students', $video_course->id)" icon="users-white"/>
                                <x-btn-action :action="route('video-courses.edit', $video_course->id)" icon="pen"/>
                                <x-btn-action action="javascript: void(0);" icon="trash"
                                    onclick="modalDeleteVideoCourse({{ $video_course->id }});"
                                />
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
