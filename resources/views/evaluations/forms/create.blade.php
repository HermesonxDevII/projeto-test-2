
    <div id="user_tab" class="mt-3">
            <h1>Avalie os Alunos | {{ $classroom->name }}</h1>
        </div>
        <div class="row my-8">
            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="date">Data da aula</label>
                <input type="text" class="form-control @error ('date') is-invalid @enderror"
                    id="date" name="date"
                    aria-describedby="date_feedback"
                    placeholder="Insira a data..."
                    value="{{ old('date') }}"
                    required autocomplete="off">
                @error('date')
                    <div id="date_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="title">Titulo</label>
                <input type="text" class="form-control @error ('title') is-invalid @enderror"
                    id="title" name="title"
                    aria-describedby="evaluation_title_feedback"
                    value="{{ old('title') }}"
                    placeholder="Insira o título..."
                    required>
                @error('title')
                    <div id="evaluation_title_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="content">Conteúdo da tarefa</label>
                <input type="text" class="form-control @error ('content') is-invalid @enderror"
                    id="content" name="content"
                    aria-describedby="content_feedback"
                    value="{{ old('content') }}"
                    placeholder="Insira o conteúdo..."
                >
                @error('content')
                    <div id="content_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        @include('evaluations.table')
    </div>
