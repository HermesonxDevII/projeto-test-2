<div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'100%', '100%': '100%'}" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/melis-education-vertical.png') }}" alt="">
        </a>
        <div id="kt_aside_toggle" class="d-none btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item menu-accordion">

                    {{-- @dump(session()->get('student_id')) --}}
                    {{-- @dump(session()->get('student_name')) --}}
                    {{-- @dump(session()->get('user_role_id')) --}}
                    {{-- @dump(session()->get('user_id')) --}}
                    {{-- @dump(session()->get('student_avatar_id')) --}}
                    {{-- @dump(Auth::user()->name) --}}
                    {{-- @dump(Auth::user()->id) --}}

                    <a href="{{ url('dashboard') }}"
                        class="menu-link menu-parent-link
                        @if (Route::is('dashboard')) menu-active @endif">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ asset('images/icons/menu.svg') }}" alt=""
                                    style="filter: brightness(0.55);"
                                    @if (Route::is('dashboard')) class="invert-color" @endif alt="Dashboard Icon">
                            </span>
                        </span>
                        <span class="menu-title">{{ __('sidebar.home') }}</span>
                    </a>

                    @canany(['admin', 'teacher'])
                        <a href="{{ url('/students') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('students.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/users.svg') }}" alt="Student Icon"
                                        @if (Route::is('students.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Alunos</span>
                        </a>
                    @endcanany

                    @can('admin')
                        <a href="{{ url('/guardians') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('guardians.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/users.svg') }}" alt="User Icon"
                                        @if (Route::is('guardians.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Responsáveis</span>
                        </a>
                    @endcan

                    @canany(['admin', 'teacher'])
                        <a href="{{ url('/classrooms') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('classrooms.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/file-text.svg') }}" alt="Classrooms Icon"
                                        @if (Route::is('classrooms.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Turmas</span>
                        </a>
                    @endcanany

                    @can('admin')
                        <a href="{{ route('preRegistration.index') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('preRegistration.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/file-text.svg') }}"
                                        @if (Route::is('preRegistration.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Pré-Inscrições</span>
                        </a>
                    @endcanany

                    @can('guardian')
                        @if (Auth::user()->can('guardian') &&
                                selectedStudent() &&
                                selectedStudent()->classrooms()->exists() &&
                                hasCalendar(session()->get('student_id')))
                            <a href="{{ url('/classrooms') }}"
                                class="menu-link menu-parent-link
                                @if (Route::is('classrooms.*')) menu-active @endif">
                                <span class="menu-icon">
                                    <span class="svg-icon svg-icon-2">
                                        <img src="{{ asset('images/icons/file-text.svg') }}"
                                            alt="Classrooms and Courses Icon"
                                            @if (Route::is('classrooms.*')) class="invert-color" @endif>
                                    </span>
                                </span>
                                <span class="menu-title">{{ __('sidebar.classrooms') }}</span>
                            </a>
                        @endif
                    @endcan

                    @can('guardian')
                        @if (selectedStudent() && selectedStudent()->videoCourses()->exists())
                            <a href="{{ route('video-courses.index') }}"
                                class="menu-link menu-parent-link
                            @if (Route::is('video-courses.*')) menu-active @endif">
                                <span class="menu-icon">
                                    <span class="svg-icon svg-icon-2">
                                        <img src="{{ asset('images/icons/play-circle-gray.svg') }}" alt="Courses Icon"
                                            @if (Route::is('video-courses.*')) class="invert-color" @endif>
                                    </span>
                                </span>
                                <span class="menu-title">{{ __('sidebar.courses') }}</span>
                            </a>
                        @endif
                    @endcan

                    @canany(['admin', 'teacher'])
                        <a href="{{ route('video-courses.index') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('video-courses.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/play-circle-gray.svg') }}" alt="Courses Icon"
                                        @if (Route::is('video-courses.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Cursos</span>
                        </a>
                    @endcan

                    @canany(['admin', 'teacher'])
                        <a href="{{ url('/calendars/new-calendar') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('calendars.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/calendar.svg') }}" alt="Calendars Icon"
                                        @if (Route::is('calendars.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Calendário</span>
                        </a>
                    @endcanany

                    @can('guardian')
                        @if (Auth::user()->can('guardian') && selectedStudent() && selectedStudent()->classrooms()->exists())
                            <a href="{{ url('/calendars/student-new-calendar') }}"
                                class="menu-link menu-parent-link
                            @if (Route::is('calendars.*')) menu-active @endif">
                                <span class="menu-icon">
                                    <span class="svg-icon svg-icon-2">
                                        <img src="{{ asset('images/icons/calendar.svg') }}" alt="Calendars Icon"
                                            @if (Route::is('calendars.*')) class="invert-color" @endif>
                                    </span>
                                </span>
                                <span class="menu-title">{{ __('sidebar.calendars') }}</span>
                            </a>
                        @endif
                    @endcan

                    @can('admin')
                        <a href="{{ url('/users') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('users.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/cog.svg') }}" alt="User Icon"
                                        @if (Route::is('users.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Usuários</span>
                        </a>

                        {{-- <a href="{{ url("/evaluationModels") }}" class="menu-link menu-parent-link
                            @if (Route::is('evaluationModels.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/file-text.svg') }}" alt="User Icon"
                                    @if (Route::is('evaluationModels.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Modelos de avaliação</span>
                        </a> --}}
                    @endcan

                    @if (!Auth::user()->can('guardian') || (selectedStudent() && selectedStudent()->classrooms()->exists()))
                        <a href="{{ url('/chats') }}"
                            class="menu-link menu-parent-link
                            @if (Route::is('chats.*')) menu-active @endif">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <img src="{{ asset('images/icons/message.svg') }}" alt="Chat Icon" style="filter: grayscale(100%) opacity(0.5);"
                                        @if (Route::is('chats.*')) class="invert-color" @endif>
                                </span>
                            </span>
                            <span class="menu-title">Chat</span>
                        </a>
                    @endif

                    <a href="{{ route('myProfile') }}"
                        class="menu-link menu-parent-link my-profile my-profile-button">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ asset('images/icons/user.svg') }}" class="user-options-icon user-icon"
                                    alt="Chat Icon" @if (Route::is('users.myProfile')) class="invert-color" @endif>
                            </span>
                        </span>
                        <span class="menu-title">Meu perfil</span>
                    </a>

                    <a href="{{ route('logout') }}" class="menu-link menu-parent-link logout logout-system">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ asset('images/icons/power.svg') }}"
                                    class="user-options-icon logout-icon" alt="Logout Icon">
                            </span>
                        </span>
                        <span class="menu-title">{{ __('Sair') }}</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a href="">
            <span class="btn-label">Docs &amp; Components</span>
            <span class="svg-icon btn-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="black" />
                    <rect x="7" y="17" width="6" height="2" rx="1" fill="black" />
                    <rect x="7" y="12" width="10" height="2" rx="1" fill="black" />
                    <rect x="7" y="7" width="6" height="2" rx="1" fill="black" />
                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                </svg>
            </span>
        </a>
    </div> --}}
</div>
