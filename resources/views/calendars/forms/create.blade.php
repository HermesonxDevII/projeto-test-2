@if ($errors->any())
<div class="alert alert-danger">
    <ul class="m-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(!empty($calendar))
    <form action="{{ route('calendars.update', $calendar->id) }}" method="POST" id="calendar_form">
    @method('PUT')
    <input type="hidden" name="calendar[id]" value="{{ $calendar->id }}">
@else
    <form action="{{ route('calendars.store') }}" method="POST" id="calendar_form">
@endif
    @csrf

    <div class="row mt-8">
        <div class="col-md-12 mb-4">
            <label for="full_name mb-1">Titulo do calendário</label>
            <input type="text" class="form-control @error ('calendar.title') is-invalid @enderror" id="title"
                name="calendar[title]" aria-describedby="calendar_title_feedback"
                value="{{ $calendar->title ?? old('calendar.title') }}" required>

            @error('calendar.title')
                <div id="calendar_title_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-12 mb-4">
            <label for="grade">Série</label>
            <div class="form-check p-0 row mt-1">
                @foreach ($grades as $key => $grade)
                <div class="col-md-2 mt-2">
                    @if(!empty($calendar))
                        @php $GradeId = $calendar->findGradeId($grade->id); @endphp
                        @if(!empty($GradeId))
                        <input type="hidden" name="calendar[grade][{{$key}}][id]" value="{{$GradeId}}"/>
                        @endif
                        <input type="checkbox" value="{{$grade->id}}" id="{{$grade->name}}" class="grade_select"
                            @checked(in_array($grade->id, $calendar->gradesIdList) ?? old("calendar.grade.{{$$key}}"))
                            name="calendar[grade][{{$key}}][grade_id]">
                    @else
                        <input type="checkbox" value="{{$grade->id}}" id="{{$grade->name}}" class="grade_select"
                            @checked(old("calendar.grade.{{$$key}}"))
                            name="calendar[grade][{{$key}}][grade_id]">
                    @endif
                    <label class="form-check-label" for="{{ $grade->name }}">
                        {{ $grade->name }}
                    </label>
                </div>
                @endforeach
            </div>

            @error('calendar.grade')
                <div id="calendar_grade_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="embed_code">Embed genially</label>
            <textarea type="text" class="form-control @error('calendar.embed_code') is-invalid @enderror" id="embed_code"
                name="calendar[embed_code]" placeholder="Insira o iframe aqui..." rows="5" required
                >{{$calendar->embed_code ?? old('calendar.embed_code') }}</textarea>
            <span class="invalid-feedback" role="alert">
                <strong>Código do Genially inválido.</strong>
            </span>
            @error('calendar.embed_code')
                <span class="invalid-feedback" id="embed-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

    </div>

</form>
