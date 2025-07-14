<div class="table-responsive-md">
    <table class="table table-curved default-datatable" id="guardians">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Alunos</th>
                <th class="text-center">Consultoria</th>
                <th>Data de Início</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guardians as $guardian)
                <tr data-id-guardian="{{ $guardian->id }}">
                    <td class="align-middle name">
                        {{ $guardian->formatted_name }}
                        @if($guardian->hasValidPreRegistrationTemporary())
                            <span class="badge badge-warning bg-warning ms-2">Temp</span> 
                        @endif
                    </td>
                    <td class="align-middle">{{ $guardian->studentsList }}</td>
                    <td class="align-middle text-center">
                        @if ($guardian->consultancy && $guardian->consultancy->has_consultancy)
                            <i 
                                class="fa-regular fa-circle-check icon-check-true btn-action-consultancy"
                                data-guardian-id="{{ $guardian->id }}"
                                onclick="modalConfirmConsultoriaGuardian('{{ $guardian->id }}', '{{ $guardian->consultancy?->has_consultancy ? true : false }}');"
                            >
                            </i>
                        @else
                            <i 
                                class="fa-regular fa-circle-check icon-check-false btn-action-consultancy"
                                data-guardian-id="{{ $guardian->id }}"
                                onclick="modalConfirmConsultoriaGuardian('{{ $guardian->id }}', '{{ $guardian->consultancy?->has_consultancy ? true : false }}');"
                            >
                            </i>
                        @endif                            
                    </td>
                    <td class="align-middle">{{ $guardian->created_at->format('d/m/Y') }}</td>
                    <td class="align-middle">
                        <div class="d-flex">
                            <x-btn-action class="me-2" :action="route('guardians.show', $guardian->id)" icon="eye" />
                            <x-btn-action class="me-2" :action="route('guardians.edit', $guardian->id)" icon="pen" />
                            {{-- <x-btn-action class="me-4" :action="route('guardians.destroy', $guardian->id)" icon="trash" /> --}}
                            <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                                onclick="modalDeleteGuardian('{{ $guardian->id }}', '{{ $guardian->students_count }}');"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
