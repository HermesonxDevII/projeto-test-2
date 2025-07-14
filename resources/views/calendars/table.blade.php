<div class="table-responsive-md">
    <table class="table table-curved default-datatable" id="students">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Séries</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calendars as $calendar)
            <tr data-id-calendar="{{ $calendar->id }}">
                <td class="title_calendar align-middle">{{$calendar->title}}</td>
                <td class="align-middle">{{$calendar->gradesList}}</td>
                <td class="align-middle">
                    <div class="d-flex">
                        <x-btn-action class="me-2" :action="route('calendars.show', $calendar->id)" icon="eye" />
                        
                        @if (loggedUser()->can('update', $calendar))
                            <x-btn-action class="me-2" :action="route('calendars.edit', $calendar->id)" icon="pen" />
                        @endif
                        
                        @if (loggedUser()->can('delete', App\Models\Calendar::class))
                            <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                                onclick="modalDeleteCalendar('{{ $calendar->id }}');"
                            />
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
