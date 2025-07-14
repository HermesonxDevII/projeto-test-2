<form method="POST"
    action="{{ route('video-courses.classes.update', ['video_course' => $videoCourse->id, 'class' => $class->id]) }}"
    id="class_form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="deleted_files">
    <div class="row course-form">
        <div class="col-md-4">
            <label for="module">Selecione o módulo</label>
            <select class="form-select @error('class.video_course_module_id') is-invalid @enderror"
                name="class[video_course_module_id]" id="module" aria-label="Default select example">
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}" @selected($module->id == old('class.video_course_module_id', $class->video_course_module_id))>{{ $module->name }}</option>
                @endforeach
            </select>

            @error('class.video_course_module_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-8">
            <label for="teacher">Professor</label>
            <input type="text" class="form-control @error('class.teacher') is-invalid @enderror" id="teacher"
                name="class[teacher]" value="{{ old('class.teacher') ?? ($class->teacher ?? '') }}"
                placeholder="Insira o nome do professor..." />

            @error('class.teacher')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-12">
            <label for="title">Pronúncia (Furigana)</label>
            <input type="text" class="form-control @error('class.furigana_title') is-invalid @enderror"
                id="furigana_title" name="class[furigana_title]" placeholder="Insira a pronúncia..."
                value="{{ old('class.furigana_title') ?? ($class->furigana_title ?? '') }}" />

            @error('class.furigana_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-12">
            <label for="title">Título</label>
            <input type="text" class="form-control @error('class.original_title') is-invalid @enderror"
                id="original_title" name="class[original_title]" placeholder="Insira o título..."
                value="{{ old('class.original_title') ?? ($class->original_title ?? '') }}" />

            @error('class.original_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-12">
            <label for="title">Tradução em português</label>
            <input type="text" class="form-control @error('class.translated_title') is-invalid @enderror"
                id="translated_title" name="class[translated_title]" placeholder="Insira a tradução em português..."
                value="{{ old('class.translated_title') ?? ($class->translated_title ?? '') }}" />

            @error('class.translated_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="link">Link do Youtube/Vimeo</label>
            <input type="text" class="form-control @error('class.link') is-invalid @enderror" id="link"
                name="class[link]" placeholder="Insira a URL..."
                value="{{ old('class.link') ?? ($class->link ?? '') }}" />

            @error('class.link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="button" class="btn" id="btn_modal_yt">Vídeos do Youtube</a>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end gap-3">
                <div class="col-md-10">
                    <label for="class_thumbnail">Thumbnail 240x180 - até 650 kb</label>
                    <input type="file" accept="image/*"
                        class="form-control image-preview-input @error('class.thumbnail') is-invalid @enderror"
                        id="class_thumbnail" name="class[thumbnail]"
                        data-target="#class_thumbnail_upload" aria-describedby="class_thumbnail_feedback">

                    @error('class.thumbnail')
                        <div id="class_thumbnail_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div id="preview-upload">
                    <img src='{{ $class->thumbnail ? url("storage/{$class->thumbnail}") : url('storage/default_thumbnail.png') }}'
                        accept="image/*" style="border-radius:12px" id="class_thumbnail_upload" alt="thumbnail"
                        class="ml-2" width="49px" height="49px" alt="Default Course Thumbnail">
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <label for="recorded_at">Duração</label>
            <input type="text" class="form-control @error('class.duration') is-invalid @enderror" id="recorded_at"
                step="1" placeholder="00:00:00" data-mask="00:00:00" name="class[duration]"
                value="{{ old('class.duration') ?? ($class->duration ?? '') }}" />

            @error('class.duration')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="description">Descrição</label>
            <textarea type="text" class="form-control @error('class.description') is-invalid @enderror" id="description"
                name="class[description]" placeholder="Insira a descrição..." rows="5">{{ old('class.description') ?? ($class->description ?? '') }}</textarea>

            @error('class.description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-12">
            <h3>Materiais de apoio</h3>

            <div class="drop-files">
                <b><span style="color:var(--bg-primary);">Clique aqui</span> para adicionar arquivos.</b>
                {{-- ou arraste para fazer upload --}}
                <p class="text-muted">Você pode subir arquivos .PDF, .PPT, .DOC e .JPG</p>
            </div>
            @error('materials.*')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="file" class="d-none" id="materials" name="materials[]" multiple
                onchange="addMaterialFiles(this)" data-key="0">

            <div class="drop-files-list">
                @foreach ($class->files as $file)
                    <div class="drop-file-item">
                        <img src="{{ asset('images/icons/file-pdf-2.svg') }}" alt="PDF Icon" />
                        <span>{{ $file->name }}</span>
                        <i class="drop-file-remove" onclick="removeFile({{ $file->id }})">
                            <img src="{{ asset('images/icons/x.svg') }}" alt="Remove Icon">
                        </i>
                        <small class="drop-file-size"> {{ $file->size }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
