<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">

    <style>
        /* Base */

        body,
        body *:not(html):not(style):not(br):not(tr):not(code) {
            box-sizing: border-box;
            font-family: Arial;
            position: relative;
        }

        body {
            -webkit-text-size-adjust: none;
            background-color: #ffffff;
            color: #718096;
            height: 100%;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        p, ul,ol,blockquote {
            line-height: 1.4;
            text-align: left;
        }

        a {
            color: #3869d4;
        }

        /* Typography */

        p {
            font-size: 16px;
            line-height: 1.5em;
            margin-top: 0;
            text-align: left;
            color: #606C83;
        }

        p.sub {
            font-size: 12px;
        }

        img {
            max-width: 100%;
        }

        /* Layout */

        .wrapper {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            background-color: #edf2f7;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .content {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Header */

        .header {
            padding: 25px 0;
            text-align: center;
        }

        .header a {
            color: #3d4852;
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
        }

        /* Logo */

        .logo {
            height: 100px;
            max-height: 100px;
            width: 170px;
        }

        /* Body */

        .body {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            background-color: #edf2f7;
            border-bottom: 1px solid #edf2f7;
            border-top: 1px solid #edf2f7;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .inner-body {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
            background-color: #ffffff;
            border-color: #e8e5ef;
            border-radius: 2px;
            border-width: 1px;
            box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);
            margin: 0 auto;
            padding: 0;
            width: 570px;
        }

        /* Footer */

        .footer {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
            margin: 0 auto;
            padding: 0;
            text-align: center;
            width: 570px;
        }

        .footer p {
            color: #b0adc5;
            font-size: 12px;
            text-align: center;
        }

        .footer a {
            color: #b0adc5;
            text-decoration: underline;
        }

        /* Tables */

        .table table {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            margin: 30px auto;
            width: 100%;
        }

        .table th {
            border-bottom: 1px solid #edeff2;
            margin: 0;
            padding-bottom: 8px;
        }

        .table td {
            color: #74787e;
            font-size: 15px;
            line-height: 18px;
            margin: 0;
            padding: 10px 0;
        }

        .content-cell {
            max-width: 100vw;
            padding: 32px;
        }

        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        .text-danger{
            color: #E02E3F!important;
        }

        .color-link{
            color: #329FBA!important;
            text-decoration: none;
        }
        .color-email{
            color: #606C83 !important;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="header">
                            <img src="{{ asset('images/melis-education-vertical.png') }}" class="logo" alt="Melis Logo">
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <!-- Body content -->
                                <tr>

                                    <td class="content-cell">

                                        <p>Olá, {{ $nome }}!
<br><br>
É com muita alegria que damos as boas-vindas a nossa
<span class="text-danger">Academia de Estudos Melis Education</span> 🥳
<br><br>
Desejamos que nossa área de membros seja uma experiência incrível para
você e {{ $filho }}.
<br><br>
Tenho certeza que com a nossa plataforma de estudos vamos ajudar
vocês a descomplicar os estudos da escola japonesa e trazer mais clareza
sobre o ensino no Japão.
<br><br>
📍Salve esse e-mail com seus dados de acesso à área de membros.
Você encontrará, na nossa vitrine de aulas, as gravações das aulas
semanais, aulas por temas específicos e materiais extras disponíveis.
<br><br>
📍Vocês podem acessar as aulas e baixar os materiais em seu computador,
tablet ou celular.
<br><br>
Caso você tenha qualquer dúvida referente a assuntos administrativos,
envie um e-mail para: <a href="#" class="color-link" target="_blank" >suporte@meliseducation.com</a>, nosso time de
suporte que estará à disposição para ajudar vocês.
<br><br>
Veja abaixo seu nome de usuário e senha, clique no botão para fazer login:
<br><br>
Usuário:
<br><br>
<a href="#" class="color-email">{{ $email }}</a>
<br><br>
Senha:
<br><br>{{$password}}<br><br>
Link da área de membros: <a href="{{config('app.url')}}" class="color-link" target="_blank" >Clique aqui para acessar a área de membros</a>
<br><br>
Com carinho e dedicação,
<br><br>
Lisley Nagakura,<br>
Melis Education
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <tr>
                                    <td class="content-cell" align="center">
                                        © {{ date('Y') }} Melis Education. @lang('All rights reserved.')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
