<form action="{{ route('video-courses.store') }}" method="POST" id="video_course_form" enctype="multipart/form-data">
    @csrf
    <div id="course_info_tab" class="progress-tab">
        <div class="card mt-4">
            <div class="card-body pt-12 pb-10">
                <div class="row">
                    <div class="col-12">
                        <label for="video_course_name">Nome do curso</label>
                        <input type="text" class="form-control @error('video_course.title') is-invalid @enderror"
                            id="video_course_name" name="video_course[title]" aria-describedby="video_course_title_feedback"
                            placeholder="Insira o nome do curso..." value="{{ old('video_course.title') }}">

                        @error('video_course.title')
                            <div id="video_course_title_feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 mt-8">
                        <label for="video_course_description">Descrição</label>
                        <textarea class="form-control @error('video_course.description') is-invalid @enderror" 
                            id="video_course_description" name="video_course[description]" rows="3" 
                            aria-describedby="video_course_description_feedback" placeholder="Insira a descrição..."
                        >{{ old('video_course.description') }}</textarea>

                        @error('video_course.description')
                            <div id="video_course_description_feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mt-8">
                        <div class="d-flex align-items-end gap-3">
                            <div>
                                <label for="video_course_thumbnail">Thumbnail 300x246 - até 650 kb</label>
                                <input type="file" accept="image/*"
                                    class="form-control image-preview-input @error('video_course.thumbnail') is-invalid @enderror"
                                    id="video_course_thumbnail" name="video_course[thumbnail]"
                                    data-target="#video_course_thumbnail_upload" aria-describedby="video_course_thumbnail_feedback">

                                @error('video_course.thumbnail')
                                    <div id="video_course_thumbnail_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="preview-upload">
                                <img src="{{ url("storage/default_thumbnail.png") }}"
                                    accept="image/*"
                                    style="border-radius:12px"
                                    id="video_course_thumbnail_upload" alt="thumbnail"
                                    class="ml-2" width="49px" height="49px" alt="Default Course Thumbnail">
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-12 mt-8">
                        <div class="d-flex align-items-end gap-3">
                            <div>
                                <label for="video_course_cover">Capa interna 1070x350 - até 650 kb</label>
                                <input type="file" accept="image/*"
                                    class="form-control image-preview-input @error('video_course.thumbnail') is-invalid @enderror"
                                    id="video_course_cover" name="video_course[cover]"
                                    data-target="#video_course_cover_upload" aria-describedby="video_course_cover_feedback">

                                @error('video_course.thumbnail')
                                    <div id="video_course_cover_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="preview-upload">
                                <img src="{{ url("storage/default_thumbnail.png") }}"
                                    accept="image/*"
                                    style="border-radius:12px;width:72px"
                                    id="video_course_cover_upload" alt="thumbnail"
                                    class="ml-2" width="49px" height="49px" alt="Default Course Cover">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mt-8">
                        <div class="d-flex align-items-center h-100">
                            <div>
                                <div class="d-flex align-items-center gap-3">
                                    <input id="teacherAccess" class="custom-check" type="checkbox" name="video_course[teacher_access]" />
                                    <label for="teacherAccess" class="form-check-label">
                                        Liberar acesso aos professores
                                    </label>
                                </div>
                                @error('video_course.description')
                                    <div id="video_course_description_feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 d-flex justify-content-end gap-3">
            <a href="{{ route('video-courses.index') }}" class="default-btn bg-secondary btn-shadow text-white m-1 mt-8"
                style="width: 136px; height: 40px;">
                Cancelar
            </a>
            <a data-id-tab="module_tab" class="default-btn bg-primary btn-shadow text-white m-1 finish switch-tab-btn mt-8"
                style="width: 136px; height: 40px;">
                Prosseguir
            </a>
        </div>
    </div>

    <div id="module_tab" class="progress-tab d-none">
        <div class="card mt-4">
            <div class="card-body">
                <div class="mt-3 modules">
                    <h1 class="classroom-title" class="p-0 m-0">Adicionar Módulo</h1>
                    
                    <div class="row mt-8 align-items-end">
                        <div class="col-lg-8 col-md-8 col-sm-12 pe-3">
                            <label for="module_name">Nome</label>
                            <input type="text" class="form-control @error ('name') is-invalid @enderror"
                                id="module_name" aria-describedby="module_name_feedback"
                                placeholder="Insira o nome do módulo..."
                            >
                            @error('video_course_modules.*')
                                <div id="module_name_feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-4 d-flex justify-content-end">
                            <a class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center" onclick="addModule()"
                                style="width: 155px; height: 49px;">
                                Adicionar novo
                            </a>
                        </div>
                    </div>

                    <hr class="hr-divider">

                    <div class="w-100 d-flex justify-content-end mt-5">
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 d-flex justify-content-end gap-3">
            <a data-id-tab="course_info_tab" class="default-btn bg-secondary btn-shadow text-white m-1 finish switch-tab-btn mt-8"
                style="width: 136px; height: 40px;">
                Voltar
            </a>
            <button type="submit" class="default-btn bg-primary btn-shadow text-white m-1 mt-8 save-classroom-btn">
                Salvar
            </button>
        </div>
    </div>
</form>
