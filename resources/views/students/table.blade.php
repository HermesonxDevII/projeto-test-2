<div class="table-responsive-md">
    <table class="table table-curved" id="students-datatable">
        <thead>
            <tr>
                <th>
                    <div class="checkboxes">
                        <input type="checkbox" id="select-all">
                    </div>
                </th>
                <th>Nome</th>
                <th>Turmas</th>
                <th>Série</th>
                <th class="text-center">Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr data-id-student="{{ $student->id }}">
                    <td class="align-middle">
                        <div class="checkboxes">
                            <input type="checkbox" class="student-checkbox" data-id="{{ $student->id }}">
                        </div>
                    </td>
                    <td class="full_name align-middle">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column" style="font-size: 0.9rem;">
                                <strong>{{ $student->formatted_full_name }}</strong>
                                <small class="text-muted">{{ $student->lastAccessLog?->accessed_at?->format('d/m/Y \á\s H:i') }}</small>
                            </div>

                            @if($student->created_at && $student->created_at->diffInMonths() < 1)
                                <span class="badge badge-primary bg-primary ms-2">Novo</span> 
                            @endif
                            @if($student->hasValidPreRegistrationTemporary())
                                <span class="badge badge-warning bg-warning ms-2">Temp</span> 
                            @endif
                        </div>
                    </td>
                    <td class="classrooms align-middle">{{ $student->classroomsList }}</td>
                    <td class="classrooms align-middle">{{ $student->grade->name }}</td>
                    <td class="status align-middle text-center">
                        <x-status-badge :status="$student->status" />
                    </td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-end">
                            @if ($student->studentEvaluations->count() > 0)
                                <x-btn-action class="me-2" action="javascript:void(0);" icon="download"
                                    onclick="openExportModal({{ $student->id }});" />
                            @endif


                            <x-btn-action class="me-2" :action="route('students.show', $student->id)" icon="eye" />

                            @if (loggedUser()->can('update', $student))
                                <x-btn-action class="me-2" :action="route('students.edit', $student->id)" icon="pen" />
                            @endif

                            @if (loggedUser()->can('delete', $student))
                                <x-btn-action class="me-4" action="javascript: void(0);" icon="trash"
                                    onclick="modalDeleteStudent('{{ $student->id }}');" />
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
