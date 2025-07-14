<div class="table-responsive-md">
    <table class="table table-curved default-datatable" id="students">
        <thead>
            <tr>
                <th>Data de Cadastro</th>
                <th>Responsável</th>
                <th>Aluno(a)</th>
                <th>Série</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preRegistrations as $preRegistration)
            <tr data-id-preRegistration="{{ $preRegistration->id }}">
                <td class="align-middle">{{ $preRegistration->formatted_created_at}}</td>
                <td class="align-middle">{{ $preRegistration->guardian_name }}</td>
                <td class="align-middle">{{ $preRegistration->student_name }}</td>
                <td class="align-middle">{{ $preRegistration->student_class }}</td>
                <td class="align-middle">
                    <div class="d-flex">
                        <x-btn-action class="me-2" :action="route('preRegistration.show', $preRegistration->id)" icon="eye"/>

                        <x-btn-action class="me-2" :action="route('preRegistration.edit', $preRegistration->id)" icon="pen"/>

                        <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                            onclick="modalDeletePreRegistration('{{ $preRegistration->id }}');"
                        />
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
