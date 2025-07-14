<form method="POST" action="{{ route('courses.update', $data['course']->id) }}" id="course_form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="deleted_files">
    <div class="row course-form">
        <div class="col-md-6">
            <input type="hidden" name="course[classroom_id]" value="{{ $data['classroom']->id }}">
            <input type="hidden" name="course[type]" value="2">

            <label for="module">Selecione o módulo</label>
            <select class="form-select" name="course[module_id] @error('course.module_id') is-valid @enderror" id="module" aria-label="Default select example">

                @foreach ($data['modules'] as $module)
                    <option value="{{ $module->id }}" @selected($module->id == $data['module']->id)>
                        {{ $module->formatted_name }}
                    </option>
                @endforeach

            </select>

            @error('guardian.module_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="teacher">Professor</label>
            <select class="form-select @error('course.teacher_id') is-valid @enderror" name="course[teacher_id]" id="teacher" aria-label="Default select example">
                <option value="" selected>Selecione...</option>
                @foreach ($data['teachers'] as $teacher)
                    <option value="{{ $teacher->id }}" @selected($teacher->id == $data['course']->teacher_id)>
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
            <input type="text" class="form-control @error('course.name') is-valid @enderror" id="title" name="course[name]"
                value="{{ $data['course']->name }}" placeholder="Insira o título..."/>

            @error('course.name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        @if(isset($data['course']->recorded_at) && $data['course']->recorded_at != null)
            @php
                $date = $data['course']->getOriginal('recorded_at');
                $date = explode(' ', $date);
                $date = explode('-', $date[0]);
                $date = $date[0].$date[1].$date[2];
            @endphp
        @endif

        @if(!isset($data['course']->recorded_at) || $data['course']->recorded_at == null)
            @php
                $date = ''
            @endphp
        @endif

        <div class="col-md-6">
            <label for="recorded_at">Data de gravação</label>
            <input type="text" class="form-control @error('course.recorded_at') is-invalid @enderror" id="recorded_at" name="course[recorded_at]"
                value="{{ $date }}" placeholder="Insira a data..."data-mask="0000/00/00"/>

            @error('course.recorded_at')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="link">Link do Youtube/Vimeo</label>
            <input type="text" class="form-control @error('course.link') is-invalid @enderror" id="link" name="course[link]"
                value="{{ $data['course']->link }}" placeholder="Insira a URL..."/>

             @error('course.link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="col-md-6">
            <label for="embed">Link Genially</label>
            <input type="text" class="form-control @error('course.embed_code') is-invalid @enderror" id="embed" name="course[embed_code]"
                value="{{ $data['course']->embed_code }}" placeholder="Insira o link Genially..."/>
            <span class="invalid-feedback" role="alert">
                <strong>Código do Genially inválido.</strong>
            </span>
             @error('course.embed_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="col-md-12">
            <label for="description">Descrição</label>
            <textarea type="text" class="form-control @error('course.description') is-invalid @enderror" id="description" name="course[description]"
                placeholder="Insira a descrição..."
                rows="5">{{ $data['course']->description }}</textarea>

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
                <p class="text-muted">Você pode subir arquivos .PDF, .PPT, .DOC e .JPG</p>
            </div>

            @error('materials.*')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>* {{ $message }}</strong>
                </span>
            @enderror

            <input type="file" class="d-none" id="materials" name="materials[]" multiple onchange="addMaterialFiles(this)" data-key="0">

            <div class="drop-files-list">
                @foreach($data['materials'] as $material)
                    <div class="drop-file-item">
                        <img src="{{ asset('images/icons/file-pdf-2.svg') }}" alt="PDF Icon" />
                        <span>{{$material->file->name}}</span>
                        <i class="drop-file-remove" onclick="removeFile({{$material->id}})">
                            <img src="{{ asset('images/icons/x.svg') }}" alt="Remove Icon">
                        </i>
                        <small class="drop-file-size"> {{ $material->file->size }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
