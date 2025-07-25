<div id="kt_header" class="header align-items-stretch pt-4">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="d-flex align-items-center d-lg-none" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <img src="{{ asset('images/icons/sidebar-menu.png') }}" alt="" />
            </div>
        </div>

        {{-- begin:: Mobile --}}
        <div>
            <a href="{{ route('dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('images/melis-education-horizontal.png') }}" class="mobile-logo" />
            </a>
        </div>
        {{-- end:: Mobile --}}

        {{-- begin:: Desktop --}}
        @desktop
            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                <div class="d-flex align-items-stretch" id="kt_header_nav">
                    <div
                        class="header-menu align-items-stretch"
                        data-kt-drawer="true"
                        data-kt-drawer-name="header-menu"
                        data-kt-drawer-activate="{default: true, lg: false}"
                        data-kt-drawer-overlay="true"
                        data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                        data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_header_menu_mobile_toggle"
                        data-kt-swapper="true"
                        data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}"
                    >
                        <div
                            class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                            id="#kt_header_menu"
                            data-kt-menu="true"
                        >
                            <div
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start"
                                class="menu-item menu-lg-down-accordion me-lg-1"
                            >
                                @include('layouts.header.searchbox')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex main-header-menu">
                    @can('guardian')

                        {{-- begin:: Help Circle Classroom --}}
                        @if (str_contains(Route::current()->getName(), 'classrooms') || str_contains(Route::current()->getName(), 'dashboard'))
                            <div class="mr-4 navbar-item onb-modal-box" onclick="showOnbClassroomModal()"> 
                                <button class="btn onb-modal-btn">
                                    <img src="{{ asset('images/icons/help-circle.svg') }}" alt="">
                                </button>
                            </div>
                        @endif
                        {{-- end:: Help Circle Classromm --}}

                        {{-- Help Circle Video-Courses --}}
                        @if (str_contains(Route::current()->getName(), 'video-courses'))
                            <div class="mr-4 navbar-item onb-modal-box" onclick="showOnbCourseModal()">
                                <button class="btn onb-modal-btn">
                                    <img src="{{ asset('images/icons/help-circle.svg') }}" alt="">
                                </button>
                            </div>
                        @endif
                        {{-- Help Circle Video-Courses --}}

                    @endcan

                    {{-- begin:: Messages --}}
                    <div
                        class="d-flex align-items-stretch flex-shrink-0"
                        id="chat-notification-wrapper"
                        onclick="toggleChatDropdown()"
                    >
                        <div class="mr-4 navbar-item message-notification-box">
                            <button class="btn message-notification-btn">
                                <img
                                    src="{{ asset('images/icons/message.svg') }}"
                                    height="25"
                                    width="25"
                                />
                            </button>
                            <span class="badge badge-pill badge-danger bubble-counter d-none" id="chat-message-counter">0</span>
                        </div>

                        <div class="d-none btn-shadow chat-dropdown" id="chat-dropdown">
                            <div class="message-notification-dropdown" data-kt-menu="true">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2 class="m-0 fs-5 fw-bold">Chat</h2>
                                    <button class="btn btn-sm btn-icon message-notification-expand" id="expand-chat-button">
                                        <img
                                            src="{{ asset('images/icons/expand-icon.svg') }}"
                                            alt="Expand"
                                            width="20px"
                                            height="20px"
                                        >
                                    </button>
                                </div>

                                <div class="chat-list" id="chat-messages-container"></div>

                                <a
                                    href="{{ route('chats.index') }}"
                                    class="d-block text-center mt-3"
                                    id="view-all-chats-button"
                                >Ver todas</a>
                            </div>
                        </div>
                    </div>
                    {{-- end:: Messages --}}

                    @can('guardian')

                        {{-- begin:: Languages --}}
                        <div class="navbar-item me-4" style="border-radius: 12px;">
                            <div class="dropdown language-select" data-route="{{ route('students.switchLanguage') }}">
                                <button
                                    class="btn dropdown-toggle h-55px w-55px bg-white"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <img
                                        src='{{ asset('images/flags/' . selectedStudent()->system_language->short_name . '.svg') }}'
                                        alt="image"
                                        width="24px"
                                        height="15px"
                                    />
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end px-1">
                                    @foreach (getLanguages() as $i => $lang)
                                        <li>
                                            <a
                                                class="dropdown-item cursor-pointer px-3 rounded {{ $i != 0 ? 'mt-2' : '' }}"
                                                data-value="{{ $lang->id }}"
                                            >
                                                <img
                                                    src='{{ asset("images/flags/{$lang->short_name}.svg") }}'
                                                    alt="{{ $lang->short_name }}"
                                                    width="24px"
                                                    height="15px"
                                                >
                                                <span class="fs-7 fw-bolder ms-2">{{ $lang->original_name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{-- end:: Languages --}}

                    @else
                        <div></div>
                    @endcan

                    {{-- begin:: User Options --}}
                    <div
                        onclick="$('#notification-dropdown').addClass('d-none')"
                        class="d-flex align-items-stretch flex-shrink-0 navbar-item"
                        id="user-options"
                        data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end"
                    >
                        <div class="align-middle" id="user-name">
                            @guest()
                                <span>User</span>
                            @else
                                @php
                                    $user = Auth::user();
                                @endphp

                                @canany(['admin', 'teacher'])
                                    {{ $user->firstName }}
                                @elsecanany(['guardian'])
                                    @if ($user->studentsCount > 0)
                                        @if (session()->get('student_nickname'))
                                            {{ session()->get('student_nickname') }}
                                        @else
                                            {{ session()->get('student_name') }}
                                        @endif
                                    @else
                                        {{ session()->get('student_nickname') }}
                                    @endif
                                    @if ($user->studentsCount == 0)
                                        {{ $user->firstName }}
                                    @endif
                                @endcanany
                            @endguest
                        </div>
                        <i class="fa-solid fa-angle-down"></i>

                        <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">

                            {{-- begin:: Profile Photo --}}
                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px">
                                @canany(['admin', 'teacher'])
                                    <img src="{{ url("storage/{$user->profile_photo}") }}" alt="user" />
                                @elsecanany(['guardian'])
                                    @if ($user->studentsCount > 0)
                                        @if (session()->get('student_avatar_id') == 0)
                                            <img src="{{ asset('storage/default.png') }}" alt="user" />
                                        @else
                                            <img src="{{ asset('images/avatars/avatar' . session()->get('student_avatar_id') . '.svg') }}" alt="user" />
                                        @endif
                                    @else
                                        <img src="{{ url("storage/{$user->profile_photo}") }}" alt="user" />
                                    @endif
                                @endcanany
                            </div>
                            {{-- end:: Profile Photo --}}

                            <div
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-1 fs-6"
                                data-kt-menu="true"
                                id="user-options-dropdown"
                            >

                                {{-- begin:: Profile Option --}}
                                <div class="menu-item p-2">
                                    <a href="{{ route('myProfile') }}" class="menu-link my-profile-button">
                                        <img
                                            src="{{ asset('images/icons/user.svg') }}"
                                            class="user-options-icon user-icon"
                                            alt="User Icon"
                                        />
                                        <span>{{ __('header-menu.my_profile') }}</span>
                                    </a>
                                </div>
                                {{-- end:: Profile Option --}}

                                {{-- begin:: Logout Option --}}
                                <div class="menu-item p-2">
                                    <a href="{{ route('logout') }}" class="menu-link logout-system">
                                        <img
                                            src="{{ asset('images/icons/power.svg') }}"
                                            class="user-options-icon logout-icon"
                                            alt="Logout Icon"
                                        />
                                        <span>{{ __('header-menu.logout') }}</span>
                                    </a>

                                    <form
                                        id="logout-form"
                                        action="{{ route('logout') }}"
                                        method="POST"
                                        class="d-none"
                                    >
                                        @csrf
                                    </form>
                                </div>
                                {{-- end:: Logout Option --}}
                            </div>
                        </div>
                    </div>
                    {{-- end:: User Options --}}

                </div>
            </div>
        @enddesktop
        {{-- end:: Desktop --}}

        {{-- begin:: Mobile --}}
        @desktop
        @elsedesktop
            <div class="d-flex align-items-center">
                @can('guardian')

                    {{-- begin:: Message --}}
                    <a href="{{ route('chats.index') }}" class="message-notification-box-mobile">
                        <div class="navbar-item message-notification-box me-2">
                            <button type="button" class="btn onb-modal-btn">
                                <img
                                    src="{{ asset('images/icons/message.svg') }}"
                                    height="30"
                                    width="30"
                                />
                            </button>
                            <span class="badge badge-pill badge-danger bubble-counter d-none" id="chat-message-counter">0</span>
                        </div>
                    </a>
                    {{-- end:: Message --}}

                    {{-- begin:: Languages --}}
                    <div class="navbar-item system-language-box">
                        <div class="dropdown language-select" data-route="{{ route('students.switchLanguage') }}">
                            <button
                                class="btn dropdown-toggle h-55px w-55px bg-white"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <img
                                    src='{{ asset('images/flags/' . selectedStudent()->system_language->short_name . '.svg') }}'
                                    alt="image"
                                    width="24px"
                                    height="15px"
                                />
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end px-1">
                                @foreach (getLanguages() as $i => $lang)
                                    <li>
                                        <a class="dropdown-item cursor-pointer px-3 rounded {{ $i != 0 ? 'mt-2' : '' }}" data-value="{{ $lang->id }}">
                                            <img
                                                src='{{ asset("images/flags/{$lang->short_name}.svg") }}'
                                                alt="{{ $lang->short_name }}"
                                                width="24px"
                                                height="15px"
                                            />
                                            <span class="fs-7 fw-bolder ms-2">{{ $lang->original_name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    {{-- end:: Languages --}}
                @else

                    {{-- begin:: Message --}}
                    <a href="{{ route('chats.index') }}" class="message-notification-box-mobile">
                        <div class="navbar-item message-notification-box">
                            <button type="button" class="btn onb-modal-btn">
                                <img
                                    src="{{ asset('images/icons/message.svg') }}"
                                    height="30"
                                    width="30"
                                />
                            </button>
                            <span class="badge badge-pill badge-danger bubble-counter d-none" id="chat-message-counter">0</span>
                        </div>
                    </a>
                    {{-- end:: Message --}}
                
                @endcan
            </div>
        @enddesktop
        {{-- end:: Mobile --}}
    </div>
</div>

{{-- begin:: Help Video-Course Modal --}}
<div
    class="modal fade"
    id="course-onb-modal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered portal-modal">
        <div class="modal-content">
            <div class="modal-header pb-0 portal-modal-message-box">
                <div>
                    <div class="text-center">
                        <h3
                            class="my-3
                                @desktop
                                    fs-24px
                                @elsedesktop
                                    fs-16px ta-left
                                @enddesktop
                            "
                        >Seja bem vindo(a) ao Portal de Estudo da Melis Education!</h3>

                    </div>
                    <h3
                        class="
                            @desktop
                                my-3
                            @elsedesktop
                                mt-20px
                            @enddesktop
                        portal-modal-title"
                    >Assista aos vídeos abaixo para entender como funciona os cursos na plataforma.</h3>
                    
                </div>

                <button
                    type="button"
                    class="btn-close portal-modal-close-btn"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body py-0 portal-modal-steps">
                <div id="course-tabs" class="onb-tabs">
                    <h3 id="course-tab-1" class="onb-tab course-tab active" onclick="displayCourseOnbStep(1)">Passo 1</h3>
                    <h3 id="course-tab-2" class="onb-tab course-tab" onclick="displayCourseOnbStep(2)">Passo 2</h3>
                    <h3 id="course-tab-3" class="onb-tab course-tab" onclick="displayCourseOnbStep(3)">Passo 3</h3>
                    <h3 id="course-tab-4" class="onb-tab course-tab" onclick="displayCourseOnbStep(4)">Passo 4</h3>
                    <h3 id="course-tab-5" class="onb-tab course-tab" onclick="displayCourseOnbStep(5)">Passo 5</h3>
                </div>
                <div class="onb-steps">

                    {{-- begin:: Step 1 --}}
                    <div id="course-step-1" class="course-step onb-step">
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Como acessar o curso</h3>

                        <iframe
                            src="https://www.youtube.com/embed/bUN4q9OxJaw"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div class="d-flex align-items-center justify-content-end see-material-box">
                            <span class="see-material-text">Quero ver o material</span>

                            <a
                                type="button"
                                href="{{ asset('/onboardings/COMO_ASSISTIR_AS_AULAS_GRAVADAS_E_ACESSAR_AS_TAREFAS.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 1 --}}

                    {{-- begin:: Step 2 --}}
                    <div
                        id="course-step-2"
                        class="course-step onb-step"
                        style="display: none;"
                    >
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Encontros Ao Vivo</h3>

                        <iframe
                            src="https://www.youtube.com/embed/4smdiMLYJos"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div
                            class="d-flex align-items-center justify-content-end"
                            @mobile
                                style="margin-top: 10px"
                            @endmobile
                        >
                            <span class="see-material-text">Quero ver o material</span>
                            
                            <a
                                type="button"
                                href="{{ asset('/onboardings/Como_assistir_as_aulas_ao_vivo.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 2 --}}

                    {{-- begin:: Step 3 --}}
                    <div
                        id="course-step-3"
                        class="course-step onb-step"
                        style="display: none;"
                    >
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Como baixar e acessar o Zoom</h3>

                        <iframe
                            src="https://www.youtube.com/embed/_5BzdFk5kVs"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div
                            class="d-flex align-items-center justify-content-end"
                            @mobile
                                style="margin-top: 10px"
                            @endmobile
                        >
                            <span class="see-material-text">Quero ver o material</span>
                            
                            <a
                                type="button"
                                href="{{ asset('/onboardings/Como_baixar_e_acessar_o_Zoom.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 3 --}}

                    {{-- begin:: Step 4 --}}
                    <div
                        id="course-step-4"
                        class="course-step onb-step mb-38px"
                        style="display: none;"
                    >
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Replay dos Encontros</h3>

                        <iframe
                            src="https://www.youtube.com/embed/_bOe5UNALjc"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div
                            class="d-flex align-items-center justify-content-end"
                            @mobile
                                style="margin-top: 10px"
                            @endmobile
                        >
                            <span class="see-material-text">Quero ver o material</span>

                            <a
                                type="button"
                                href="{{ asset('/onboardings/COMO_ASSISTIR_AS_AULAS_GRAVADAS_E_ACESSAR_AS_TAREFAS.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 4 --}}

                    {{-- begin:: Step 5 --}}
                    <div
                        id="course-step-5"
                        class="course-step onb-step"
                        style="display: none;"
                    >
                        <h3
                            class="fs-16px
                                @mobile
                                    mb-20px
                                @endmobile
                            "
                        >Salve os contatos abaixo e entre em contato se precisar de ajuda!</h3>

                        <div
                            class="d-flex
                                @desktop
                                    align-items-center
                                @elsedesktop
                                    align-items-start flex-column
                                @enddesktop
                            justify-content-between mb-6px"
                        >
                            <div class="d-flex align-items-center">
                                <img
                                    src="{{ asset('images/icons/whats-app.svg') }}"
                                    class="portal-modal-contact-icon"
                                />
                                <span class="see-material-text">+81 80-3403-9415</span>
                            </div>

                            <div
                                class="d-flex align-items-center
                                    @mobile
                                        mt-10px
                                    @endmobile
                                "
                            >
                                <img
                                    src="{{ asset('images/icons/moving-letter_icon.svg') }}"
                                    class="portal-modal-contact-icon"
                                />
                                <span class="see-material-text">suporte@melisecucation.com</span>
                            </div>
                        </div>
                    </div>
                    {{-- end:: Step 5 --}}

                </div>
            </div>

            <div
                class="modal-footer d-flex justify-content-center"
                style="padding-top: 10px;
                    @mobile
                        margin-top: 20px
                    @enddesktop
                "
            >
                <div
                    class="d-flex
                        @mobile
                            flex-column
                        @endmobile
                    "
                    style="border-top: 1px solid #EFF0F0; width: 100%; padding-top: 20px;
                        @desktop
                            align-items: center;
                        @elsedesktop
                            align-items: start;
                        @enddesktop
                    justify-content: space-between;"
                >
                    <label class="checkbox-container">
                        <input
                            id="course-onb-checkbox"
                            type="checkbox"
                            checked
                        >
                        <span class="checkmark"></span>
                        <span class="checkbox-label">Não exibir novamente</span>
                    </label>

                    {{-- begin:: Modal Options --}}
                    <div
                        class="d-flex align-items-center"
                        @mobile
                            style="margin-top: 39px;"
                        @endmobile
                    >
                        <a
                            id="course-onb-prev"
                            type="button"
                            class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button disabled"
                        >
                            <span style="font-size: 14px;">Voltar</span>
                        </a>

                        <a
                            id="course-onb-next"
                            type="button"
                            class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button ml-20px"
                            onclick="displayCourseOnbStep(2)"
                            style="margin-left: 20px;"
                        >
                            <span style="font-size: 14px;">Próximo</span>
                        </a>

                        <a
                            id="course-onb-close"
                            type="button"
                            class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button ml-20px"
                            data-bs-dismiss="modal"
                            style="display: none !important;"
                        >
                            <span style="font-size: 14px;">Fechar</span>
                        </a>
                    </div>
                    {{-- end:: Modal Options --}}

                </div>
            </div>
        </div>
    </div>
</div>
{{-- end:: Help Video-Course Modal --}}

{{-- begin:: Help Classroom Modal --}}
<div
    class="modal fade"
    id="classroom-onb-modal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered modal-dialog-mobile"
        @desktop
            style="width: 800px; min-width: 800px;"
        @enddesktop
    >
        <div class="modal-content">
            <div class="modal-header pb-0" style="align-items: start;">
                <div>
                    <div class="text-center">
                        <h3
                            class="my-3
                                @desktop
                                    fs-24px
                                @elsedesktop
                                    fs-16px ta-left
                                @enddesktop
                            "
                        >Seja bem vindo(a) ao Portal de Estudo da Melis Education!</h3>

                    </div>
                    <h3
                        class="
                            @desktop
                                my-3
                            @elsedesktop
                                mt-20px
                            @enddesktop
                        "
                        style="font-size: 14px; color: #767F82 !important;"
                    >Assista aos vídeos abaixo para entender como funciona os cursos na plataforma.</h3>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    style="margin-top: inherit;"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body py-0 " style="margin-top: 15px">
                <div id="classroom-tabs" class="onb-tabs">
                    <h3 id="classroom-tab-1" class="onb-tab classroom-tab active" onclick="displayClassroomOnbStep(1)">Passo 1</h3>
                    <h3 id="classroom-tab-2" class="onb-tab classroom-tab" onclick="displayClassroomOnbStep(2)">Passo 2</h3>
                    <h3 id="classroom-tab-3" class="onb-tab classroom-tab" onclick="displayClassroomOnbStep(3)">Passo 3</h3>
                    <h3 id="classroom-tab-4" class="onb-tab classroom-tab" onclick="displayClassroomOnbStep(4)">Passo 4</h3>
                    <h3 id="classroom-tab-5" class="onb-tab classroom-tab" onclick="displayClassroomOnbStep(5)">Passo 5</h3>
                </div>
                <div class="onb-steps">

                    {{-- begin:: Step 1 --}}
                    <div id="classroom-step-1" class="classroom-step onb-step">
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Aulas ao vivo</h3>

                        <iframe
                            src="https://www.youtube.com/embed/4smdiMLYJos"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div
                            class="d-flex align-items-center justify-content-end"
                            @mobile
                                style="margin-top: 10px"
                            @endmobile
                        >
                            <span class="see-material-text">Quero ver o material</span>
                            <a
                                type="button"
                                href="{{ asset('/onboardings/Como_assistir_as_aulas_ao_vivo.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                                style="margin-left: 10px;"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 1 --}}

                    {{-- begin:: Step 2 --}}
                    <div
                        id="classroom-step-2"
                        class="classroom-step onb-step"
                        style="display: none;"
                    >
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Como baixar e acessar o Zoom</h3>

                        <iframe
                            src="https://www.youtube.com/embed/_5BzdFk5kVs"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div
                            class="d-flex align-items-center justify-content-end"
                            @mobile
                                style="margin-top: 10px"
                            @endmobile
                        >
                            <span class="see-material-text">Quero ver o material</span>
                            <a
                                type="button"
                                href="{{ asset('/onboardings/Como_baixar_e_acessar_o_Zoom.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                                style="margin-left: 10px;"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 2 --}}

                    {{-- begin:: Step 3 --}}
                    <div
                        id="classroom-step-3"
                        class="classroom-step onb-step"
                        style="display: none;"
                    >
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Replay dos Encontros</h3>

                        <iframe
                            src="https://www.youtube.com/embed/_bOe5UNALjc"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <div
                            class="d-flex align-items-center justify-content-end"
                            @mobile
                                style="margin-top: 10px"
                            @endmobile
                        >
                            <span class="see-material-text">Quero ver o material</span>
                            <a
                                type="button"
                                href="{{ asset('/onboardings/COMO_ASSISTIR_AS_AULAS_GRAVADAS_E_ACESSAR_AS_TAREFAS.pdf') }}"
                                target="_blank"
                                class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center see-material"
                                style="margin-left: 10px;"
                            >
                                <img src="{{ asset('images/icons/eye.svg') }}">
                            </a>
                        </div>
                    </div>
                    {{-- end:: Step 3 --}}

                    {{-- begin:: Step 4 --}}
                    <div
                        id="classroom-step-4"
                        class="classroom-step onb-step mb-38px"
                        style="display: none;"
                    >
                        <h3
                            @mobile
                                class="fs-16px mb-20px"
                            @endmobile
                        >Como acessar ao Calendário</h3>

                        <iframe
                            src="https://www.youtube.com/embed/4j42thqD984"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </div>
                    {{-- end:: Step 4 --}}

                    {{-- begin:: Step 5 --}}
                    <div
                        id="classroom-step-5"
                        class="classroom-step onb-step"
                        style="display: none;"
                    >
                        <h3
                            class="fs-16px
                                @mobile
                                    mb-20px
                                @endmobile
                            "
                        >Salve os contatos abaixo e entre em contato se precisar de ajuda!</h3>

                        <div
                            class="d-flex
                                @desktop
                                    align-items-center
                                @elsedesktop
                                    align-items-start flex-column
                                @enddesktop
                            justify-content-between mb-6px"
                        >
                            <div class="d-flex align-items-center">
                                <img
                                    src="{{ asset('images/icons/whats-app.svg') }}"
                                    style="margin-right: 13px;"
                                />
                                <span class="see-material-text">+81 80-3403-9415</span>
                            </div>
                            <div
                                class="d-flex align-items-center
                                    @mobile
                                        mt-10px
                                    @endmobile
                                "
                            >
                                <img
                                    src="{{ asset('images/icons/moving-letter_icon.svg') }}"
                                    style="margin-right: 13px;"
                                />
                                <span class="see-material-text">suporte@melisecucation.com</span>
                            </div>
                        </div>
                    </div>
                    {{-- end:: Step 5 --}}

                </div>
            </div>
            <div
                class="modal-footer d-flex justify-content-center"
                style="padding-top: 10px;
                    @mobile
                        margin-top: 20px
                    @enddesktop
                "
            >
                <div
                    class="d-flex
                        @mobile
                            flex-column
                        @endmobile
                    "
                    style="border-top: 1px solid #EFF0F0; width: 100%; padding-top: 20px;
                        @desktop
                            align-items: center;
                        @elsedesktop
                            align-items: start;
                        @enddesktop
                    justify-content: space-between;"
                >
                    <label class="checkbox-container">
                        <input
                            id="classroom-onb-checkbox"
                            type="checkbox"
                            checked
                        />
                        <span class="checkmark"></span>
                        <span class="checkbox-label">Não exibir novamente</span>
                    </label>
                    <div
                        class="d-flex align-items-center"
                        @mobile
                            style="margin-top: 39px;"
                        @endmobile
                    >
                        <a
                            id="classroom-onb-prev"
                            type="button"
                            class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button disabled"
                        >
                            <span style="font-size: 14px;">Voltar</span>
                        </a>
                        <a
                            id="classroom-onb-next"
                            type="button"
                            onclick="displayClassroomOnbStep(2)"
                            style="margin-left: 20px;"
                            class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button ml-20px"
                        >
                            <span style="font-size: 14px;">Próximo</span>
                        </a>
                        <a
                            id="classroom-onb-close"
                            type="button"
                            data-bs-dismiss="modal"
                            style="display: none !important;"
                            class="btn bg-primary btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button ml-20px"
                        >
                            <span style="font-size: 14px;">Fechar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- begin:: Help Classroom Modal --}}

<style>
    .main-header-menu {
        display: inline-flex;
        align-items: center;
        width: 100%;
        justify-content: flex-end;
    }

    .onb-modal-box {
        width: 56px;
        height: 56px;
        background-color: white;
        border-radius: 12px;
        text-align: center;
        margin-right: 16px;
    }

    .onb-modal-btn, .message-notification-btn {
        height: 100%;
        width: 100%;
    }

    .message-notification-box {
        width: 56px;
        height: 56px;
        background-color: white;
        border-radius: 12px;
        text-align: center;
        margin-right: 16px;
        position: relative;
        cursor: pointer;
    }

    .message-notification-box-mobile {
        width: 56px;
        height: 56px;
        text-align: center;
        position: relative;
        z-index: 10;
    }

    .message-notification-dropdown {
        width: 320px;
        border-radius: 10px;
        background-color: #fff;
    }

    .message-notification-expand {
        background: none;
        border: none;
        padding: 0;
    }

    .system-language-box {
        z-index: 10;
    }

    .portal-modal {
        @desktop
            width: 800px;
            min-width: 800px;"
        @enddesktop
    }

    .portal-modal-message-box {
        align-items: start;
    }

    .portal-modal-title {
        font-size: 14px;
        color: #767F82 !important;
    }

    .portal-modal-close-btn {
        margin-top: inherit;
    }

    .portal-modal-steps {
        margin-top: 15px
    }

    .portal-modal-contact-icon {
        margin-right: 13px;
    }

    .see-material-box {
        @mobile
            margin-top: 10px
        @endmobile
    }

    .bubble-counter {
        position: absolute;
        top: 5px;
        right: 5px;
        padding: .35em .65em;
        font-size: .75em;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .35rem;
        z-index: 10;
    }

    .chat-dropdown {
        position: absolute;
        top: 75px;
        right: 30px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        width: 350px;
        padding: 10px;
    }

    .chat-dropdown .d-flex.justify-content-between.align-items-center.mb-3 {
        padding: 0 5px;
    }

    .chat-dropdown .d-flex.justify-content-between.align-items-center.mb-3 h2 {
        font-size: 3rem;
        font-weight: 600;
    }

    #chat-messages-container {
        height: 320px;
        max-height: 320px;
        overflow-y: auto;
        padding: 0;
    }

    .chat-item {
        width: 100%;
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: inherit;
        position: relative;
        transition: background-color 0.2s ease-in-out;
        border-bottom: 1px solid #f0f0f0;
        padding: 12px 10px;
    }

    .chat-item:last-child {
        border-bottom: none;
    }

    .chat-item:hover {
        background-color: #f7f7f7 !important;
        border-radius: 8px;
    }

    .chat-content {
        flex-grow: 1;
        min-width: 0;
    }

    .chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .chat-name {
        font-weight: bold;
        font-size: 0.95em;
        color: #333;
    }

    .chat-time {
        font-size: 0.8em;
        color: #888;
        white-space: nowrap;
        margin-left: 10px;
    }

    .chat-last-message {
        font-size: 0.9em;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .chat-unread-count {
        background-color: #329FBA;
        color: white;
        border-radius: 100%;
        width: 20px;
        height: 20px;
        padding: 2px 8px;
        font-size: 0.75em;
        font-weight: bold;
        margin-left: 25px;
        margin-bottom: 10px;
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    #view-all-chats-button {
        padding-top: 15px;
        display: block;
        text-align: center;
        font-size: 0.9em;
        color: #329FBA;
        text-decoration: none;
        font-weight: bold;
    }

    .chat-list::-webkit-scrollbar {
        width: 5px;
    }

    .chat-list::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 10px;
    }

    .chat-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .chat-list::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    .mt-10px {
        margin-top: 10px;
    }

    #classroom-step-5,
    #course-step-5 {
        height: 100%;
        justify-content: center;
    }

    .mt-20px {
        margin-top: 20px;
    }

    .mb-20px {
        margin-bottom: 20px;
    }

    #classroom-onb-modal,
    #classroom-onb-modal {
        padding: 10px;
    }

    .ta-left {
        text-align: left;
    }

    .fs-16px {
        font-size: 16px;
    }

    .fs-24px {
        font-size: 24px;
    }

    @media (max-width: 576px) {
        .modal-dialog-mobile {
            width: 100% !important;
            min-width: unset !important;
            margin: 0px !important;
        }
    }

    iframe {
        border-radius: 10px;
        width: 100%;
        margin-bottom: 13px;
        @desktop height: 284px;
        @elsedesktop
        height: 173.878px;
        @enddesktop
    }

    .ml-20px {
        margin-left: 20px;
    }

    .mb-38px {
        margin-bottom: 38px;
    }

    .mb-6px {
        margin-bottom: 6px;
    }

    .mb-17px {
        margin-bottom: 17px;
    }

    .mt-27px {
        margin-top: 27px;
    }

    .see-material-text {
        font-weight: 600;
        font-size: 14px;
        color: #8C9497;
    }

    .see-material {
        height: 38px;
        width: 38px;
        margin: 0px 0px 0px 10px;
    }

    .onb-steps {
        @desktop padding: 0px 128px;
        height: 366.7px;
        @elsedesktop
        height: 264px;
        @enddesktop
    }

    .onb-step {
        display: flex;
        flex-direction: column;
    }

    .onb-tabs {
        display: flex;
        @desktop border-bottom: 4px solid #F2F2F5;
        @enddesktop
        gap: 40px;
        margin-bottom: 22px;
        @mobile align-items: end;
        overflow-x: scroll;
        overflow-y: hidden;
        @endmobile
    }

    .onb-tabs::-webkit-scrollbar {
        height: 5px;
        width: 20px !important;
    }

    .onb-tabs::-webkit-scrollbar-thumb {
        background-color: #329FBA;
        border-radius: 4px;
    }

    .onb-tabs::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 4px;
    }

    .onb-btn {
        height: 40px;
        width: 136px;
    }

    .checkbox-label {
        @tablet
        font-size: 12px;
        margin-top: 10px;
        white-space: nowrap;
        @elsetablet
        font-size: 14px;
        @endtablet
        font-weight: 600;
        display: flex;
        align-items: center;
        text-align: center;
        color: #485558;
        margin-left: 10px;
    }

    .checkbox-container {
        position: relative;
        padding-left: 25px;
        cursor: pointer;
        display: flex;
        align-items: baseline;
        gap: 10px;
    }

    .checkbox-container input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        @tablet
        top: 9px;
        @elsetablet
        top: 0;
        @endtablet
        left: 0;
        border-radius: 6px !important;
        border: 1px solid #329FBA;
        width: 24px;
        height: 24px;
    }

    .checkbox-container input[type="checkbox"]:checked~.checkmark {
        background-color: #2196F3;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-container input[type="checkbox"]:checked~.checkmark:after {
        display: block;
    }

    .checkbox-container .checkmark:after {
        left: 8px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .onb-checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .onb-tab {
        color: #A4AAAC !important;
        padding-bottom: 11px;
        margin: 0;
        position: relative;
        top: 4px;
        cursor: pointer;
        @mobile
        white-space: nowrap;
        @endmobile
        @tablet
        font-size: 16px;
        height: 32px;
        white-space: nowrap;
        @endtablet
    }

    .onb-tab:hover {
        color: #485558 !important;
        border-bottom: 4px solid #329FBA;
    }

    .onb-tab.active {
        color: #485558 !important;
        border-bottom: 4px solid #329FBA;
        border-radius: 2px;
    }

    @media (max-width: 991.98px) {
        #kt_header > .container-fluid {
            position: relative !important;
            height: 60px !important;
        }

        #kt_aside_mobile_toggle {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        a.d-lg-none {
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            z-index: 1;
        }

        .mobile-logo {
            height: 40px;
            width: auto;
        }

        .mobile-header-chat-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        #kt_header_nav, 
        #kt_header .d-flex[style*="justify-content: flex-end"] {
            display: none !important;
        }
    }

    #classroom-onb-next,
    #course-onb-next,
    #classroom-onb-prev,
    #course-onb-prev,
    #classroom-onb-close,
    #course-onb-close {
        @mobile width: 136px;
        @endmobile
        @tablet width: 130px;
        @endtablet
    }

    .language-select .dropdown-toggle::after {
        display: none;
    }

    .language-select .dropdown-item:hover {
        background-color: #F4F4F5;
    }

    .language-select .dropdown-item.active,
    .language-select .dropdown-item:active {
        background-color: var(--bg-primary);
    }
