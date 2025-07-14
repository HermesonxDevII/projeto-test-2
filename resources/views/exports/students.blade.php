<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Acompanhamento Escolar</title>
    <style>
        /* Define a página A4 com margens */
        @page {
            size: A4 portrait;
            margin: 20mm;
        }
        body {
            font-family: Roboto, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* Centraliza a imagem do topo */
        .header-image {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-image img {
            max-width: 200px; /* ajuste conforme necessário */
        }
        /* Estilo do título do relatório */
        .report-title {     
            font-family: Helvetica;                  
            color: #329FBA;
            font-size: 18px;
            line-height: 24px;
            text-align: center;
            /* As propriedades abaixo foram adicionadas conforme solicitado */
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            margin-bottom: 20px;
            
        }
        /* Informações do aluno, período, turma e professora */
        .info-block {
            width: 100%;                  /* Ocupa toda a largura do contêiner */
            overflow: hidden;             /* Garante que o conteúdo não ultrapasse a largura */
            margin-bottom: 10px;          /* Espaço entre as linhas de blocos */
        }

        .info-left, .info-right {
            width: 48%;                   /* Ocupa 48% da largura para os dois blocos */
            float: left;          /* Alinha os itens no topo */
            margin-right: 4%;             /* Espaço entre os blocos */
        }

        .info-right {
            margin-right: 0;              /* Remove o espaço à direita do segundo bloco */
        }
        /* Título Avaliação centralizado */
        .avaliacao-title {
            text-align: center;
            font-weight: bold;
            font-family: Helvetica;
            color: #485558;
            margin-bottom: 20px;
            margin-top: 60px;
        }
        /* Seção de avaliação (Total de aulas e Tarefas entregues) */
        .evaluation-section {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .evaluation-box {
            width: 240px;
            height: 76px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px 0px 0px 0px;
            font-weight: bold;
            color: #fff;
        }
        .total-aulas {
            background-color: #13BED5;
        }
        .tarefas-entregues {
            background-color: #B5CA41;
        }
        /* Seção adicional (Câmera Ligada e Comportamento) */
        .additional-section {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .additional-box {
            width: 280px;
            height: 76px;
            line-height: 64px;
            border-radius: 10px;
            font-weight: 400;
            color: #fff;
            text-align: center;
            font-size: 40px;
        }
        .camera-ligada {
            background-color: #C14D6D;
        }
        .comportamento {
            background-color: #D99F52;
        }
        /* Comentários */
        .comentarios {
            padding: 0 20px;
            margin-top: 60px;
        }
        .comentarios-label {
            margin-bottom: 5px;
            font-family: Helvetica;
            color: #485558;
        }
        .comentarios-text {
            text-align: justify;
            font-family: 'ipaexg', Helvetica;
            font-size: 14px;
            color: #485558;
        }
        @font-face {
            font-family: 'ipaexg';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
        }

        .info-box {
            font-family: 'ipaexg', Helvetica;
            font-size: 14px;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            color: #485558;
        }
        .page-break {
            page-break-before: always;  /* Força uma quebra de página antes do elemento */
        }

    </style>
</head>
<body>
    @foreach ($datas as $index => $data)
        @if ($loop->index > 0)
            <div class="page-break"></div>
        @endif
       
        <div class="header-image">
            <img src="{{ public_path('images/melis-education-vertical.png') }}" alt="Logo Melis Education" style="width: 128px;height: 69px;">
        </div>

        <div class="report-title">
            <b>Relatório: Programa de Acompanhamento Escolar</b>
        </div>

        <div>
            <div class="info-box" style="float: left; width: 48%;margin-top: 20px;">
                <span><b>Aluno:</b> {{ $data['student_name'] }}</span><br>            
                <div style="margin-top: 20px;">
                    <span><b>Turma:</b> {{ $data['classroom_name'] }}</span>
                </div>
                
            </div>
            <div class="info-box" style="float: left; margin-left: 4%; width: 48%;margin-top: 20px;padding:0px 0px 0px 20px;">
                <span><b>Período:</b> {{ $data['period'] }}</span><br>
                <div style="margin-top: 20px;">
                    <span><b>Professora:</b> {{ $data['author'] }}</span>
                </div>
            </div>
        </div>
        
        <div class="avaliacao-title">
            <div style="margin-top: 60px;margin-bottom: 40px;">
                <span>Avaliação</span>
            </div>        
        </div>

    
        <div style="float: left;width: 48%; font-family: Helvetica;">
                <div style="color: #485558;">
                    <b>Total de aulas</b>
                </div>

                <div class="additional-box total-aulas" style="margin-top: 15px;">
                    <span>{{$data['participation_sum']}}/{{$data['evaluation_sum']}}</span>
                </div>

                <div style="margin-top: 40px;">
                    <b style="color: #485558; display: block;">Câmera Ligada</b>            
                </div>
                
                <div class="additional-box tarefas-entregues" style="margin-top: 15px">
                    <span>{{$data['total_camera_on']}}/{{$data['evaluation_sum']}}</span>
                </div>        
        </div>

        <div style="float: left; width: 48%;font-family: Helvetica; font-family: Helvetica; margin-left: 4%;padding:0px 20px 20px 20px;">
                <div>
                    <b style="color: #485558;">Tarefas entregues</b>
                </div>

                <div class="additional-box camera-ligada" style="margin-top: 15px;display: table; ">
                    <span>{{$data['delivery_sum']}}/{{$data['sum_homework']}}</span>
                </div>

                <div style="margin-top: 40px;">
                    <b style="color: #485558;display: block;">Comportamento</b>
                </div>

                <div class="additional-box comportamento" style="margin-top: 15px;display: table;">
                    <span>{{$data['behavior']}}</span>
                </div>
        </div>
    
        @if (!empty($data['comments']))
            <div style="margin-top: 300px;">
                <div class="comentarios-label">
                    <b>Comentários:</b>
                </div>
                <div class="comentarios-text">            
                    @foreach ($data['comments'] as $key => $comment)                   
                        <p style="white-space: pre-wrap; word-wrap: break-word;">{{ $comment }}</p>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</body>
</html>
