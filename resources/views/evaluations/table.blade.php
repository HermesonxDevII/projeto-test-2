<div class="table-responsive-md">
    <table class="table table-curved default-datatable">
        <thead>
            <tr>
                <th>Alunos</th>
                @foreach ($classroom->evaluationModel->parameters as $parameter)
                    <th>{{ $parameter->title }}</th>
                @endforeach
                <th>Comentários</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classroom->students as $student)
                <tr data-id-student="{{ $student->id }}">
                    <td class="align-middle">{{ $student->full_name }}</td>
                    @foreach ($classroom->evaluationModel->parameters as $parameter)
                        <td class="align-middle">
                            <div class="col-lg-12 col-md-12 col-sm-12 pe-3">
                                <select name="evaluations[{{ $student->id }}][{{ $parameter->id }}]" class="form-select" @required($parameter->required)>
                                    <option value="" selected>—</option>
                                    @foreach ($parameter->values as $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    @endforeach
                    <td class="align-middle text-center">
                        <x-btn-action
                            onclick="commentModal({{ $student->id }}, '{{ $student->full_name }}')"
                            icon="message-square"
                            :hasComment="!empty($student->evaluation_comment)"
                            action="javascript: void(0);" />
                        <input type="hidden" name="comments[{{ $student->id }}]" value="">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