</style>

<script>
    $('.my-profile-button').on('click', function() {
        window.location = '/myProfile';
    });

    let studentId = {{ session()->get('student_id') ?? 'null' }};

    $('.language-select .dropdown-item').on('click', function(e) {
        console.log('dsko');
        const route = $('.language-select').attr('data-route');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route,
            type: 'PUT',
            data: {
                'language_id': $(this).attr('data-value')
            },
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        $('#classroom-onb-modal').on('hidden.bs.modal', function() {

            var onboardingPreference = $('#classroom-onb-checkbox').is(':checked') ? 0 : 1;

            $.ajax({
                url: '/students/' + studentId + '/update-classroom-onboarding-preference',
                method: 'GET',
                data: {
                    preference: onboardingPreference
                }
            });
        });

        $('#course-onb-modal').on('hidden.bs.modal', function() {

            var onboardingPreference = $('#course-onb-checkbox').is(':checked') ? 0 : 1;

            $.ajax({
                url: '/students/' + studentId + '/update-course-onboarding-preference',
                method: 'GET',
                data: {
                    preference: onboardingPreference
                }
            });
        });
    });

    function showOnbClassroomModal() {
        $('#classroom-onb-modal').modal('show');
    }

    function displayClassroomOnbStep(step) {
        $(".classroom-step").css("display", "none");
        $(".classroom-tab.active").removeClass('active');
        $(`#classroom-tab-${step}`).addClass('active');
        $('#classroom-step-' + step).attr('style', 'display: flex !important');
        $('#classroom-onb-next').attr('style', 'display: flex !important');
        $('#classroom-onb-close').attr('style', 'display: none !important');
        $('#classroom-onb-prev').removeClass('disabled');

        switch (step) {
            case 1:
                $('#classroom-onb-prev').addClass('disabled');
                $('#classroom-onb-prev').removeAttr('onclick');
                $('#classroom-onb-next').attr('onclick', 'displayClassroomOnbStep(2)');
                break;
            case 2:
                $('#classroom-onb-prev').attr('onclick', 'displayClassroomOnbStep(1)');
                $('#classroom-onb-next').attr('onclick', 'displayClassroomOnbStep(3)');
                break;
            case 3:
                $('#classroom-onb-prev').attr('onclick', 'displayClassroomOnbStep(2)');
                $('#classroom-onb-next').attr('onclick', 'displayClassroomOnbStep(4)');
                break;
            case 4:
                $('#classroom-onb-prev').attr('onclick', 'displayClassroomOnbStep(3)');
                $('#classroom-onb-next').attr('onclick', 'displayClassroomOnbStep(5)');
                break;
            case 5:
                $('#classroom-onb-prev').attr('onclick', 'displayClassroomOnbStep(4)');
                $('#classroom-onb-next').attr('style', 'display: none !important');
                $('#classroom-onb-close').attr('style', 'display: flex !important');
                break;
        }

        if ($(window).width() < 768) {
            var container = $(".onb-tabs");
            var targetTab = $(`#classroom-tab-${step}`);
            var targetPosition = targetTab.position().left - container.scrollLeft() + container.offset().left;
            var containerWidth = container.width();
            var tabPosition = targetTab.position().left;
            var tabWidth = targetTab.outerWidth();

            if (tabPosition < 0 || tabPosition + tabWidth > containerWidth) {
                container.animate({
                    scrollLeft: targetPosition
                }, 500);
            }
        }
    }

    function showOnbCourseModal() {
        $('#course-onb-modal').modal('show');
    }

    function displayCourseOnbStep(step) {
        $(".course-step").css("display", "none");
        $(".course-tab.active").removeClass('active');
        $(`#course-tab-${step}`).addClass('active');
        $('#course-step-' + step).attr('style', 'display: flex !important');
        $('#course-onb-next').attr('style', 'display: flex !important');
        $('#course-onb-close').attr('style', 'display: none !important');
        $('#course-onb-prev').removeClass('disabled');

        switch (step) {
            case 1:
                $('#course-onb-prev').addClass('disabled');
                $('#course-onb-prev').removeAttr('onclick');
                $('#course-onb-next').attr('onclick', 'displayCourseOnbStep(2)');
                break;
            case 2:
                $('#course-onb-prev').attr('onclick', 'displayCourseOnbStep(1)');
                $('#course-onb-next').attr('onclick', 'displayCourseOnbStep(3)');
                break;
            case 3:
                $('#course-onb-prev').attr('onclick', 'displayCourseOnbStep(2)');
                $('#course-onb-next').attr('onclick', 'displayCourseOnbStep(4)');
                break;
            case 4:
                $('#course-onb-prev').attr('onclick', 'displayCourseOnbStep(3)');
                $('#course-onb-next').attr('onclick', 'displayCourseOnbStep(5)');
                break;
            case 5:
                $('#course-onb-prev').attr('onclick', 'displayCourseOnbStep(4)');
                $('#course-onb-next').attr('style', 'display: none !important');
                $('#course-onb-close').attr('style', 'display: flex !important');
                break;
        }

        if ($(window).width() < 768) {
            var container = $(".onb-tabs");
            var targetTab = $(`#course-tab-${step}`);
            var targetPosition = targetTab.position().left - container.scrollLeft() + container.offset().left;
            var containerWidth = container.width();
            var tabPosition = targetTab.position().left;
            var tabWidth = targetTab.outerWidth();

            if (tabPosition < 0 || tabPosition + tabWidth > containerWidth) {
                container.animate({
                    scrollLeft: targetPosition
                }, 500);
            }
        }
    }
</script>