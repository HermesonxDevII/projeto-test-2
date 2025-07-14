<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Melis Education | Pré Inscrição</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        label {
            cursor: pointer;
        }

        .container {
            padding: 53px 90px;
        }

        .blue-elipse {
            position: absolute;
            right: 0px;
            z-index: -1;
        }

        .card {
            width: 100%;
            min-height: 727px;
            height: auto;
            border-radius: 24px;
            background: #FFF;
            box-shadow: 0px -3px 37.4px 0px rgba(50, 159, 186, 0.14);
            padding: 30px;
            display: flex;
        }

        .blue-card {
            min-width: 370px;
            height: auto;
            max-height: 661px;
            border-radius: 20px;
            background: var(--colors-brand-primary-darker, #329FBA);
            box-shadow: 0px -3px 37.4px 0px rgba(50, 159, 186, 0.14);
            margin-right: 89px;
        }

        .melis-logo {
            margin-top: 46px;
            margin-bottom: 40px;
            width: 240px;
            height: auto;
            margin-left: 19px;
        }

        .melis-logo-mobile {
            width: auto;
            height: 36px;
        }

        .blue-card span {
            color: #FFF;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 24px;
            opacity: 0.5;
            /* cursor: pointer; */
            transition: opacity 0.2s ease-in-out;
        }

        .blue-card span:hover {
            opacity: 1;
        }

        .blue-card span.active {
            opacity: 1;
        }

        .d-flex {
            display: flex;
        }

        .flex-column {
            flex-direction: column;
        }

        .pl-50 {
            padding-left: 50px;
        }

        .sub-title {
            color: var(--colors-neutral-gray, #1B2A2E);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Raleway, sans-serif;
            font-size: 20px;
            font-style: normal;
            font-weight: 600;
            line-height: 67px;
            height: 57px;
            margin-top: 36px;
        }

        .title {
            color: var(--colors-neutral-gray, #1B2A2E);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Raleway, sans-serif;
            font-size: 24px;
            font-style: normal;
            font-weight: 600;
            line-height: 67px;
        }

        .mb-24 {
            margin-bottom: 24px;
        }

        .mb-29 {
            margin-bottom: 29px;
        }

        .content {
            color: #606C83;
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
            margin-bottom: 134px;
        }

        .prev-btn {
            width: 136px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--colors-brand-primary-darker, #FFF);
            color: var(--colors-neutral-gray-30, #BABFC0);
            text-align: center;
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            border: 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background 0.2s ease-in-out;
            border: 2px solid var(--colors-neutral-gray-30, #BABFC0);
            margin-right: 20px;
        }

        .prev-btn:hover {
            background: var(--colors-brand-primary-darker, #FFF);
            color: var(--colors-neutral-gray-80, #485558);
        }

        .next-btn {
            width: 136px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--colors-brand-primary-darker, #329FBA);
            color: #FFF;
            text-align: center;
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            border: 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background 0.2s ease-in-out;
        }

        .next-btn:hover {
            background: var(--colors-brand-primary, #50B4D8);
        }

        .warning {
            color: var(--colors-support-error-base, #E02E3F);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 10px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .btns-wrapper {
            display: flex;
            justify-content: flex-end;
            align-items: center
        }

        .text {
            flex-shrink: 0;
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px;
        }

        .fw-600 {
            font-weight: 600;
        }

        #plan {
            width: 100%;
        }

        .mb-47px {
            margin-bottom: 47px;
        }

        .page {
            width: 100%;
        }

        .checkboxes {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .checkboxes input:not(.other) {
            width: 18px;
            height: 18px;
            margin-right: 11px;
            border-radius: 3px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            appearance: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFF;
            transition: background 0.2s ease-in-out;
        }

        .checkboxes label {
            display: flex;
            align-items: center;
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .checkboxes input:checked::before {
            content: '✔';
        }

        .checkboxes input:checked {
            background: var(--colors-brand-primary, #50B4D8);
            border: 0;
        }

        .mb-132 {
            margin-bottom: 132px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mb-43 {
            margin-bottom: 43px;
        }

        .inputs {
            display: flex;
            flex-direction: column;
        }

        .inputs label {
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 600;
            line-height: 16px;
        }

        .other {
            margin-top: 4px;
            display: flex;
            width: 474px;
            height: 38px;
            max-height: 38px;
            padding: 8px 53px 8px 15px;
            align-items: center;
            flex-shrink: 0;
            border-radius: 5px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 16px;
        }

        .inputs {
            width: 100%;
        }

        .inputs input:not([type="radio"]),
        .inputs select {
            margin-top: 4px;
            display: flex;
            width: 229px;
            height: 38px;
            padding: 8px 53px 8px 15px;
            align-items: center;
            flex-shrink: 0;
            border-radius: 5px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 16px;
            transition: border 0.2s ease-in-out;
        }

        textarea {
            display: flex;
            width: 229px;
            height: 38px;
            padding: 8px 53px 8px 15px;
            align-items: center;
            flex-shrink: 0;
            border-radius: 5px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 15px;
            font-style: normal;
            font-weight: 400;
            line-height: 16px;
            width: 100%;
            height: 79px;
            resize: none;
            transition: border 0.2s ease-in-out;
        }

        .inputs label.small-label {
            color: #485558;
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px;
        }

        .inputs select {
            appearance: none;
            background: url("{{ asset('images/icons/arrow-down.svg') }}") no-repeat right 10px center;
            background-size: 18px;
            background-color: #FFF;
        }

        .inputs input:focus,
        .inputs select:focus,
        .other:focus,
        textarea:focus {
            border: 1px solid var(--colors-brand-primary-darker, #329FBA);
            outline: none;
        }

        .inputs input.error,
        .inputs select.error,
        .other.error,
        textarea.error {
            border: 1px solid var(--colors-brand-primary-darker, #E02E3F) !important;
            outline: none;
        }

        .inputs input::placeholder,
        .inputs select::placeholder,
        .other::placeholder,
        textarea::placeholder {
            color: var(--colors-neutral-gray-30, #BABFC0);
        }

        .gap-15 {
            gap: 15px;
        }

        .mb-72 {
            margin-bottom: 72px;
        }

        .mt-25 {
            margin-top: 25px;
        }

        .mb-11 {
            margin-bottom: 11px;
        }

        .mb-25 {
            margin-bottom: 25px;
        }

        .mb-28 {
            margin-bottom: 28px;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        .form-card {
            width: 100%;
            display: flex;
            padding: 20px;
            flex-direction: column;
            align-items: flex-start;
            gap: 25px;
            border-radius: 20px;
            border: 1px solid rgba(186, 191, 192, 0.33);
            transition: border 0.3s ease-in-out;
        }

        .form-card.error {
            border: 1px solid var(--colors-brand-primary-darker, #E02E3F);
        }

        .form-card span:not(.warning) {
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
        }

        .red {
            color: var(--colors-brand-secondary, #DC1D54) !important;
        }

        .radio-inputs {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-card:not(:last-child) {
            margin-bottom: 25px;
        }

        .radio-inputs label {
            display: flex;
            align-items: center;
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .inline-radios {
            display: flex;
            gap: 71px;
            align-items: center;
        }

        .radio-inputs input[type="radio"] {
            width: 18px;
            height: 18px;
            margin-right: 11px;
            appearance: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFF;
            border-radius: 100px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
        }

        .inline-radios input[type="radio"] {
            width: 18px;
            height: 18px;
            appearance: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFF;
            border-radius: 100px;
            border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
        }

        .radio-inputs input[type="radio"]:checked,
        .inline-radios input[type="radio"]:checked {
            background: var(--colors-brand-primary, #FFF);
        }

        .radio-inputs input[type="radio"]::before,
        .inline-radios input[type="radio"]::before {
            content: "";
            width: 10px;
            height: 10px;
            background: #50B4D8;
            border-radius: 50%;
            position: absolute;
            display: none;
        }

        .radio-inputs input[type="radio"]:checked::before,
        .inline-radios input[type="radio"]:checked::before {
            display: block;
        }

        .form-card span.multi-select-warning {
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 16px;
        }

        .mb-50 {
            margin-bottom: 50px;
        }

        .mb-57 {
            margin-bottom: 57px;
        }

        .mb-58 {
            margin-bottom: 58px;
        }

        .mb-59 {
            margin-bottom: 59px;
        }

        .mb-63 {
            margin-bottom: 63px;
        }

        .mr-50 {
            margin-right: 50px;
        }

        .mr-58 {
            margin-right: 58px;
        }

        .mr-59 {
            margin-right: 59px;
        }

        .mr-63 {
            margin-right: 63px;
        }

        .ml-189 {
            margin-left: 189px;
        }

        .mr-65 {
            margin-right: 65px;
        }

        .mb-21 {
            margin-bottom: 21px;
        }

        .w-133 {
            width: 133px !important;
        }

        .mr-20 {
            margin-right: 20px;
        }

        .mb-22 {
            margin-bottom: 22px;
        }

        .my-30 {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .inline-radios-separator {
            display: flex;
            padding-bottom: 16px;
            border-bottom: 1px solid #D1D4D5;
        }

        .inline-radios-separator:not(:first-child) {
            padding-top: 10px;
        }

        .disabled {
            pointer-events: none;
        }

        .header {
            width: 100%;
            height: 100px;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mb-14 {
            margin-bottom: 14px;
        }

        .my-20 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .justify-content-center {
            justify-content: center;
        }

        .align-items-center {
            align-items: center;
        }

        .success-text {
            color: var(--colors-neutral-gray, #1B2A2E);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Raleway, sans-serif;
            font-size: 24px;
            font-style: normal;
            font-weight: 600;
            line-height: 67px;
            margin-top: 15px;
        }

        @media only screen and (max-width: 767px) {

            .card {
                min-height: 517px;
                height: auto;
                width: auto;
            }

            .container {
                padding: 44px 15px;
            }

            .blue-elipse {
                right: 0px;
                left: 150px;
                max-width: calc(100% - 150px);
                height: auto;
            }

            .content {
                color: #606C83;
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 20px;
                margin-bottom: 50px;
            }

            .fs-14 {
                font-size: 14px;
            }

            .fw-600 {
                font-weight: 600;
            }

            .title {
                color: var(--colors-neutral-gray, #1B2A2E);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Raleway, sans-serif;
                font-size: 16px;
                font-style: normal;
                font-weight: 600;
                line-height: 30px;
            }

            .sub-title {
                color: var(--colors-neutral-gray, #1B2A2E);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Raleway, sans-serif;
                font-size: 20px;
                font-style: normal;
                font-weight: 600;
                line-height: 67px;
                margin-bottom: 16px;
            }

            .checkboxes label {
                display: flex;
                align-items: start;
                color: var(--colors-neutral-gray-80, #485558);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 20px;
            }

            .inputs input:not([type="radio"]),
            .inputs select {
                margin-top: 4px;
                display: flex;
                width: 100%;
                height: 38px;
                padding: 8px 53px 8px 15px;
                align-items: center;
                flex-shrink: 0;
                border-radius: 5px;
                border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
                color: var(--colors-neutral-gray-80, #485558);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 12px;
                font-style: normal;
                font-weight: 400;
                line-height: 16px;
                transition: border 0.2s ease-in-out;
            }

            .radio-inputs input[type="radio"] {
                width: 18px;
                height: 18px;
                min-width: 18px;
                min-height: 18px;
                margin-right: 11px;
                appearance: none;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #FFFF;
                border-radius: 100px;
                border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            }

            .other {
                margin-top: 4px;
                display: flex;
                width: 100%;
                height: 38px;
                max-height: 38px;
                padding: 8px 53px 8px 15px;
                align-items: center;
                flex-shrink: 0;
                border-radius: 5px;
                border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
                color: var(--colors-neutral-gray-80, #485558);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 12px;
                font-style: normal;
                font-weight: 400;
                line-height: 16px;
            }

            .radio-inputs {
                display: flex;
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }

            .inline-radios-separator {
                display: flex;
                flex-direction: column;
                padding-bottom: 16px;
                border-bottom: 1px solid #D1D4D5;
            }

            .inline-radios {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0;
            }

            .small-title {
                color: var(--colors-neutral-gray-80, #485558);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 12px;
                font-style: normal;
                font-weight: 400;
                line-height: 16px;
                margin-bottom: 16px;
            }

            .inline-radios input[type="radio"] {
                min-width: 18px;
                min-height: 18px;
                appearance: none;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #FFFF;
                border-radius: 100px;
                border: 1px solid var(--colors-neutral-gray-20, #D1D4D5);
            }

            .mr-14 {
                margin-right: 14px;
            }

            .mr-22 {
                margin-right: 22px;
            }

            .mr-27 {
                margin-right: 27px;
            }

            .mr-19 {
                margin-right: 19px;
            }

            .mr-24 {
                margin-right: 24px;
            }

            .inputs label.small-label {
                color: #485558;
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 24px;
            }

            .small-numbers {
                color: #485558;
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 12px !important;
                font-style: normal;
                font-weight: 400 !important;
                line-height: 24px;
            }

            .ws-nowrap {
                white-space: nowrap;
            }

            .checkboxes input:not(.other) {
                min-width: 18px;
                min-height: 18px;
            }

            .mb-5 {
                margin-bottom: 5px;
            }

            .success-text {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>
    @mobile
        <div class="header">
            <img class="melis-logo-mobile" src="{{ asset('images/logo2-melis@2x.png') }}" alt="Logo da Melis Education">
        </div>
    @endmobile
    <img class="blue-elipse" src="{{ asset('images/elipse.png') }}">
    <div class="container">

        <div class="card">
            @desktop
            <div class="blue-card">
                <div class="d-flex flex-column pl-50">
                    <img class="melis-logo" src="{{ asset('images/logo-melis-branco.png') }}"
                        alt="Logo da Melis Education">
                    <div class="d-flex flex-column gap-15">
                        <span id="welcome-tab" class="tab active disasbled">• Seja Bem Vindo 📚</span>
                        @if (!$courses)
                            <span id="plan-tab" class="tab disabled">• O plano de estudos</span>
                        @endif
                        <span id="guardian-tab" class="tab disabled">• Informação do responsável</span>
                        <span id="student-tab" class="tab disabled">• Dados do aluno</span>
                        <span id="final-info-tab" class="tab disabled">• Informações finais</span>
                        <span id="thanks-tab" class="tab disabled">• Agradecimento</span>
                    </div>
                </div>
            </div>
            @enddesktop
            <div id="welcome" class="d-flex flex-column page">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                    <span class="title mb-29">Seja bem vindo!</span>
                    <span class="content">
                        Esse é o formulário de pré-inscrição para as <span
                            class="red @mobile
fs-14 fw-600
@endmobile">aulas
                            semanais</span> da
                        @mobile
                            <span class="fs-14 fw-600">Melis Education📚 <br><br> </span>
                        @elsemobile
                            Melis Education📚
                        @endmobile
                        @desktop
                        <br>
                        <br>
                        @enddesktop
                        Ao preencher esse formulário você concorda com os termos de serviço da Melis Education e se
                        compromete em @desktop <br> @enddesktop ajudar seu filho(a) em casa com todo o suporte e fazer o
                        pagamento da mensalidade
                        na
                        data combinada.
                        <br>
                        <br>
                        As informações coletadas neste formulário não serão repassadas a terceiros ou divulgadas.
                    </span>
                @else
                    <span class="sub-title">Inscrição</span>
                    <span class="title mb-29">Seja bem vindo!</span>
                    <span class="content">
                        Esse é o formulário para iniciar o <span
                            class="red @mobile
fs-14 fw-600
@endmobile">Programa
                            M.A.E</span>
                        @mobile
                            <span class="fs-14 fw-600"> (Mentoria Aprendendo a Estudar)📚 <br><br> </span>
                        @elsemobile
                            (Mentoria Aprendendo a Estudar)📚
                        @endmobile
                        @desktop
                        <br>
                        <br>
                        @enddesktop
                        Ao preencher, você estará concordando com os nossos termos de serviço e assumindo o compromisso
                        de
                        @desktop <br> @enddesktop apoiar seu filho(a) nos estudos em casa.
                        <br>
                        <br>
                        Todas as informações fornecidas são confidenciais e jamais serão compartilhadas com terceiros.
                        <br>
                        <br>
                        Estamos muito felizes em ter você e seu filho(a) conosco nessa jornada de estudo!
                    </span>
                @endif
                <div class="btns-wrapper">
                    <button id="welcome-next" class="next-btn">Iniciar</button>
                </div>
            </div>
            <div id="plan" class="d-flex flex-column page" style="display: none;">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                @else
                    <span class="sub-title">Inscrição</span>
                @endif
                <span class="title mb-29">O plano de estudo para seu filho(a)</span>
                <span class="text mb-47px">
                    <span class="fw-600">As aulas semanais que escolhemos é...<span class="red">*</span></span>
                    <br>
                    Selecione a aula que escolheu para seu filho(a) estudar na Melis Education📚
                </span>
                <div
                    class="checkboxes @desktop
                        mb-132
                        @elsedesktop
                        mb-20
                        @enddesktop">
                    <label for="plan-kokugo">
                        <input id="plan-kokugo" type="checkbox" value="Kokugo">
                        Kokugo ( Língua Nacional do Japão: @mobile
                            <br>
                        @endmobile Interpretação de texto)
                    </label>
                    <label for="plan-sansuu">
                        <input id="plan-sansuu" type="checkbox" value="Sansuu">
                        Sansuu ( Matemática nível Shougakko)
                    </label>
                    <label for="plan-suugaku">
                        <input id="plan-suugaku" type="checkbox" value="Suugaku">
                        Suugaku ( Matemática nível Chugakko)
                    </label>
                    <label for="plan-suugaku-revision">
                        <input id="plan-suugaku-revision" type="checkbox" value="Suugaku Revisão 1 e 2">
                        Suugaku Revisão 1 e 2 ( Preparação @mobile
                            <br>
                        @endmobile do vestibular)
                    </label>
                    <label for="plan-suugaku-chu">
                        <input id="plan-suugaku-chu" type="checkbox" value="Suugaku Chu 3">
                        Suugaku Chu 3 ( Matemática conteúdo 3 série do Chugakko)
                    </label>
                    <label for="plan-shakai">
                        <input id="plan-shakai" type="checkbox" value="Shakai">
                        Shakai ( Estudos Sociais)
                    </label>
                    <label for="plan-japanese">
                        <input id="plan-japanese" type="checkbox" value="Japanese">
                        Aula de Japonês (Gramática, Conversação e Kanji)
                    </label>
                    <label for="plan-english">
                        <input id="plan-english" type="checkbox" value="English">
                        Aula de Inglês (Conversação e Gramática)
                    </label>
                    <input id="study-plan" type="hidden" name="study-plan">
                    <span class="plan-warning warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                </div>
                <div class="btns-wrapper">
                    <button id="plan-prev" class="prev-btn">Voltar</button>
                    <button id="plan-next" class="next-btn">Próximo</button>
                </div>
            </div>
            <div id="guardian-1" class="d-flex flex-column page" style="display: none;">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                @else
                    <span class="sub-title">Inscrição</span>
                @endif
                <span class="title @mobile
mb-30
@endmobile">Informações do
                    responsável - 1</span>
                <span
                    class="text @desktop
                    mb-43
                    @elsedesktop
                    my-30
                    @enddesktop">
                    Todas as perguntas abaixo são para entender melhor a rotina da sua família e ajudar vocês dentro
                    <br> da sua realidade
                </span>
                <div class="inputs @desktop mb-72 @enddesktop">
                    <div class="d-flex gap-15 @mobile
flex-column
@endmobile">
                        <div>
                            <label for="guardian-name">
                                👨‍👩‍👧‍👦 Nome completo da mãe ou pai <span class="red">*</span>
                            </label>
                            <input id="guardian-name" type="text" name="guardian-name"
                                placeholder="Insira seu nome" required>
                        </div>
                        <div>
                            <label for="guardian-email">
                                ✉️ Seu e-mail <span class="red">*</span>
                            </label>
                            <input id="guardian-email" type="email" name="guardian-email"
                                placeholder="Insira seu melhor e-mail" required>
                        </div>
                        <div>
                            <label for="guardian-phone">
                                ☎️ Número de telefone para contato <span class="red">*</span>
                            </label>
                            <input id="guardian-phone" type="text" name="guardian-phone"
                                placeholder="Insira o número" required>
                        </div>
                    </div>
                    <span
                        class="text fw-600 @desktop
                            mt-25 mb-11
                            @elsedesktop
                            my-20
                            @enddesktop">
                        🏠 Endereço completo
                    </span>
                    <div
                        class="d-flex gap-15 mb-20 @mobile
flex-column
@endmobile">
                        <div>
                            <label for="zipcode">
                                Zip Code <span class="red">*</span>
                            </label>
                            <input id="zipcode" type="text" name="zipcode" placeholder="Insira o Zip Code"
                                required>
                        </div>
                        <div>
                            <label for="province">
                                Província <span class="red">*</span>
                            </label>
                            <input id="province" type="text" name="province" placeholder="Insira a Província"
                                required>
                        </div>
                        <div>
                            <label for="city">
                                Cidade <span class="red">*</span>
                            </label>
                            <input id="city" type="text" name="city" placeholder="Insira a Cidade"
                                required>
                        </div>
                    </div>
                    <div
                        class="d-flex gap-15 mb-25 @mobile
flex-column
@endmobile">
                        <div>
                            <label for="district">
                                Bairro <span class="red">*</span>
                            </label>
                            <input id="district" type="text" name="district" placeholder="Insira o Bairro"
                                required>
                        </div>
                        <div>
                            <label for="address">
                                Número <span class="red">*</span>
                            </label>
                            <input id="address" type="text" name="address" placeholder="Insira o Número"
                                required>
                        </div>
                        <div>
                            <label for="complement">
                                Complemento <span class="red">*</span>
                            </label>
                            <input id="complement" type="text" name="complement"
                                placeholder="Insira o Complemento" required>
                        </div>
                    </div>
                    <div class="d-flex gap-15 @mobile
flex-column
@endmobile">
                        <div>
                            <label for="japan-time">
                                Quanto tempo moram no Japão? <span class="red">*</span> 🇯🇵
                            </label>
                            <select id="japan-time" name="japan-time" required>
                                <option value="">Selecione</option>
                                <option value="Menos de 1 ano">Menos de 1 ano</option>
                                <option value="1 ano">1 ano</option>
                                <option value="2 anos">2 anos</option>
                                <option value="3 anos">3 anos</option>
                                <option value="4 anos">4 anos</option>
                                <option value="5 anos">5 anos</option>
                                <option value="6 anos">6 anos</option>
                                <option value="7 anos">7 anos</option>
                                <option value="8 anos">8 anos</option>
                                <option value="9 anos">9 anos</option>
                                <option value="Mais de 10 anos">Mais de 10 anos</option>
                                <option value="Mais de 20 anos">Mais de 20 anos</option>
                            </select>
                        </div>
                        <div>
                            <label for="children">
                                Quantos filhos(as) você tem? <span class="red">*</span>
                            </label>
                            <select id="children" name="children" required>
                                <option value="">Selecione</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="Mais de 6 filhos">Mais de 6 filhos</option>
                            </select>
                        </div>
                    </div>
                </div>
                @mobile
                    <span class="guardian-1-warning warning my-20" style="visibility: hidden;">Preenchimento
                        obrigatório</span>
                @endmobile
                <div class="btns-wrapper">
                    @desktop
                    <span class="guardian-1-warning warning mr-20" style="visibility: hidden;">Preenchimento
                        obrigatório</span>
                    @enddesktop
                    <button id="guardian-1-prev" class="prev-btn">Voltar</button>
                    <button id="guardian-1-next" class="next-btn">Próximo</button>
                </div>
            </div>
            <div id="guardian-2" class="d-flex flex-column page" style="display: none;">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                @else
                    <span class="sub-title">Inscrição</span>
                @endif
                <span class="title @mobile
mb-24
@endmobile">Informações do
                    responsável - 2</span>
                <div id="family-structure" class="form-card">
                    <span>Como é sua estrutura familiar? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="family-structure" value="Sou casada(o)">
                            Sou casada(o)
                        </label>
                        <label>
                            <input type="radio" name="family-structure"
                                value="Sou separada(o) e tenho a guarda do meu filho(a) compartilhada">
                            Sou separada(o) e tenho a guarda do meu filho(a) compartilhada
                        </label>
                        <label>
                            <input type="radio" name="family-structure"
                                value="Sou solteira(o) e cuido sozinha do meu filho(a)">
                            Sou solteira(o) e cuido sozinha do meu filho(a)
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="family-structure" value="outro">
                            Outro
                        </label>
                        <input id="family-structure-other" class="other" type="text" style="display: none;">
                    </div>

                    <span id="family-structure-structure-warning" class="warning"
                        style="display: none;">Preenchimento obrigatório</span>
                </div>
                <div id="family-workers" class="form-card">
                    <span>Quem compõe a renda da sua família? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="family-workers" value="Uma pessoa">
                            Uma pessoa
                        </label>
                        <label>
                            <input type="radio" name="family-workers" value="Duas pessoas">
                            Duas pessoas
                        </label>
                        <label>
                            <input type="radio" name="family-workers" value="Três pessoas">
                            Três pessoas
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="family-workers" value="outro">
                            Outro
                        </label>
                        <input id="family-workers-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="family-workers-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="workload" class="form-card">
                    <span>Qual sua carga horária de trabalho? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="workload" value="No momento não estou trabalhando">
                            No momento não estou trabalhando
                        </label>
                        <label>
                            <input type="radio" name="workload" value="Trabalho menos de 6 horas por dia">
                            Trabalho menos de 6 horas por dia
                        </label>
                        <label>
                            <input type="radio" name="workload"
                                value="Trabalho de 6~8 horas por dia (não faço hora extra)">
                            Trabalho de 6~8 horas por dia (não faço hora extra)
                        </label>
                        <label>
                            <input type="radio" name="workload" value="Trabalho 8 horas por dia + hora extra">
                            Trabalho 8 horas por dia + hora extra
                        </label>
                        <label>
                            <input type="radio" name="workload" value="Trabalho de yakin (turno noturno)">
                            Trabalho de yakin (turno noturno)
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="workload" value="outro">
                            Outro
                        </label>
                        <input id="workload-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="workload-warning warning" style="display: none;">Preenchimento obrigatório</span>
                </div>
                <div id="speaks-japanese" class="form-card">
                    <span>Sabe falar o Japonês? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="speaks-japanese" value="Falo muito bem">
                            Falo muito bem
                        </label>
                        <label>
                            <input type="radio" name="speaks-japanese" value="Falo pouco">
                            Falo pouco
                        </label>
                        <label>
                            <input type="radio" name="speaks-japanese" value="Somente Japonês de fabrica">
                            Somente Japonês de fabrica
                        </label>
                        <label>
                            <input type="radio" name="speaks-japanese" value="Não sei nada">
                            Não sei nada
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="speaks-japanese" value="outro">
                            Outro
                        </label>
                        <input id="speaks-japanese-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="speaks-japanese-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="studies-at-home" class="form-card">

                    <span>Você reserva um tempo do seu dia para sentar ao lado do seu filho(a) para estudar? <span
                            class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="studies-at-home" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="studies-at-home" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="studies-at-home" value="As vezes">
                            As vezes
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="studies-at-home" value="outro">
                            Outro
                        </label>
                        <input id="studies-at-home-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="studies-at-home-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="will-return-to-home-country" class="form-card">
                    <span>Pretendem retornar para o seu país de origem? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="will-return-to-home-country" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="will-return-to-home-country" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="will-return-to-home-country" value="Não sei">
                            Não sei
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="will-return-to-home-country"
                                value="outro">
                            Outro
                        </label>
                        <input id="will-return-to-home-country-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="will-return-to-home-country-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="home-language" class="checkboxes form-card">

                    <span>Qual idioma você se comunica com seu filho(a) em casa? <span class="red">*</span></span>

                    <span class="multi-select-warning">Pode selecionar mais de uma opção</span>

                    <div class="radio-inputs">
                        <label for="comunication-pt">
                            <input class="form-checkbox" type="checkbox" id="comunication-pt" value="Português">
                            Português
                        </label>
                        <label for="comunication-jp">
                            <input class="form-checkbox" type="checkbox" id="comunication-jp" value="Japonês">
                            Japonês
                        </label>
                        <label for="comunication-es">
                            <input class="form-checkbox" type="checkbox" id="comunication-es" value="Espanhol">
                            Espanhol
                        </label>
                        <label for="comunication-en">
                            <input class="form-checkbox" type="checkbox" id="comunication-en" value="Inglês">
                            Inglês
                        </label>
                        <div class="d-flex flex-column">
                            <label for="comunication-other">
                                <input class="form-checkbox other-checkbox" type="checkbox" id="comunication-other"
                                    value="outro">
                                Outro
                            </label>
                        </div>
                        <input id="home-language-other" class="other" type="text" style="display: none;">
                        <input id="home-language-value" type="hidden">
                    </div>

                    <span class="comunication-warning warning" style="display: none;">Preenchimento obrigatório</span>
                </div>
                <div class="btns-wrapper">
                    <button id="guardian-2-prev" class="prev-btn">Voltar</button>
                    <button id="guardian-2-next" class="next-btn">Próximo</button>
                </div>
            </div>
            <div id="student" class="d-flex flex-column page" style="display: none;">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                @else
                    <span class="sub-title">Inscrição</span>
                @endif
                <span class="title @mobile
mb-30
@endmobile">Dados do
                    aluno</span>
                <span class="text mb-43">
                    Todas as perguntas abaixo são para entender melhor a rotina de estudo do seu filho(a) em casa
                </span>
                <div class="inputs mb-57">
                    <div class="d-flex @mobile
flex-column
@endmobile gap-15">
                        <div>
                            <label for="student-name">
                                Nome completo <span class="red">*</span>
                            </label>
                            <input id="student-name" type="text" name="student-name"
                                placeholder="Insira o nome do aluno">
                        </div>
                        <div>
                            <label for="student-class">
                                Série Atual <span class="red">*</span>
                            </label>
                            <select id="student-class" name="student-class">
                                <option value="">Selecione</option>
                                <option value="Shougakko 1">Shougakko 1</option>
                                <option value="Shougakko 2">Shougakko 2</option>
                                <option value="Shougakko 3">Shougakko 3</option>
                                <option value="Shougakko 4">Shougakko 4</option>
                                <option value="Shougakko 5">Shougakko 5</option>
                                <option value="Shougakko 6">Shougakko 6</option>
                                <option value="Chugakko 1">Chugakko 1</option>
                                <option value="Chugakko 2">Chugakko 2</option>
                                <option value="Chugakko 3">Chugakko 3</option>
                            </select>
                        </div>
                        <div>
                            <label for="student-language">
                                Idioma que domina <span class="red">*</span>
                            </label>
                            <select id="student-language" name="student-language">
                                <option value="">Selecione</option>
                                <option value="Português">Português</option>
                                <option value="Japonês">Japonês</option>
                                <option value="Espanhol">Espanhol</option>
                                <option value="Inglês">Inglês</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="student-japan-arrival" class="form-card">
                    <span>Com quantos anos seu filho chegou no Japão? <span class="red">*</span></span>

                    <div class="inputs">
                        <select name="student-japan-arrival">
                            <option value="">Selecione</option>
                            <option value="Nasceu no Japao">Nasceu no Japão</option>
                            <option value="1 ano">1 ano</option>
                            <option value="2 anos">2 anos</option>
                            <option value="3 anos">3 anos</option>
                            <option value="4 anos">4 anos</option>
                            <option value="5 anos">5 anos</option>
                            <option value="6 anos">6 anos</option>
                            <option value="7 anos">7 anos</option>
                            <option value="8 anos">8 anos</option>
                            <option value="9 anos">9 anos</option>
                            <option value="10 anos">10 anos</option>
                            <option value="11 anos">11 anos</option>
                            <option value="12 anos">12 anos</option>
                            <option value="13 anos">13 anos</option>
                            <option value="14 anos">14 anos</option>
                        </select>
                    </div>

                    <span class="student-japan-arrival-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-is-shy" class="form-card">
                    <span>Seu filho é tímido? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-is-shy" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-is-shy" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-is-shy" value="Um pouco">
                            Um pouco
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-is-shy" value="outro">
                            Outro
                        </label>
                        <input id="student-is-shy-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="student-is-shy-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-time-alone" class="form-card">
                    <span>Quanto tempo seu filho(a) fica em casa sozinho(a) depois que volta da escola? <span
                            class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-time-alone" value="Não fica em casa sozinho(a)">
                            Não fica em casa sozinho(a)
                        </label>
                        <label>
                            <input type="radio" name="student-time-alone" value="1 hora">
                            1 hora
                        </label>
                        <label>
                            <input type="radio" name="student-time-alone" value="2 horas">
                            2 horas
                        </label>
                        <label>
                            <input type="radio" name="student-time-alone" value="3 horas">
                            3 horas
                        </label>
                        <label>
                            <input type="radio" name="student-time-alone" value="4 horas">
                            4 horas
                        </label>
                        <label>
                            <input type="radio" name="student-time-alone" value="5 horas">
                            5 horas
                        </label>
                        <label>
                            <input type="radio" name="student-time-alone" value="Mais de 6 horas">
                            Mais de 6 horas
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-time-alone" value="outro">
                            Outro
                        </label>
                        <input id="student-time-alone-other" class="other" type="text" style="display: none;">
                    </div>
                    <span class="student-time-alone-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-rotine" class="form-card">
                    <span>O que seu filho(a) faz em casa? <span class="red">*</span></span>

                    <div class="inputs">
                        <label class="small-label mb-25" for="">Explique qual a rotina atual do seu filho(a)
                            nos dias de semana e finais de semana..</label>
                        <textarea name="student-rotine" cols="30" rows="10"></textarea>
                    </div>

                    <span class="student-rotine-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-extra-activities" class="form-card">
                    <span>Seu filho(a) faz alguma atividade extracurricular? <span class="red">*</span></span>

                    <div class="inputs">
                        <label class="small-label mb-25">Exemplo: Bukatsu de Vôlei, Aula de Judo, Aula de Piano, Aula
                            de Inglês, Juku...</label>
                        <textarea name="student-extra-activities" cols="30" rows="10"></textarea>
                    </div>

                    <span class="student-extra-activities-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-is-focused" class="form-card">
                    <span>✏️ Seu filho(a) tem foco e concentração? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-is-focused" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-is-focused" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-is-focused" value="Um pouco">
                            Um pouco
                        </label>
                        <label>
                            <input type="radio" name="student-is-focused" value="Não Sei">
                            Não Sei
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-is-focused" value="outro">
                            Outro
                        </label>
                        <input id="student-is-focused-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="student-is-focused-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-is-organized" class="form-card">
                    <span>✏️ Seu filho(a) é organizado? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-is-organized" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-is-organized" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-is-organized" value="Um pouco">
                            Um pouco
                        </label>
                        <label>
                            <input type="radio" name="student-is-organized" value="Não Sei">
                            Não Sei
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-is-organized" value="outro">
                            Outro
                        </label>

                        <input id="student-is-organized-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="student-is-organized-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-has-good-memory" class="form-card">
                    <span>✏️ Seu filho(a) tem boa memória? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-has-good-memory" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-has-good-memory" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-has-good-memory" value="Um pouco">
                            Um pouco
                        </label>
                        <label>
                            <input type="radio" name="student-has-good-memory" value="Não Sei">
                            Não Sei
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-has-good-memory" value="outro">
                            Outro
                        </label>
                        <input id="student-has-good-memory-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="student-has-good-memory-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-has-a-study-plan" class="form-card">
                    <span>✏️ Seu filho(a) tem um planejamento de estudos? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-has-a-study-plan" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-has-a-study-plan" value="Não">
                            Não
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-has-a-study-plan"
                                value="outro">
                            Outro
                        </label>
                        <input id="student-has-a-study-plan-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="student-has-a-study-plan-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-review-tests" class="form-card">
                    <span>✏️ Seu filho(a) revisa as provas? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-review-tests" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-review-tests" value="Não">
                            Não
                        </label>
                        <label>
                            <input class="other-radio"type="radio" name="student-review-tests" value="outro">
                            Outro
                        </label>
                        <input id="student-review-tests-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="student-review-tests-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-reads" class="form-card">
                    <span>📖 Seu filho(a) tem o hábito de ler livros? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-reads" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-reads" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-reads" value="Um pouco">
                            Um pouco
                        </label>
                        <label>
                            <input class="other-radio"type="radio" name="student-reads" value="outro">
                            Outro
                        </label>
                        <input id="student-reads-other" class="other" type="text" style="display: none;">
                    </div>

                    <span class="student-reads-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-studies" class="form-card">
                    <span>✏️ Seu filho(a) sabe como estudar? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-studies" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-studies" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-studies" value="Não">
                            Um pouco
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-studies" value="outro">
                            Outro
                        </label>
                        <input id="student-studies-others" class="other" type="text" style="display: none;">
                    </div>

                    <span class="student-studies-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-watches-tv" class="form-card">
                    <span>O que seu filho(a) consome de TV? 📺 <span class="red">*</span></span>

                    <div class="inputs">
                        <textarea name="student-watches-tv" cols="30" rows="10"></textarea>
                    </div>

                    <span class="student-watches-tv-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-uses-internet" class="form-card">
                    <span>O que seu filho(a) consome na internet? <span class="red">*</span></span>

                    <div class="inputs">
                        <textarea name="student-uses-internet" cols="30" rows="10"></textarea>
                    </div>

                    <span class="student-uses-internet-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div id="student-has-smartphone" class="form-card">
                    <span>Seu filho(a) tem celular?📱 <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-has-smartphone" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-has-smartphone" value="Não">
                            Não
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-has-smartphone" value="outro">
                            Outro
                        </label>
                        <input id="student-has-smartphone-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="student-has-smartphone-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>
                <div class="btns-wrapper">
                    <button id="student-prev" class="prev-btn">Voltar</button>
                    <button id="student-next" class="next-btn">Próximo</button>
                </div>
            </div>
            <div id="final-info" class="d-flex flex-column page" style="display: none;">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                @else
                    <span class="sub-title">Inscrição</span>
                @endif
                <span class="title">Informações finais</span>

                <div id="student-grades" class="form-card">
                    <span>Como está as notas do seu filho(a) em cada matéria?</span>

                    <div class="inputs">
                        <label class="@desktop small-label mb-28 @elsedesktop small-title @enddesktop">Selecione a
                            média de notas dos últimos 6 meses</label>
                        @desktop
                        <div class="d-flex ml-189 mb-21">
                            <label class="small-label mr-50">10~20</label>
                            <label class="small-label mr-63">30~40</label>
                            <label class="small-label mr-58">50</label>
                            <label class="small-label mr-50">60~70</label>
                            <label class="small-label mr-59">80~90</label>
                            <label class="small-label">100</label>
                        </div>
                        @enddesktop
                        <div class="inline-radios-separator">
                            <label class="small-label @desktop w-133 mr-65 @elsemobile mb-5 @enddesktop">Kokugo: Língua
                                @desktop <br> @enddesktop Nacional do Japão</label>
                            @mobile
                                <div class="d-flex mb-5">
                                    <label class="small-numbers mr-14">10~20</label>
                                    <label class="small-numbers mr-22">30~40</label>
                                    <label class="small-numbers mr-27">50</label>
                                    <label class="small-numbers mr-14">60~70</label>
                                    <label class="small-numbers mr-24">80~90</label>
                                    <label class="small-numbers">100</label>
                                </div>
                            @endmobile
                            <div class="inline-radios">
                                <input type="radio" name="kokugo-grade" value="10-20">
                                <input type="radio" name="kokugo-grade" value="30-40">
                                <input type="radio" name="kokugo-grade" value="50">
                                <input type="radio" name="kokugo-grade" value="60-70">
                                <input type="radio" name="kokugo-grade" value="80-90">
                                <input type="radio" name="kokugo-grade" value="100">
                            </div>
                        </div>
                        <div class="inline-radios-separator">
                            <label class="small-label @desktop w-133 mr-65 @elsemobile mb-5 @enddesktop">Shakai:
                                Estudos @desktop <br> @enddesktop Sociais</label>
                            @mobile
                                <div class="d-flex mb-5">
                                    <label class="small-numbers mr-14">10~20</label>
                                    <label class="small-numbers mr-22">30~40</label>
                                    <label class="small-numbers mr-27">50</label>
                                    <label class="small-numbers mr-14">60~70</label>
                                    <label class="small-numbers mr-24">80~90</label>
                                    <label class="small-numbers">100</label>
                                </div>
                            @endmobile
                            <div class="inline-radios">
                                <input type="radio" name="shakai-grade" value="10-20">
                                <input type="radio" name="shakai-grade" value="30-40">
                                <input type="radio" name="shakai-grade" value="50">
                                <input type="radio" name="shakai-grade" value="60-70">
                                <input type="radio" name="shakai-grade" value="80-90">
                                <input type="radio" name="shakai-grade" value="100">
                            </div>
                        </div>
                        <div class="inline-radios-separator">
                            <label
                                class="small-label @desktop w-133 mr-65 @elsemobile mb-5 @enddesktop ws-nowrap">Sansuu/Suugaku:@desktop<br>@enddesktop
                                Matemática</label>
                            @mobile
                                <div class="d-flex mb-5">
                                    <label class="small-numbers mr-14">10~20</label>
                                    <label class="small-numbers mr-22">30~40</label>
                                    <label class="small-numbers mr-27">50</label>
                                    <label class="small-numbers mr-14">60~70</label>
                                    <label class="small-numbers mr-24">80~90</label>
                                    <label class="small-numbers">100</label>
                                </div>
                            @endmobile
                            <div class="inline-radios">
                                <input type="radio" name="sansuu-grade" value="10-20">
                                <input type="radio" name="sansuu-grade" value="30-40">
                                <input type="radio" name="sansuu-grade" value="50">
                                <input type="radio" name="sansuu-grade" value="60-70">
                                <input type="radio" name="sansuu-grade" value="80-90">
                                <input type="radio" name="sansuu-grade" value="100">
                            </div>
                        </div>
                        <div class="inline-radios-separator">
                            <label class="small-label @desktop w-133 mr-65 mb-24 @elsemobile mb-5 @enddesktop">Rika:
                                Ciência</label>
                            @mobile
                                <div class="d-flex mb-5">
                                    <label class="small-numbers mr-14">10~20</label>
                                    <label class="small-numbers mr-22">30~40</label>
                                    <label class="small-numbers mr-27">50</label>
                                    <label class="small-numbers mr-14">60~70</label>
                                    <label class="small-numbers mr-24">80~90</label>
                                    <label class="small-numbers">100</label>
                                </div>
                            @endmobile
                            <div class="inline-radios">
                                <input type="radio" name="rika-grade" value="10-20">
                                <input type="radio" name="rika-grade" value="30-40">
                                <input type="radio" name="rika-grade" value="50">
                                <input type="radio" name="rika-grade" value="60-70">
                                <input type="radio" name="rika-grade" value="80-90">
                                <input type="radio" name="rika-grade" value="100">
                            </div>
                        </div>
                        <div class="inline-radios-separator">
                            <label
                                class="small-label @desktop w-133 mr-65 @elsemobile mb-5 @enddesktop">Eigo/Gaikokugo:@desktop<br>@enddesktop
                                Inglês</label>
                            @mobile
                                <div class="d-flex mb-5">
                                    <label class="small-numbers mr-14">10~20</label>
                                    <label class="small-numbers mr-22">30~40</label>
                                    <label class="small-numbers mr-27">50</label>
                                    <label class="small-numbers mr-14">60~70</label>
                                    <label class="small-numbers mr-24">80~90</label>
                                    <label class="small-numbers">100</label>
                                </div>
                            @endmobile
                            <div class="inline-radios">
                                <input type="radio" name="eigo-grade" value="10-20">
                                <input type="radio" name="eigo-grade" value="30-40">
                                <input type="radio" name="eigo-grade" value="50">
                                <input type="radio" name="eigo-grade" value="60-70">
                                <input type="radio" name="eigo-grade" value="80-90">
                                <input type="radio" name="eigo-grade" value="100">
                            </div>
                        </div>
                    </div>

                    <span class="student-grades-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>

                <div id="student-has-difficult" class="checkboxes form-card">

                    <span>Em quais matérias seu filho(a) tem mais dificuldades? <span class="red">*</span></span>

                    <span class="multi-select-warning">Pode selecionar mais de uma opção</span>

                    <div class="radio-inputs">
                        <label for="difficult-in-kokugo">
                            <input type="checkbox" id="difficult-in-kokugo" value="Kokugo">
                            Kokugo: Língua Nacional do Japão (Interpretação de texto)
                        </label>
                        <label for="difficult-in-shakai">
                            <input id="difficult-in-shakai" type="checkbox" value="Shakai">
                            Shakai: Estudos Sociais
                        </label>
                        <label for="difficult-in-sansuu">
                            <input id="difficult-in-sansuu" type="checkbox" value="Sansuu/Suugaku">
                            Sansuu/Suugaku: Matemática
                        </label>
                        <label for="difficult-in-rika">
                            <input id="difficult-in-rika" type="checkbox" value="Rika">
                            Rika: Ciência
                        </label>
                        <label for="difficult-in-gaikokugo">
                            <input id="difficult-in-gaikokugo" type="checkbox" value="Gaikokugo/Eigo">
                            Gaikokugo/Eigo: Inglês
                        </label>
                        <label for="difficult-in-japanese">
                            <input id="difficult-in-japanese" type="checkbox" value="Japonês">
                            Japonês: Gramatica, Kanji e Conversação
                        </label>
                        <div class="d-flex flex-column">
                            <label for="difficult-other">
                                <input class="form-checkbox other-checkbox" type="checkbox" id="difficult-other"
                                    value="outro">
                                Outro
                            </label>
                        </div>
                        <input id="student-has-difficult-other" class="other" type="text"
                            style="display: none;">
                        <input id="student-has-difficult-value" type="hidden">
                    </div>

                    <span class="student-has-difficult-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>

                <div id="student-difficult-in-class" class="form-card">
                    <span>Quais os maiores problemas/dificuldades que seu filho(a) está enfrentando nos estudos da
                        escola japonesa? <span class="red">*</span></span>

                    <div class="inputs">
                        <label class="small-label mb-25">Escreva uma breve explicação da situação que vocês estão
                            passando e suas preocupações<br>Sua resposta</label>
                        <textarea name="student-difficult-in-class" cols="30" rows="10"></textarea>
                    </div>

                    <span class="student-difficult-in-class-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>

                <div id="student-frequency-in-support-class" class="form-card">
                    <span>Seu filho(a) frequenta alguma sala de apoio na escola japonesa? <span
                            class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-support-class"
                                value="Não frequenta nenhuma sala a parte">
                            Não frequenta nenhuma sala a parte
                        </label>
                        <label>
                            <input type="radio" name="student-support-class" value="Sala de Japonês">
                            Sala de Japonês
                        </label>
                        <label>
                            <input type="radio" name="student-support-class"
                                value="Sala especial para alunos com deficiência">
                            Sala especial para alunos com deficiência
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-support-class" value="outro">
                            Outro
                        </label>
                        <input id="student-frequency-in-support-class-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="student-frequency-in-support-class-warning warning"
                        style="display: none;">Preenchimento obrigatório</span>
                </div>

                <div id="student-will-take-entrance-exames" class="form-card">
                    <span>Seu filho(a) quer prestar o vestibular para o Koukou? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-will-take-entrance-exames" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-will-take-entrance-exames" value="Não">
                            Não
                        </label>
                        <label>
                            <input type="radio" name="student-will-take-entrance-exames" value="Não sabe ainda">
                            Não sabe ainda
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-will-take-entrance-exames"
                                value="outro">
                            Outro
                        </label>
                        <input id="student-will-take-entrance-exames-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="student-will-take-entrance-exames-warning warning"
                        style="display: none;">Preenchimento obrigatório</span>
                </div>

                <div id="student-has-taken-online-classes" class="form-card">
                    <span>Seu filho já estudou através de aulas online? <span class="red">*</span></span>

                    <div class="radio-inputs">
                        <label>
                            <input type="radio" name="student-has-taken-online-classes" value="Sim">
                            Sim
                        </label>
                        <label>
                            <input type="radio" name="student-has-taken-online-classes" value="Não">
                            Não
                        </label>
                        <label>
                            <input class="other-radio" type="radio" name="student-has-taken-online-classes"
                                value="outro">
                            Outro
                        </label>
                        <input id="student-has-taken-online-classes-other" class="other" type="text"
                            style="display: none;">
                    </div>

                    <span class="student-has-taken-online-classes-warning warning"
                        style="display: none;">Preenchimento obrigatório</span>
                </div>

                <div id="guardian-expectations" class="form-card">
                    @if (!$courses)
                        <span>O que precisa acontecer nos estudos do seu filho(a) nos próximos 6 meses para você dizer
                            que
                            valeu a pena investir nas Aulas Semanais da Melis Education? <span
                                class="red">*</span></span>
                    @else
                        <span>O que precisa acontecer nos estudos do seu filho nos próximos meses para você dizer que
                            valeu a pena investir no Programa M.A.E? <span class="red">*</span></span>
                    @endif

                    <div class="inputs">
                        <textarea name="guardian-expectations" cols="30" rows="10"></textarea>
                    </div>

                    <span class="guardian-expectations-warning warning" style="display: none;">Preenchimento
                        obrigatório</span>
                </div>

                @if ($courses)
                    <div id="guardian-motivations" class="form-card">
                        <span>Por que você decidiu comprar o Programa M.A.E? <span class="red">*</span></span>

                        <div class="inputs">
                            <textarea name="guardian-motivations" cols="30" rows="10"></textarea>
                        </div>

                        <span class="guardian-motivations-warning warning" style="display: none;">Preenchimento
                            obrigatório</span>
                    </div>
                @endif

                <div id="guardian-concerns" class="form-card">
                    <span>Gostaria de compartilhar algum acontecimento ou preocupação?</span>

                    <div class="inputs">
                        <label class="small-label mb-25">Caso tenha acontecido alguma coisa na escola ou tenha alguma
                            preocupação em relação aos estudos do seu<br>filho(a) fique a vontade para compartilhar
                            aqui</label>
                        <textarea name="guardian-concerns" cols="30" rows="10"></textarea>
                    </div>
                </div>

                @if (!$courses)
                    <div class="btns-wrapper">
                        <button id="final-info-prev" class="prev-btn">Voltar</button>
                        <button id="final-info-next" class="next-btn">Próximo</button>
                    </div>
                @else
                    <div class="btns-wrapper">
                        <button id="final-info-prev" class="prev-btn">Voltar</button>
                        <button id="final-info-next" class="next-btn">Enviar</button>
                    </div>
                @endif
            </div>
            <div id="thanks" class="d-flex flex-column page" style="display: none;">
                @if (!$courses)
                    <span class="sub-title">Pré Inscrição</span>
                @else
                    <span class="sub-title">Inscrição</span>
                @endif
                @if (!$courses)
                    <span class="title mb-29">Parabéns! 👏🏻 🥳 🙌</span>
                    <span class="content">
                        Parabéns pela decisão em investir no conhecimento do seu filho(a)!
                        <br>
                        <br>
                        Tenha certeza que nosso time irá entregar o melhor conteúdo para ajudar seu filho(a) nos
                        estudos da escola japonesa! <br>
                        Com carinho e dedicação, desejamos que a experiência do seu
                        filho(a) seja de muito resultado!
                        <br>
                        <br>
                        Clique no botão "Enviar" para concluir a inscrição do seu filho(a)
                    </span>
                @else
                    <span class="title mb-29">Parabéns a inscrição do seu filho foi confirmada! 👏🏻 🥳 🙌</span>
                    <span class="content">
                        Seu link para ter acesso ao Programa M.A.E será enviado para seu e-mail cadastrado no momento da
                        compra!
                        <br>
                        <br>
                        Estou muito feliz em poder ajudar seu filho(a) nessa jornada.
                    </span>
                @endif
                @if (!$courses)
                    <div class="btns-wrapper">
                        <button id="thanks-prev" class="prev-btn">Voltar</button>
                        <button id="thanks-next" class="next-btn">Enviar</button>
                    </div>
                @endif
            </div>
            <div id="success" class="d-flex flex-column align-items-center justify-content-center page"
                style="display: none;">
                <img @desktop style="margin-right: 89px;" @enddesktop
                    src="{{ asset('images/icons/check-circle.png') }}">
                <span @desktop style="margin-right: 75px;" @enddesktop
                    class="success-text ws-nowrap">Inscrição feita com sucesso !</span>
            </div>
        </div>
    </div>
</body>

</html>

<footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imask"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        const courses = @json($courses);
        const phoneInput = document.getElementById('guardian-phone');
        const zipCodeInput = document.getElementById('zipcode');

        const phoneMaskOptions = {
            mask: '000-0000-0000'
        };

        const zipCodeMaskOptions = {
            mask: '000-0000'
        };

        const phoneMask = IMask(phoneInput, phoneMaskOptions);
        const zipCodeMask = IMask(zipCodeInput, zipCodeMaskOptions);

        var tabs = $('.tab');
        var pages = $('.page');

        var welcomeTab = $('#welcome-tab');
        var welcome = $('#welcome');
        var welcomeNext = $('#welcome-next');

        welcomeNext.click(function() {
            welcome.hide();
            welcomeTab.removeClass('active');

            if (courses) {
                guardian1.show();
                guardianTab.addClass('active');
                guardianName.focus();
                scrollToTop();
            } else {
                plan.show();
                planTab.addClass('active');
            }
        });

        var planTab = $('#plan-tab');
        var plan = $('#plan');
        var planPrev = $('#plan-prev');
        var planNext = $('#plan-next');

        planPrev.click(function() {
            plan.hide();
            planTab.removeClass('active');
            welcome.show();
            welcomeTab.addClass('active');
            scrollToTop();
        });

        planNext.click(function() {

            var selectedOptions = $('.checkboxes input:checked');

            if (selectedOptions.length === 0) {
                $('.plan-warning').css('visibility', 'visible');

                setTimeout(function() {
                    $('.plan-warning').css('visibility', 'hidden');
                }, 3000);

                return;
            }

            $.each(selectedOptions, function(index, opt) {
                if (index === 0) {
                    $('#study-plan').val(opt.value);
                } else {
                    $('#study-plan').val($('#study-plan').val() + ', ' + opt.value);
                }
            });

            plan.hide();
            planTab.removeClass('active');
            guardian1.show();
            guardianTab.addClass('active');
            guardianName.focus();
            scrollToTop();
        });

        var guardianTab = $('#guardian-tab');

        var guardian1 = $('#guardian-1');
        var guardian1Prev = $('#guardian-1-prev');
        var guardian1Next = $('#guardian-1-next');

        function tryGetAddressByEmail(email) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data = {
                'email': email
            }

            $.ajax({
                type: "POST",
                url: "preRegistration/tryGetAddressByEmail",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.message == 'success') {

                        $('#zipcode').val('');
                        $('#zipcode').val(response.data.zip_code);


                        $('#province').val('');
                        $('#province').val(response.data.province);

                        $('#city').val('');
                        $('#city').val(response.data.city);

                        $('#district').val('');
                        $('#district').val(response.data.district);

                        $('#address').val('');
                        $('#address').val(response.data.number);

                        $('#complement').val('');
                        $('#complement').val(response.data.complement);
                    }
                }
            });
        }

        var guardianEmail = $('#guardian-email');

        guardianEmail.on('input', function() {
            clearTimeout($(this).data('timeout'));

            $(this).data('timeout', setTimeout(function() {
                tryGetAddressByEmail(guardianEmail.val());
            }, 1000));
        });

        guardian1Prev.click(function() {
            guardian1.hide();
            guardianTab.removeClass('active');

            if (courses) {
                welcome.show();
                welcomeTab.addClass('active');
            } else {
                plan.show();
                planTab.addClass('active');
            }
            scrollToTop();
        });

        guardian1Next.click(function() {
            var formFields = $('.inputs input[required], .inputs select[required]');
            var firstInvalidField;

            for (var i = 0; i < formFields.length; i++) {
                var isValidField = validateField($(formFields[i]));

                if (!isValidField) {
                    $(formFields[i]).addClass('error');

                    if ($(formFields[i]).attr('id') === 'guardian-email') {
                        $('.guardian-1-warning').html('E-mail inválido').css('visibility', 'visible');
                    } else {
                        $('.guardian-1-warning').html('Preenchimento Obrigatório').css('visibility', 'visible');
                    }

                    if (!firstInvalidField) {
                        firstInvalidField = formFields[i];
                    }

                    setTimeout(function() {
                        $('.guardian-1-warning').css('visibility', 'hidden');
                        $(firstInvalidField).removeClass('error');
                    }, 3000);

                    firstInvalidField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });

                    return;
                }
            }

            guardian1.hide();
            guardian2.show();
            scrollToTop();
        });


        function validateField(field) {
            var isValid = true;

            if (field.attr('type') === 'email') {
                if (!isValidEmail(field.val())) {
                    isValid = false;
                }
            }

            if (field.val() === '') {
                isValid = false;
            }

            if (!isValid) {
                field.addClass('error');
            } else {
                field.removeClass('error');
            }

            return isValid;
        }

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        $('input[type="radio"]').change(function() {
            var otherInput = $(this).parent().parent().find('.other');

            if ($(this).hasClass('other-radio') == false) {
                otherInput.hide();
            }

            if ($(this).is(':checked') && $(this).hasClass('other-radio')) {
                otherInput.show();
            }
        });

        $('.form-checkbox').change(function() {
            var otherInput = $(this).parent().parent().parent().find('.other');

            if ($('.other-checkbox').is(':checked')) {
                otherInput.show();
            } else {
                otherInput.hide();
            }
        });

        function validateOtherInput(group) {
            var otherRadio = group.find('.other-radio');
            var otherInput = group.find('.other');

            if (otherRadio.prop('checked') && otherInput.val().trim() === '') {
                otherInput.addClass('error');
                setTimeout(function() {
                    otherInput.removeClass('error');
                }, 3000);
                return false;
            }

            return true;
        }

        function validateCheckboxOtherInput(group) {
            var otherCheckbox = group.find('.other-checkbox');
            var otherInput = group.find('.other');

            if (otherCheckbox.prop('checked') && otherInput.val().trim() === '') {
                otherInput.addClass('error');
                setTimeout(function() {
                    otherInput.removeClass('error');
                }, 3000);
                return false;
            }

            return true;
        }

        var guardian2 = $('#guardian-2');
        var guardian2Prev = $('#guardian-2-prev');
        var guardian2Next = $('#guardian-2-next');

        guardian2Next.click(function() {

            if (!validateRadioGroup($('#family-structure .radio-inputs'))) {
                showError($('#family-structure'), $('#family-structure-structure-warning'));
                return;
            }

            if (!validateOtherInput($('#family-structure .radio-inputs'))) {
                showError($('#family-structure'), $('#family-structure-structure-warning'));
                return;
            }

            if (!validateRadioGroup($('#family-workers .radio-inputs'))) {
                showError($('#family-workers'), $('.family-workers-warning'));
                return;
            }

            if (!validateOtherInput($('#family-workers .radio-inputs'))) {
                showError($('#family-workers'), $('.family-workers-warning'));
                return;
            }

            if (!validateRadioGroup($('#workload .radio-inputs'))) {
                showError($('#workload'), $('.workload-warning'));
                return;
            }

            if (!validateOtherInput($('#workload .radio-inputs'))) {
                showError($('#workload'), $('.workload-warning'));
                return;
            }

            if (!validateRadioGroup($('#speaks-japanese .radio-inputs'))) {
                showError($('#speaks-japanese'), $('.speaks-japanese-warning'));
                return;
            }

            if (!validateOtherInput($('#speaks-japanese .radio-inputs'))) {
                showError($('#speaks-japanese'), $('.speaks-japanese-warning'));
                return;
            }

            if (!validateRadioGroup($('#studies-at-home .radio-inputs'))) {
                showError($('#studies-at-home'), $('.studies-at-home-warning'));
                return;
            }

            if (!validateOtherInput($('#studies-at-home .radio-inputs'))) {
                showError($('#studies-at-home'), $('.studies-at-home-warning'));
                return;
            }

            if (!validateRadioGroup($('#will-return-to-home-country .radio-inputs'))) {
                showError($('#will-return-to-home-country'), $('.will-return-to-home-country-warning'));
                return;
            }

            if (!validateOtherInput($('#will-return-to-home-country .radio-inputs'))) {
                showError($('#will-return-to-home-country'), $('.will-return-to-home-country-warning'));
                return;
            }

            if (!validateCheckboxGroup($('#home-language .radio-inputs'))) {
                showError($('#home-language'), $('.comunication-warning'));
                return;
            }

            guardian2.hide();
            student.show();
            guardianTab.removeClass('active');
            $('#student-name').focus();
            studentTab.addClass('active');
            scrollToTop();
        });

        function validateRadioGroup(group) {
            return group.find('input[type=radio]:checked').length > 0;
        }

        function validateCheckboxGroup(group) {

            var checkboxes = group.find('input[type=checkbox]:checked');

            if (checkboxes.length === 0) {
                return false;
            }

            var groupId = group.parent().attr('id');

            var otherCheckbox = group.find('.other-checkbox');

            if (otherCheckbox.prop('checked') && $('#' + groupId + '-other').val().trim() === '') {
                $('#' + groupId + '-other').addClass('error');
                setTimeout(function() {
                    $('#' + groupId + '-other').removeClass('error');
                }, 3000);
                return false;
            }

            $.each(checkboxes, function(index, opt) {
                if (index === 0) {
                    if (opt.value == 'outro') {
                        $('#' + groupId + '-value').val(ucfirst($('#' + groupId + '-other').val()));
                    } else {
                        $('#' + groupId + '-value').val(opt.value);
                    }
                } else {
                    if (opt.value == 'outro') {
                        $('#' + groupId + '-value').val($('#' + groupId + '-value').val() + ', ' + ucfirst($('#' +
                            groupId + '-other').val()));
                    } else {
                        $('#' + groupId + '-value').val($('#' + groupId + '-value').val() + ', ' + opt.value);
                    }
                }
            });

            return true;
        }

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showError(card, warning) {
            card.addClass('error');
            warning.css('display', 'block');

            $('html, body').animate({
                scrollTop: card.offset().top - 100
            }, 500);

            setTimeout(function() {
                card.removeClass('error');
                warning.css('display', 'none');
            }, 3000);
        }

        guardian2Prev.click(function() {
            guardian2.hide();
            guardian1.show();
            guardianName.focus();
            scrollToTop();
        });

        var guardianName = $('#guardian-name');

        var studentTab = $('#student-tab');
        var student = $('#student');
        var studentPrev = $('#student-prev');
        var studentNext = $('#student-next');

        studentPrev.click(function() {
            student.hide();
            guardian2.show();
            studentTab.removeClass('active');
            guardianTab.addClass('active');
            scrollToTop();
        });

        studentNext.click(function() {
            if (!validateRequiredField($('#student-name'))) {
                showError($('#student-name'), $('.student-name-warning'));
                return;
            }

            if (!validateRequiredField($('#student-class'))) {
                showError($('#student-class'), $('.student-class-warning'));
                return;
            }

            if (!validateRequiredField($('#student-language'))) {
                showError($('#student-language'), $('.student-language-warning'));
                return;
            }

            if (!validateSelectField($('#student-japan-arrival select'))) {
                showError($('#student-japan-arrival'), $('.student-japan-arrival-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-is-shy .radio-inputs'))) {
                showError($('#student-is-shy'), $('.student-is-shy-warning'));
                return;
            }

            if (!validateOtherInput($('#student-is-shy .radio-inputs'))) {
                showError($('#student-is-shy'), $('.student-is-shy-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-time-alone .radio-inputs'))) {
                showError($('#student-time-alone'), $('.student-time-alone-warning'));
                return;
            }

            if (!validateOtherInput($('#student-time-alone .radio-inputs'))) {
                showError($('#student-time-alone'), $('.student-time-alone-warning'));
                return;
            }

            if (!validateTextareaField($('#student-rotine textarea'))) {
                showError($('#student-rotine'), $('.student-rotine-warning'));
                return;
            }

            if (!validateTextareaField($('#student-extra-activities textarea'))) {
                showError($('#student-extra-activities'), $('.student-extra-activities-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-is-focused .radio-inputs'))) {
                showError($('#student-is-focused'), $('.student-is-focused-warning'));
                return;
            }

            if (!validateOtherInput($('#student-is-focused .radio-inputs'))) {
                showError($('#student-is-focused'), $('.student-is-focused-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-is-organized .radio-inputs'))) {
                showError($('#student-is-organized'), $('.student-is-organized-warning'));
                return;
            }

            if (!validateOtherInput($('#student-is-organized .radio-inputs'))) {
                showError($('#student-is-organized'), $('.student-is-organized-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-has-good-memory .radio-inputs'))) {
                showError($('#student-has-good-memory'), $('.student-has-good-memory-warning'));
                return;
            }

            if (!validateOtherInput($('#student-has-good-memory .radio-inputs'))) {
                showError($('#student-has-good-memory'), $('.student-has-good-memory-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-has-a-study-plan .radio-inputs'))) {
                showError($('#student-has-a-study-plan'), $('.student-has-a-study-plan-warning'));
                return;
            }

            if (!validateOtherInput($('#student-has-a-study-plan .radio-inputs'))) {
                showError($('#student-has-a-study-plan'), $('.student-has-a-study-plan-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-review-tests .radio-inputs'))) {
                showError($('#student-review-tests'), $('.student-review-tests-warning'));
                return;
            }

            if (!validateOtherInput($('#student-review-tests .radio-inputs'))) {
                showError($('#student-review-tests'), $('.student-review-tests-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-reads .radio-inputs'))) {
                showError($('#student-reads'), $('.student-reads-warning'));
                return;
            }

            if (!validateOtherInput($('#student-reads .radio-inputs'))) {
                showError($('#student-reads'), $('.student-reads-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-studies .radio-inputs'))) {
                showError($('#student-studies'), $('.student-studies-warning'));
                return;
            }

            if (!validateOtherInput($('#student-studies .radio-inputs'))) {
                showError($('#student-studies'), $('.student-studies-warning'));
                return;
            }

            if (!validateTextareaField($('#student-watches-tv textarea'))) {
                showError($('#student-watches-tv'), $('.student-watches-tv-warning'));
                return;
            }

            if (!validateTextareaField($('#student-uses-internet textarea'))) {
                showError($('#student-uses-internet'), $('.student-uses-internet-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-has-smartphone .radio-inputs'))) {
                showError($('#student-has-smartphone'), $('.student-has-smartphone-warning'));
                return;
            }

            if (!validateOtherInput($('#student-has-smartphone .radio-inputs'))) {
                showError($('#student-has-smartphone'), $('.student-has-smartphone-warning'));
                return;
            }

            student.hide();
            finalInfo.show();
            studentTab.removeClass('active');
            finalInfoTab.addClass('active');
            scrollToTop();
        });

        function validateRequiredField(field) {
            return field.val().trim() !== '';
        }

        function validateSelectField(select) {
            return select.val() !== '';
        }

        function validateTextareaField(textarea) {
            var text = textarea.val().trim();
            var textLength = text.length;
            warningField = textarea.parent().parent().find('.warning');

            if (textLength > 10000) {
                warningField.html('O campo deve ter um máximo de 10000 caracteres');
            } else {
                warningField.html('Preenchimento obrigatório');
            }

            return text !== '' && text.length <= 10000;
        }

        function showError(field, warning) {
            field.addClass('error');
            warning.css('display', 'block');

            $('html, body').animate({
                scrollTop: field.offset().top - 100
            }, 500);

            setTimeout(function() {
                field.removeClass('error');
                warning.css('display', 'none');
            }, 3000);
        }

        var finalInfoTab = $('#final-info-tab');
        var finalInfo = $('#final-info');
        var finalInfoPrev = $('#final-info-prev');
        var finalInfoNext = $('#final-info-next');

        finalInfoPrev.click(function() {
            finalInfo.hide();
            student.show();
            finalInfoTab.removeClass('active');
            studentTab.addClass('active');
            scrollToTop();
        });

        finalInfoNext.click(function() {
            if (!validateStudentGrades()) {
                return;
            }

            if (!validateCheckboxGroup($('#student-has-difficult .radio-inputs'))) {
                showError($('#student-has-difficult'), $('.student-has-difficult-warning'));
                return;
            }

            if (!validateTextareaField($('#student-difficult-in-class textarea'))) {
                showError($('#student-difficult-in-class'), $('.student-difficult-in-class-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-frequency-in-support-class .radio-inputs'))) {
                showError($('#student-frequency-in-support-class'), $(
                    '.student-frequency-in-support-class-warning'));
                return;
            }

            if (!validateOtherInput($('#student-frequency-in-support-class .radio-inputs'))) {
                showError($('#student-frequency-in-support-class'), $(
                    '.student-frequency-in-support-class-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-will-take-entrance-exames .radio-inputs'))) {
                showError($('#student-will-take-entrance-exames'), $('.student-will-take-entrance-exames-warning'));
                return;
            }

            if (!validateOtherInput($('#student-will-take-entrance-exames .radio-inputs'))) {
                showError($('#student-will-take-entrance-exames'), $('.student-will-take-entrance-exames-warning'));
                return;
            }

            if (!validateRadioGroup($('#student-has-taken-online-classes .radio-inputs'))) {
                showError($('#student-has-taken-online-classes'), $('.student-has-taken-online-classes-warning'));
                return;
            }

            if (!validateOtherInput($('#student-has-taken-online-classes .radio-inputs'))) {
                showError($('#student-has-taken-online-classes'), $('.student-has-taken-online-classes-warning'));
                return;
            }

            if (!validateTextareaField($('#guardian-expectations textarea'))) {
                showError($('#guardian-expectations'), $('.guardian-expectations-warning'));
                return;
            }

            if (courses) {
                if (!validateTextareaField($('#guardian-motivations textarea'))) {
                    showError($('#guardian-motivations'), $('.guardian-motivations-warning'));
                    return;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var data = {
                    'study_plan': $('#study-plan').val(),
                    'guardian_name': $('#guardian-name').val(),
                    'guardian_email': $('#guardian-email').val(),
                    'guardian_phone': $('#guardian-phone').val(),
                    'zipcode': $('#zipcode').val(),
                    'province': $('#province').val(),
                    'city': $('#city').val(),
                    'district': $('#district').val(),
                    'address': $('#address').val(),
                    'complement': $('#complement').val(),
                    'japan_time': $('#japan-time').val(),
                    'children': $('#children').val(),
                    'family_structure': ($('#family-structure input:checked').val() === 'outro') ? ucfirst($(
                        '#family-structure-other').val()) : $('#family-structure input:checked').val(),
                    'family_workers': ($('#family-workers input:checked').val() === 'outro') ? ucfirst($(
                        '#family-workers-other').val()) : $('#family-workers input:checked').val(),
                    'workload': ($('#workload input:checked').val() === 'outro') ? ucfirst($('#workload-other')
                        .val()) : $('#workload input:checked').val(),
                    'speaks_japanese': ($('#speaks-japanese input:checked').val() === 'outro') ? ucfirst($(
                        '#speaks-japanese-other').val()) : $('#speaks-japanese input:checked').val(),
                    'studies_at_home': ($('#studies-at-home input:checked').val() === 'outro') ? ucfirst($(
                        '#studies-at-home-other').val()) : $('#studies-at-home input:checked').val(),
                    'will_return_to_home_country': ($('#will-return-to-home-country input:checked').val() ===
                        'outro') ? ucfirst($('#will-return-to-home-country-other').val()) : $(
                        '#will-return-to-home-country input:checked').val(),
                    'home_language': $('#home-language-value').val(),
                    'student_name': $('#student-name').val(),
                    'student_class': $('#student-class').val(),
                    'student_language': $('#student-language').val(),
                    'student_japan_arrival': $('#student-japan-arrival select').val(),
                    'student_is_shy': ($('#student-is-shy input:checked').val() === 'outro') ? ucfirst($(
                        '#student-is-shy-other').val()) : $('#student-is-shy input:checked').val(),
                    'student_time_alone': ($('#student-time-alone input:checked').val() === 'outro') ? ucfirst(
                            $(
                                '#student-time-alone-other').val()) : $('#student-time-alone input:checked')
                        .val(),
                    'student_rotine': ucfirst($('#student-rotine textarea').val()),
                    'student_extra_activities': ucfirst($('#student-extra-activities textarea').val()),
                    'student_is_focused': ($('#student-is-focused input:checked').val() === 'outro') ? ucfirst(
                            $(
                                '#student-is-focused-other').val()) : $('#student-is-focused input:checked')
                        .val(),
                    'student_is_organized': ($('#student-is-organized input:checked').val() === 'outro') ?
                        ucfirst(
                            $('#student-is-organized-other').val()) : $('#student-is-organized input:checked')
                        .val(),
                    'student_has_good_memory': ($('#student-has-good-memory input:checked').val() === 'outro') ?
                        ucfirst($('#student-has-good-memory-other').val()) : $(
                            '#student-has-good-memory input:checked').val(),
                    'student_has_a_study_plan': ($('#student-has-a-study-plan input:checked').val() ===
                            'outro') ?
                        ucfirst($('#student-has-a-study-plan-other').val()) : $(
                            '#student-has-a-study-plan input:checked').val(),
                    'student_reviews_exams': ($('#student-review-tests input:checked').val() === 'outro') ?
                        ucfirst(
                            $('#student-review-tests-other').val()) : $('#student-review-tests input:checked')
                        .val(),
                    'student_reads': ($('#student-reads input:checked').val() === 'outro') ? ucfirst($(
                        '#student-reads-other').val()) : $('#student-reads input:checked').val(),
                    'student_studies': ($('#student-studies input:checked').val() === 'outro') ? ucfirst($(
                        '#student-studies-other').val()) : $('#student-studies input:checked').val(),
                    'student_watches_tv': ucfirst($('#student-watches-tv textarea').val()),
                    'student_uses_internet': ucfirst($('#student-uses-internet textarea').val()),
                    'student_has_smartphone': ($('#student-has-smartphone input:checked').val() === 'outro') ?
                        ucfirst($('#student-has-smartphone-other').val()) : $(
                            '#student-has-smartphone input:checked').val(),
                    'kokugo_grade': $('input[name="kokugo-grade"]:checked').val(),
                    'shakai_grade': $('input[name="shakai-grade"]:checked').val(),
                    'sansuu_grade': $('input[name="sansuu-grade"]:checked').val(),
                    'rika_grade': $('input[name="rika-grade"]:checked').val(),
                    'eigo_grade': $('input[name="eigo-grade"]:checked').val(),
                    'student_has_difficult': $('#student-has-difficult-value').val(),
                    'student_difficult_in_class': ucfirst($('#student-difficult-in-class textarea').val()),
                    'student_frequency_in_support_class': ($(
                            '#student-frequency-in-support-class input:checked')
                        .val() === 'outro') ? ucfirst($('#student-frequency-in-support-class-other')
                        .val()) : $(
                        '#student-frequency-in-support-class input:checked').val(),
                    'student_will_take_entrance_exams': ($('#student-will-take-entrance-exames input:checked')
                            .val() === 'outro') ? ucfirst($('#student-will-take-entrance-exames-other').val()) :
                        $(
                            '#student-will-take-entrance-exames input:checked').val(),
                    'student_has_taken_online_classes': ($('#student-has-taken-online-classes input:checked')
                            .val() === 'outro') ? ucfirst($('#student-has-taken-online-classes-other').val()) :
                        $(
                            '#student-has-taken-online-classes input:checked').val(),
                    'guardian_expectations': ucfirst($('#guardian-expectations textarea').val()),
                    'guardian_motivations': ucfirst($('#guardian-motivations textarea').val()),
                    'guardian_concerns': ucfirst($('#guardian-concerns textarea').val()),
                };

                $.ajax({
                    type: "POST",
                    url: "/preRegistration",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {} else {
                            var errors = '';

                            $.each(response.errors, function(index, error) {
                                errors += error + '\n';
                            });

                            Toastify({
                                text: errors,
                                duration: 3000,
                                gravity: "top",
                                position: "left",
                                stopOnFocus: true,
                                style: {
                                    background: "#E02E3F",
                                    fontFamily: "Roboto, sans-serif",
                                },
                            }).showToast();
                        }
                    }
                });
            }


            finalInfo.hide();
            thanks.show();
            finalInfoTab.removeClass('active');
            thanksTab.addClass('active');
            scrollToTop();
        });

        function validateStudentGrades() {
            let hasError = false;

            // $('.inline-radios-separator').each(function() {
            //     const radios = $(this).find('input[type="radio"]');
            //     const radioSelected = radios.is(':checked');

            //     if (!radioSelected) {
            //         hasError = true;
            //         $(this).addClass('error');
            //     } else {
            //         $(this).removeClass('error');
            //     }
            // });

            const formCard = $('#student-grades');
            if (hasError) {
                formCard.addClass('error');
                const warningMessage = formCard.find('.student-grades-warning');
                warningMessage.show();
                setTimeout(function() {
                    warningMessage.hide();
                    formCard.removeClass('error');
                }, 3000);

                $('html, body').animate({
                    scrollTop: formCard.offset().top
                }, 1000);
            } else {
                formCard.removeClass('error');
                return true;
            }
        }

        var thanksTab = $('#thanks-tab');
        var thanks = $('#thanks');
        var success = $('#success');
        var thanksPrev = $('#thanks-prev');
        var thanksNext = $('#thanks-next');


        thanksPrev.click(function() {
            thanks.hide();
            finalInfo.show();
            thanksTab.removeClass('active');
            finalInfoTab.addClass('active');
            scrollToTop();
        });

        thanksNext.click(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data = {
                'study_plan': $('#study-plan').val(),
                'guardian_name': $('#guardian-name').val(),
                'guardian_email': $('#guardian-email').val(),
                'guardian_phone': $('#guardian-phone').val(),
                'zipcode': $('#zipcode').val(),
                'province': $('#province').val(),
                'city': $('#city').val(),
                'district': $('#district').val(),
                'address': $('#address').val(),
                'complement': $('#complement').val(),
                'japan_time': $('#japan-time').val(),
                'children': $('#children').val(),
                'family_structure': ($('#family-structure input:checked').val() === 'outro') ? ucfirst($(
                    '#family-structure-other').val()) : $('#family-structure input:checked').val(),
                'family_workers': ($('#family-workers input:checked').val() === 'outro') ? ucfirst($(
                    '#family-workers-other').val()) : $('#family-workers input:checked').val(),
                'workload': ($('#workload input:checked').val() === 'outro') ? ucfirst($('#workload-other')
                    .val()) : $('#workload input:checked').val(),
                'speaks_japanese': ($('#speaks-japanese input:checked').val() === 'outro') ? ucfirst($(
                    '#speaks-japanese-other').val()) : $('#speaks-japanese input:checked').val(),
                'studies_at_home': ($('#studies-at-home input:checked').val() === 'outro') ? ucfirst($(
                    '#studies-at-home-other').val()) : $('#studies-at-home input:checked').val(),
                'will_return_to_home_country': ($('#will-return-to-home-country input:checked').val() ===
                    'outro') ? ucfirst($('#will-return-to-home-country-other').val()) : $(
                    '#will-return-to-home-country input:checked').val(),
                'home_language': $('#home-language-value').val(),
                'student_name': $('#student-name').val(),
                'student_class': $('#student-class').val(),
                'student_language': $('#student-language').val(),
                'student_japan_arrival': $('#student-japan-arrival select').val(),
                'student_is_shy': ($('#student-is-shy input:checked').val() === 'outro') ? ucfirst($(
                    '#student-is-shy-other').val()) : $('#student-is-shy input:checked').val(),
                'student_time_alone': ($('#student-time-alone input:checked').val() === 'outro') ? ucfirst($(
                    '#student-time-alone-other').val()) : $('#student-time-alone input:checked').val(),
                'student_rotine': ucfirst($('#student-rotine textarea').val()),
                'student_extra_activities': ucfirst($('#student-extra-activities textarea').val()),
                'student_is_focused': ($('#student-is-focused input:checked').val() === 'outro') ? ucfirst($(
                    '#student-is-focused-other').val()) : $('#student-is-focused input:checked').val(),
                'student_is_organized': ($('#student-is-organized input:checked').val() === 'outro') ? ucfirst(
                        $('#student-is-organized-other').val()) : $('#student-is-organized input:checked')
                    .val(),
                'student_has_good_memory': ($('#student-has-good-memory input:checked').val() === 'outro') ?
                    ucfirst($('#student-has-good-memory-other').val()) : $(
                        '#student-has-good-memory input:checked').val(),
                'student_has_a_study_plan': ($('#student-has-a-study-plan input:checked').val() === 'outro') ?
                    ucfirst($('#student-has-a-study-plan-other').val()) : $(
                        '#student-has-a-study-plan input:checked').val(),
                'student_reviews_exams': ($('#student-review-tests input:checked').val() === 'outro') ? ucfirst(
                        $('#student-review-tests-other').val()) : $('#student-review-tests input:checked')
                    .val(),
                'student_reads': ($('#student-reads input:checked').val() === 'outro') ? ucfirst($(
                    '#student-reads-other').val()) : $('#student-reads input:checked').val(),
                'student_studies': ($('#student-studies input:checked').val() === 'outro') ? ucfirst($(
                    '#student-studies-other').val()) : $('#student-studies input:checked').val(),
                'student_watches_tv': ucfirst($('#student-watches-tv textarea').val()),
                'student_uses_internet': ucfirst($('#student-uses-internet textarea').val()),
                'student_has_smartphone': ($('#student-has-smartphone input:checked').val() === 'outro') ?
                    ucfirst($('#student-has-smartphone-other').val()) : $(
                        '#student-has-smartphone input:checked').val(),
                'kokugo_grade': $('input[name="kokugo-grade"]:checked').val(),
                'shakai_grade': $('input[name="shakai-grade"]:checked').val(),
                'sansuu_grade': $('input[name="sansuu-grade"]:checked').val(),
                'rika_grade': $('input[name="rika-grade"]:checked').val(),
                'eigo_grade': $('input[name="eigo-grade"]:checked').val(),
                'student_has_difficult': $('#student-has-difficult-value').val(),
                'student_difficult_in_class': ucfirst($('#student-difficult-in-class textarea').val()),
                'student_frequency_in_support_class': ($('#student-frequency-in-support-class input:checked')
                    .val() === 'outro') ? ucfirst($('#student-frequency-in-support-class-other').val()) : $(
                    '#student-frequency-in-support-class input:checked').val(),
                'student_will_take_entrance_exams': ($('#student-will-take-entrance-exames input:checked')
                    .val() === 'outro') ? ucfirst($('#student-will-take-entrance-exames-other').val()) : $(
                    '#student-will-take-entrance-exames input:checked').val(),
                'student_has_taken_online_classes': ($('#student-has-taken-online-classes input:checked')
                    .val() === 'outro') ? ucfirst($('#student-has-taken-online-classes-other').val()) : $(
                    '#student-has-taken-online-classes input:checked').val(),
                'guardian_expectations': ucfirst($('#guardian-expectations textarea').val()),
                'guardian_motivations': ucfirst($('#guardian-motivations textarea').val()),
                'guardian_concerns': ucfirst($('#guardian-concerns textarea').val()),
            };

            $.ajax({
                type: "POST",
                url: "/preRegistration",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        thanks.hide();
                        success.show();
                    } else {
                        var errors = '';

                        $.each(response.errors, function(index, error) {
                            errors += error + '\n';
                        });

                        Toastify({
                            text: errors,
                            duration: 3000,
                            gravity: "top",
                            position: "left",
                            stopOnFocus: true,
                            style: {
                                background: "#E02E3F",
                                fontFamily: "Roboto, sans-serif",
                            },
                        }).showToast();
                    }
                }
            });
        });

        function ucfirst(str) {
            if (typeof str === 'string' && str.length > 0) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
            return ''; // Return an empty string or handle the case as needed
        }
    </script>
</footer>
