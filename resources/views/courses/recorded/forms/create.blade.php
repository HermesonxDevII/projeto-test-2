{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<form method="POST" action="{{ route('courses.store') }}" id="course_form" enctype="multipart/form-data">
    @csrf
    <div class="row course-form">
        <div class="col-md-6">
            <input type="hidden" name="course[classroom_id]" value="{{ $data['classroom']->id }}">
            <input type="hidden" name="course[type]" value="2">

            <label for="module">Selecione o módulo</label>
            <select class="form-select @error('course.module_id') is-invalid @enderror" name="course[module_id]" id="module" aria-label="Default select example">
                <option value="" selected>Selecione...</option>
                @foreach ($data['modules'] as $module)
                    <option value="{{ $module->id }}" @selected(old('course.module_id') == $module->id)>
                        {{ $module->formatted_name }}
                    </option>
                @endforeach
            </select>

            @error('course.module_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="teacher">Professor</label>
            <select class="form-select @error('course.teacher_id') is-invalid @enderror" name="course[teacher_id]" id="teacher" aria-label="Default select example">
                <option value="" selected>Selecione...</option>
                @foreach ($data['teachers'] as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('course.teacher_id') == $teacher->id)>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>

            @error('course.teacher_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="title">Título</label>
            <input type="text" class="form-control @error('course.name') is-invalid @enderror" id="title" name="course[name]"
                value="{{ old('course.name') }}" placeholder="Insira o título..."/>

            @error('course.name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="recorded_at">Data de gravação</label>
            <input type="text" class="form-control @error('course.recorded_at') is-invalid @enderror" id="recorded_at" name="course[recorded_at]"
                value="{{ old('course.recorded_at') }}" placeholder="Insira a data..."data-mask="0000/00/00"/>

            @error('course.recorded_at')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="link">Link do Youtube/Vimeo</label>
            <input type="text" class="form-control @error('course.link') is-invalid @enderror" id="link" name="course[link]"
                value="{{ old('course.link') }}" placeholder="Insira a URL..."/>

            @error('course.link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="button" class="btn" id="btn_modal_yt">Vídeos do Youtube</a>
        </div>

        <div class="col-md-6">
            <label for="embed">Link Genially</label>
            <input type="text" class="form-control @error('course.embed_code') is-invalid @enderror" id="embed" name="course[embed_code]"
                value="{{ old('course.embed_code') }}" placeholder="Insira o link Genially..."/>
            <span class="invalid-feedback" role="alert">
                <strong>Código do Genially inválido.</strong>
            </span>
            @error('course.embed_code')
                <span class="invalid-feedback" id="embed-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="description">Descrição</label>
            <textarea type="text" class="form-control @error('course.description') is-invalid @enderror" id="description" name="course[description]"
                placeholder="Insira a descrição..."
                rows="5">{{ old('course.description') }}</textarea>

            @error('course.description')
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
            <input type="file" class="d-none" id="materials" name="materials[]" multiple onchange="addMaterialFiles(this)" data-key="0">
            <div class="drop-files-list">
            </div>
        </div>
    </div>
</form>
