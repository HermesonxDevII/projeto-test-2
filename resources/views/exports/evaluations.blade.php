<table>
    <thead>
        <tr>
            <td></td>
            <td>Relatório Programa de Acompanhamento Escolar</td>
        </tr>
        <tr>
            <td></td>
            <td>Aluno</td>
            <td>{{ $data['student_name'] }}</td>
            <td>Turma</td>
            <td>{{ $data['classroom_name'] }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Período</td>
            <td>{{ $data['period'] }}</td>
            <td>Professora</td>
            <td>{{ $data['author'] }}</td>
        </tr>
        <tr>
            <td>Avaliação</td>
        </tr>
        <tr>
            @foreach ($data['headings'] as $heading)
                <th>{{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data['rows'] as $row)
            <tr>
                @foreach ($row as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
        <tr></tr>
        <tr>
            <td>
                Avaliação <br>
                ◯ - Entrou na hora <br>
                △ - Atraso de 5 minutos <br>
                ✖️ - Falta
            </td>
            <td>
                Avaliação <br>
                ◯ - Entregou <br>
                △ - Não entregou
            </td>
            <td>
                Avaliação <br>
                ◯ - Excelente <br>
                △ - Bom <br>
                ✖️ - Melhorar
            </td>
            <td>
                Avaliação <br>
                ◯ - O tempo inteiro on <br>
                △ - As vezes off <br>
                ✖️ - Desligada
            </td>
        </tr>
        <tr></tr>
        <tr>
            <td>
                Total de Aulas: {{ $data['evaluation_sum'] }}
            </td>
            <td>
                Total de Entregas: {{ $data['delivery_sum'] }}
            </td>
            <td>
                Total de Participações: {{ $data['participation_sum'] }}
            </td>
        </tr>
        <tr></tr>
        @if (!empty($data['comments']))
            @foreach ($data['comments'] as $key => $comment)
                <tr>
                    @if ($key == 0)
                        <td>Observações:</td>
                    @else
                        <td></td>
                    @endif
                    <td style="white-space: pre-wrap;">{{ $comment }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
