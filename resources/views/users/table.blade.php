<div class="table-responsive-md">
    <table class="table table-curved default-datatable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Perfil</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-id-user="{{ $user->id }}">
                    <td class="align-middle name">{{ $user->formatted_name }}</td>
                    <td class="align-middle">{{ $user->roles->first()->description }}</td>
                    <td class="align-middle">
                        <div class="d-flex">
                            <x-btn-action class="me-2" :action="route('users.edit', $user->id)" icon="pen" />
                            {{-- <x-btn-action class="me-4" :action="route('users.destroy', $user->id)" icon="trash" /> --}}
                            <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                                onclick="modalDeleteUser('{{ $user->id }}');"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
