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
            width: 933px;
            min-height: auto;
            height: auto;
            border-radius: 24px;
            background: #FFF;
            box-shadow: 0px -3px 37.4px 0px rgba(50, 159, 186, 0.14);
            padding: 30px;
            align-items: center;
            margin: 0 auto;
            box-sizing: border-box;
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
            margin-top: 20px;
            margin-bottom: 40px;
            width: 240px;
            height: auto;
        }

        .melis-logo-mobile {
            width: auto;
            height: 36px;
        }

        #province {
                width: 539px; /* Largura padrão para telas maiores */
                max-width: 100%; /* Garante que não ultrapasse a largura do contêiner */
            }

            @media (max-width: 600px) { /* Ajuste para telas menores (tablets e celulares) */
                #province {
                    width: 259px;
                }
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
            margin-bottom: 40px;
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

        .success-btn {           
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
            padding: 0px 20px 0px 20px;
        }

        .success-btn:hover {
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

        .mt-20 {
            margin-top: 20px;
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
            width: 259px;
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
        .gap-20 {
            gap: 20px;
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

            .qqq {
                color: #0058fc;
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto, sans-serif;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 20px;
                margin-bottom: 50px;
                max-width: 300px;
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
    <img class="blue-elipse" src="{{ asset('images/elipse.png') }}">
    <div class="container">

        <div class="card">
            <div id="form-pre-registration" style="padding: 0px 0px 0px 20px;">
                <div class="header">
                    <img class="melis-logo" src="{{ asset('images/logo2-melis@2x.png') }}" alt="Logo da Melis Education">
                </div>
                <div id="welcome" class="d-flex flex-column page">
                    <span class="title mb-29">Seja bem vindo a Melis GakuLab!</span>
                    <span class="content">
                        O laboratório de estudos que vai transformar o aprendizado do seu filho na escola japonesa!
                        <br>
                        <br>
                        Você ganhou 30 dias de acesso a todas as matérias que seu filho estuda na escola japonesa para conhecer a plataforma e o conteúdo gratuitamente.
                        <br>
                        <br>
                        Preencha as informações a seguir e aproveitem!                    
                    </span>
                </div>
                <div id="guardian-1" class="d-flex flex-column page">
                    <div class="inputs @desktop mb-20 @enddesktop">
                        <div class="d-flex gap-20 @mobile
                            flex-column
                            @endmobile">
                            <div>
                                <label for="guardian-name">
                                    👨‍👩‍👧‍👦 Nome completo da mãe ou pai <span class="red">*</span>
                                </label>
                                <input id="guardian-name" type="text" name="guardian-name"
                                    placeholder="Insira seu nome" required>
                                <span class="guardian-name-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>                        
                            <div>
                                <label for="guardian-phone">
                                    ☎️ Número de telefone para contato <span class="red">*</span>
                                </label>
                                <input id="guardian-phone" type="text" name="guardian-phone"
                                    placeholder="Insira o número" required>
                                <span class="guardian-phone-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>
                            <div>
                                <label for="guardian-email">
                                    ✉️ Seu e-mail (irá receber o acesso) <span class="red">*</span>
                                </label>
                                <input id="guardian-email" type="email" name="guardian-email"
                                    placeholder="Insira seu melhor e-mail" required>
                                <span class="guardian-email-error error-message warning" style="visibility: hidden;">E-mail inválido</span>
                            </div>
                        </div>
                        <div
                            class="d-flex gap-20 mb-5 mt-20 @mobile flex-column @endmobile">
                            <div style="flex: 1;">
                                <label for="province">
                                    Qual província vocês moram? (Exemplo: Shizuoka-ken Hamamatsu-shi)<span class="red">*</span>
                                </label>
                                <input id="province" type="text" name="province" required>
                                <span class="province-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>
                            <div style="flex: 1;">
                                <label for="work_company">
                                    Empreiteira que trabalha <span class="red">*</span>
                                </label>
                                <input id="work_company" type="text" name="work_company" placeholder="Nome da Empreiteira" required>
                                <span class="work_company-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="student" class="d-flex flex-column page" >
                    <div class="inputs mb-57">
                        <div class="d-flex @mobile
                            flex-column
                            @endmobile gap-20">
                            <div>
                                <label for="student-name">
                                    Nome do aluno <span class="red">*</span>
                                </label>
                                <input id="student-name" type="text" name="student-name"
                                    placeholder="Insira o nome do aluno" required>
                                <span class="student-name-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>
                            <div>
                                <label for="student-class">
                                    Qual série seu filho(a) está? (selecione a série atual) <span class="red">*</span>
                                </label>
                                <select id="student-class" name="student-class" required>
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
                                <span class="student-class-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>
                            <div>
                                <label for="student-japan-arrival">
                                    Idade que seu filho(a) chegou no Japão? <span class="red">*</span>
                                </label>
            
                                <select id="student-japan-arrival" name="student-japan-arrival" required>
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
                                <span class="student-japan-arrival-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>                        
                        </div>
                        <div class="d-flex flex-column mt-20">
                            <div>
                                <label for="student-language">
                                    Idioma que domina mais? <span class="red">*</span>
                                </label>
                                <select id="student-language" name="student-language" required>
                                    <option value="">Selecione</option>
                                    <option value="Português">Português</option>
                                    <option value="Japonês">Japonês</option>
                                    <option value="Espanhol">Espanhol</option>
                                    <option value="Inglês">Inglês</option>
                                </select>
                                <span class="student-language-error error-message warning" style="visibility: hidden;">Preenchimento obrigatório</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="final-info" class="d-flex flex-column page">
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

                        <span class="student-has-difficult-warning warning" style="visibility: hidden;">Preenchimento
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
                </div>
                <div class="btns-wrapper mt-20">
                    <button id="final-info-next" class="next-btn">Enviar</button>
                </div>
            </div>
            <div id="success" class="d-flex flex-column align-items-center justify-content-center" style="display:none;min-height: 100vh;text-align: center;">
                <div class="header" style="margin-bottom: 50px;">
                    <img class="melis-logo" src="{{ asset('images/logo2-melis@2x.png') }}" alt="Logo da Melis Education">
                </div>
                <img
                    src="{{ asset('images/icons/check-circle.png') }}">
                <span class="success-text ws-nowrap">
                    Inscrição feita com sucesso !
                </span>
                <span style="color: #606C83;font-feature-settings: 'clig' off, 'liga' off;font-family: Roboto, sans-serif;font-size: 14px;font-style: normal;font-weight: 400;line-height: 20px;margin-bottom: 100px;margin-top:30px;">
                    Você receberá no email informado no cadastro os dados de acesso gratuito por 30 dias em nossa plataforma
                </span>
                <div class="btns-wrapper">
                    <button id="success-home" class="success-btn">Visite o nosso site</button>
                </div>

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

        const phoneMaskOptions = {
            mask: '000-0000-0000'
        };

        const phoneMask = IMask(phoneInput, phoneMaskOptions);

        var tabs = $('.tab');
        var pages = $('.page');

        var welcomeTab = $('#welcome-tab');
        var welcome = $('#welcome');
        var welcomeNext = $('#welcome-next');

        var planTab = $('#plan-tab');
        var plan = $('#plan');
        var planPrev = $('#plan-prev');
        var planNext = $('#plan-next');

        var guardianTab = $('#guardian-tab');

        $("#success-home").click(function() {
            window.location.href = "/";
        });

        // Função para validar os campos
        function validateField(field) {
            var value = field.val().trim();
    
            // Validação para campo de texto
            if (field.is('input[type="text"], input[type="email"], select')) {
                return value !== '';
            }
            
            return true;
        }

        function updateErrorMessage(field, message) {            
            var errorMessage = $(field).siblings('.error-message');
            
            if (message) {                
                errorMessage.text(message).css('visibility', 'visible');

                setTimeout(function() {
                    errorMessage.css('visibility', 'hidden');
                    field.removeClass('error')
                }, 3000); 
            } else {
                errorMessage.css('visibility', 'hidden');
            }
        }

        function validateGuardianForm() {
            var inputs = $('#guardian-1 input[required]');
            var isValid = true;
            // Verifica cada campo
            inputs.each(function() {
                var field = $(this);
                var errorMessage = null;
                
                // Valida o campo
                if (!validateField(field)) {
                field.addClass('error'); // Adiciona a classe de erro

                // Atualiza a mensagem de erro para o campo específico
                if (field.attr('id') === 'guardian-email') {
                    errorMessage = 'E-mail inválido';
                } else {
                    errorMessage = 'Preenchimento obrigatório';
                }

                isValid = false; // Marca o formulário como inválido
                } else {
                field.removeClass('error'); // Remove a classe de erro
                }

                // Atualiza a visibilidade da mensagem de erro
                updateErrorMessage(field, errorMessage);
            });

            return isValid;
        }

        function validateStudentForm() {            
            var inputs = $('#student input[required], #student select[required]');
            var isValid = true;
            // Verifica cada campo
            inputs.each(function() {
                var field = $(this);
                var errorMessage = null;
                
                // Valida o campo
                if (!validateField(field)) {
                    field.addClass('error'); // Adiciona a classe de erro

                    if (field.attr('id') === 'student-name') {
                        errorMessage = 'Preenchimento obrigatório';          
                    } else if (field.attr('id') === 'student-class') {
                        errorMessage = 'Preenchimento obrigatório';                        
                    } else {
                        errorMessage = 'Preenchimento obrigatório';
                    }

                    isValid = false; // Marca o formulário como inválido
                } else {
                    field.removeClass('error'); // Remove a classe de erro                    
                }

                console.log(errorMessage)
                // Atualiza a visibilidade da mensagem de erro
                updateErrorMessage(field, errorMessage);
            });

            return isValid;
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

        var finalInfoNext = $('#final-info-next');
        var success = $('#success');
        var formPreregistration = $('#form-pre-registration');

        finalInfoNext.click(function() {

            if (!validateGuardianForm()) {
                // Rola até o primeiro campo inválido
                var firstInvalidField = $('#guardian-1 input.error')[0];
                if (firstInvalidField) {
                firstInvalidField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest'
                });
                }
                return; // Impede o envio do formulário
            }

            if (!validateStudentForm()) {                
                // Rola até o primeiro campo inválido
                var firstInvalidField = $('#student input.error')[0];
                if (firstInvalidField) {
                firstInvalidField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest'
                });
                }
                return; // Impede o envio do formulário
            }

            if (!validateCheckboxGroup($('#student-has-difficult .radio-inputs'))) {
                showError($('#student-has-difficult'), $('.student-has-difficult-warning'));
                return;
            }

            if (!validateTextareaField($('#student-difficult-in-class textarea'))) {
                showError($('#student-difficult-in-class'), $('.student-difficult-in-class-warning'));
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data = {
                'guardian_name': $('#guardian-name').val(),
                'guardian_email': $('#guardian-email').val(),
                'guardian_phone': $('#guardian-phone').val(),
                'province': $('#province').val(),
                'work_company': $('#work_company').val(),
                'student_name': $('#student-name').val(),
                'student_class': $('#student-class').val(),
                'student_language': $('#student-language').val(),
                'student_japan_arrival': $('#student-japan-arrival').val(),
                'student_has_difficult': $('#student-has-difficult-value').val(),
                'student_difficult_in_class': ucfirst($('#student-difficult-in-class textarea').val()),
            };

            $.ajax({
                type: "POST",
                url: "/gakulab-30dias",
                data: data,
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    if (response.status === 'success') {
                        formPreregistration.fadeOut(400, function () {
                            success.fadeIn(500, function() {
                                $('html, body').animate({
                                    scrollTop: successDiv.offset().top - 100
                                }, 600);
                            });
                        });
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
