<div class="table-responsive-md">
    <table class="table table-curved default-datatable">
        <thead>
            <tr>
                <th>Nome</th>
                @canany(['admin', 'teacher'])
                    <th>Qtd. Alunos</th>
                @endcanany
                <th>Agenda</th>
                @can('guardian')
                    <th>Data próx. aula</th>
                @endcan
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @if ($classrooms != null)
                @foreach ($classrooms as $classroom)
                    <tr data-id-classroom="{{ $classroom->id }}">
                        <td class="align-middle name">{{ $classroom->formatted_name }}</td>
                        @canany(['admin', 'teacher'])
                            <td class="align-middle">{{ $classroom->students->count() }} Alunos</td>
                        @endcanany
                        <td class="align-middle">{{ $classroom->weekdays }}</td>

                        @can('guardian')
                            <td>
                                {{ $classroom->nextClassDate }}
                            </td>
                        @endcan

                        <td class="align-middle">
                            <x-btn-action :action="route('classrooms.show', $classroom->id)" icon="eye"/>

                            @can('admin')
                                <x-btn-action :action="route('classrooms.edit', $classroom->id)" icon="pen"/>
                                <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                                    onclick="modalDeleteClassroom('{{ $classroom->id }}');"
                                />
                            @endcan

                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
