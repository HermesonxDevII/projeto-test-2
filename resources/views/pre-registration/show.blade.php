@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Responsável Selecionado
@endsection

@section('content')
    <style>
        .pb-20 {
            padding: 0px 0px 20px 0px !important;
        }

        .pt-20 {
            padding: 20px 0px 0px 0px !important;
        }

        .dotted-gray-bb {
            border-bottom: 1px dotted #D1D4D5;
            ;
        }

        .pre-registration-card {
            padding: 44px 40px 40px 40px !important;
        }

        .pre-registration-tab {
            height: 39px;
            padding-bottom: 15px;
            margin-right: 19px;
            color: var(--colors-neutral-gray-80, #767F82);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 24px;
        }

        .pre-registration-tab:hover {
            cursor: pointer;
            border-bottom: 2px solid var(--colors-primary-500, #329FBA);
            color: var(--colors-primary-500, #485558);
        }

        .pre-registration-tab.active {
            border-bottom: 2px solid var(--colors-primary-500, #329FBA);
            color: var(--colors-primary-500, #485558);
        }

        .pre-registration-page {
            padding-top: 35px;
            display: flex;
            flex-direction: column;
            display: none;
        }

        .pre-registration-title {
            color: var(--colors-neutral-gray, #1B2A2E);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 24px;
        }

        .pre-registration-question-wrapper {
            padding: 15px 0px 30px 0px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 50%;
        }

        .pre-registration-question {
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
        }

        .pre-registration-answer {
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .mt-15 {
            margin-top: 15px !important;
        }

        .grades-title {
            color: var(--colors-neutral-gray-80, #485558);
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 20px;
        }

        .grades-value {
            color: var(--colors-brand-primary-darker, #329FBA);
            text-align: right;
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .mb-5 {
            margin-bottom: 5px !important;
        }

        .pr-20 {
            padding-right: 20px !important;
        }

        .g-0 {
            gap: 0px !important;
        }

        .mb-10 {
            margin-bottom: 10px !important;
        }

        .approve-btn {
            border-radius: 10px;
            background: var(--colors-support-success-darker, #357E3E);
            box-shadow: 0px 6px 10px 0px rgba(23, 108, 130, 0.24);
            color: #FFF;
            text-align: center;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
        }
    </style>
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">

        <div style="width: 100%; margin-bottom: 30px;
                align-items: center;" class="row">
            <div class="col">
                <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">Respostas do Questionário</h1>
            </div>

            <div class="col" style="text-align: end;">
                @can('admin')
                    @if ($preRegistration->student_id == null)
                        <a href="{{ route('preRegistration.approve', $preRegistration->id) }}">
                            <button class="btn approve-btn" style="width: 118px; height: 40px;">
                                <span class="text-white">Aprovar Aluno</span>
                            </button>
                        </a>
                    @else
                        <button class="btn approve-btn" style="width: 118px; height: 40px;" disabled>
                            <span class="text-white">Aluno aprovado!</span>
                        </button>
                    @endif
                @endcan
                <button class="btn bg-primary btn-shadow text-white m-1" onclick="history.back();"
                    style="width: 136px; height: 40px;">
                    Voltar
                </button>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body pt-10 pb-9">
                @can('admin')
                    <div class="container-fluid pb-20 dotted-gray-bb">
                        <div class="row classroom-info">
                            <div class="col-6 col-md-3">
                                <span class="sub-title">Nome do Responsável</span>
                                <span class="subtitle-info">{{ $preRegistration->guardian_name }}</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <span class="sub-title">Telefone</span>
                                <span class="subtitle-info">{{ $preRegistration->guardian_phone }}</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <span class="sub-title">Endereço Completo</span>
                                <span class="subtitle-info">{{ $preRegistration->zipcode }}, {{ $preRegistration->province }},
                                    {{ $preRegistration->city }},
                                    {{ $preRegistration->district }}, {{ $preRegistration->address }},
                                    {{ $preRegistration->complement }}</span>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="container-fluid @can('admin') pt-20 @endcan">
                    <div class="row classroom-info">
                        <div class="col-6 col-md-3">
                            <span class="sub-title">Nome do Aluno</span>
                            <span class="subtitle-info">{{ $preRegistration->student_name }}</span>
                        </div>
                        @if (!is_null($preRegistration->study_plan))
                            <div class="col-6 col-md-3">
                                <span class="sub-title">Plano de estudo selecionado</span>
                                <span
                                    class="subtitle-info">{{ str_replace(
                                        ['Japanese', 'English'],
                                        ['Japonês', 'Aulas de Inglês'],
                                        $preRegistration->study_plan
                                    ) }}</span>
                            </div>
                        @endif

                        <div class="col-6 col-md-3">
                            <span class="sub-title">Série</span>
                            <span class="subtitle-info">{{ $preRegistration->student_class }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-5 ">
            <div class="card-body pre-registration-card">
                <div class="container-fluid p-0">
                    <div class="d-flex">
                        <div id="guardian-info-tab" class="pre-registration-tab">
                            Infos. Responsável
                        </div>
                        <div id="student-info-tab" class="pre-registration-tab">
                            Dados do aluno
                        </div>
                        <div id="final-info-tab" class="pre-registration-tab">
                            Outras informações
                        </div>
                    </div>
                    <div id="guardian-info-page" class="pre-registration-page">
                        <span class="pre-registration-title">Informações do responsável</span>
                        <div class="d-flex dotted-gray-bb mt-15">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Como é sua estrutura familiar?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->family_structure }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Quem compõe a renda da sua família?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->family_workers }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Quanto tempo moram no Japão?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->japan_time }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Quantos filho(as) você tem?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->children }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Qual sua carga horária de trabalho?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->workload }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Sabe falar o Japonês?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->speaks_japanese }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Qual idioma você se comunica com seu filho(a) em
                                    casa?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->home_language }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Você reserva um tempo do seu dia para sentar ao lado
                                    do seu filho(a) para estudar?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->studies_at_home }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Pretendem retornar para o seu país de origem?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->will_return_to_home_country }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Empresa que trabalha</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->work_company }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="student-info-page" class="pre-registration-page">
                        <span class="pre-registration-title">Dados do Aluno</span>
                        <div class="d-flex dotted-gray-bb mt-15">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Com quantos anos seu filho(a) chegou no
                                    Japão?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_japan_arrival }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Qual idioma seu filho(a) domina mais?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_language }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Seu filho é tímido?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_is_shy }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Quanto tempo seu filho(a) fica em casa sozinho(a)
                                    depois que volta da escola?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_time_alone }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">O que seu filho(a) faz em casa?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_rotine }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Seu filho(a) faz alguma atividade
                                    extracurricular?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_extra_activities }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">✏️ Seu filho(a) tem foco e concentração?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_is_focused }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">✏️ Seu filho(a) é organizado?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_is_organized }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">✏️ Seu filho(a) tem boa memória?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_has_good_memory }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">✏️ Seu filho(a) tem um planejamento de
                                    estudos?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_has_a_study_plan }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">✏️ Seu filho(a) revisa as provas?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_reviews_exams }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">📖 Seu filho(a) tem o hábito de ler livros?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_reads }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">✏️ Seu filho(a) sabe como estudar?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_studies }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">O que seu filho(a) consome de TV? 📺</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_watches_tv }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">O que seu filho(a) consome na Internet?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_uses_internet }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Seu filho(a) tem celular?📱</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_has_smartphone }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="final-info-page" class="pre-registration-page">
                        <span class="pre-registration-title">Outras Informações</span>
                        <div class="d-flex dotted-gray-bb mt-15">
                            <div class="pre-registration-question-wrapper g-0 pr-20">
                                <span class="pre-registration-question mb-10">Como está as notas do seu filho(a) em cada
                                    matéria?</span>
                                <div class="d-flex justify-content-between mb-5">
                                    <span class="grades-title">Kokugo / Língua Nacional do Japão:</span>
                                    <span class="grades-value">{{ $preRegistration->kokugo_grade }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-5">
                                    <span class="grades-title">Shakai / Estudos Sociais:</span>
                                    <span class="grades-value">{{ $preRegistration->shakai_grade }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-5">
                                    <span class="grades-title">Sansuu / Suugaku: Matemática:</span>
                                    <span class="grades-value">{{ $preRegistration->sansuu_grade }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-5">
                                    <span class="grades-title">Rika / Ciência:</span>
                                    <span class="grades-value">{{ $preRegistration->sansuu_grade }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-5">
                                    <span class="grades-title">Eigo / Gaikokugo: Inglês:</span>
                                    <span class="grades-value">{{ $preRegistration->eigo_grade }}</span>
                                </div>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Em quais matérias seu filho(a) tem mais
                                    dificuldades?</span>
                                <span class="pre-registration-answer">{{ $preRegistration->student_has_difficult }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Quais os maiores problemas/dificuldades que seu
                                    filho(a) está enfrentando nos estudos da escola japonesa?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_difficult_in_class }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Seu filho(a) frequenta alguma sala de apoio na
                                    escola japonesa?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_frequency_in_support_class }}</span>
                            </div>
                        </div>
                        <div class="d-flex dotted-gray-bb">
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Seu filho(a) quer prestar o vestibular para o
                                    Koukou?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_will_take_entrance_exams }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Seu filho já estudou através de aulas
                                    online?</span>
                                <span
                                    class="pre-registration-answer">{{ $preRegistration->student_has_taken_online_classes }}</span>
                            </div>
                        </div>
                        <div class="d-flex @if (is_null($preRegistration->study_plan)) dotted-gray-bb @endif">
                            <div class="pre-registration-question-wrapper">
                                @if (!is_null($preRegistration->study_plan))
                                    <span class="pre-registration-question">O que precisa acontecer nos estudos do seu
                                        filho(a)
                                        nos próximos 6 meses para você dizer que valeu a pena investir nas Aulas Semanais da
                                        Melis Education? </span>
                                @else
                                    <span class="pre-registration-question">O que precisa acontecer nos estudos do seu
                                        filho nos próximos meses para você dizer que valeu a pena investir no Programa
                                        M.A.E? </span>
                                @endif
                                <span class="pre-registration-answer">{{ $preRegistration->guardian_expectations }}</span>
                            </div>
                            <div class="pre-registration-question-wrapper">
                                <span class="pre-registration-question">Gostaria de compartilhar algum acontecimento ou
                                    preocupação? </span>
                                <span class="pre-registration-answer">{{ $preRegistration->guardian_concerns }}</span>
                            </div>
                        </div>
                        @if (!is_null($preRegistration->guardian_motivations))
                            <div class="d-flex">
                                <div class="pre-registration-question-wrapper">
                                    <span class="pre-registration-question">⁠Por que você decidiu comprar o Programa M.A.E? </span>
                                    <span class="pre-registration-answer">{{ $preRegistration->guardian_motivations }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{ asset('js/guardians/forms/guardian_edit.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/guardians/forms/guardian_shared.js') }}?version={{ getAppVersion() }}"></script>
    <script src="{{ asset('js/guardians/show.js') }}?version={{ getAppVersion() }}"></script>

    <script>
        $(document).ready(function() {
            // Ativa a primeira aba por padrão
            $("#guardian-info-tab").addClass("active");
            $("#guardian-info-page").show();

            // Manipula o clique nas abas
            $(".pre-registration-tab").click(function() {
                // Remove a classe 'active' de todas as abas
                $(".pre-registration-tab").removeClass("active");

                // Oculta todas as páginas de informações
                $(".pre-registration-page").hide();

                // Obtém o ID da aba clicada e constrói o ID da página correspondente
                var tabId = $(this).attr("id");
                var pageId = tabId.replace("-tab", "-page");

                // Adiciona a classe 'active' à aba clicada
                $(this).addClass("active");

                // Exibe a página correspondente à aba clicada
                $("#" + pageId).show();
            });
        });
    </script>
@endsection
