<!DOCTYPE html>
	<html lang="pt_BR">
	<head>
		<base href="../../">

        <title>Melis Education | @yield('title', 'Dashboard')</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" href="{{asset('images/favicon.png')}}"/>
		{{-- <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" /> --}}
		<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
		<link rel="stylesheet" href="{{ asset('css/site/styles.css') }}">
		<!-- <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet"> -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<link rel="icon" href="{{ asset('images/icons/melis-favicon.png') }}" type=image/x-icon>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('extra-plugins')
		@yield('extra-styles')
		@yield('csrf-token')
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.all.min.js"></script>
		<script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:5205375,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
	</head>
	<body id="kt_body app" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				@include('layouts.sidebar')

				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

					{{-- begin:Header --}}
					@include('layouts.header.header')
					{{-- end::Header --}}

					{{-- begin::Content --}}
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<div id="kt_content_container" class="container-fluid">
								@yield('content')
							</div>
						</div>
					</div>
					{{-- end:Content --}}
					{{-- @include('layouts.footer') --}}
				</div>
			</div>
		</div>
		{{-- @include('layouts.chat') --}}

		{{-- begin::Scrolltop --}}
			<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
				<span class="svg-icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
						<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
					</svg>
				</span>
			</div>
		{{-- end::Scrolltop --}}

		{{-- begin::loading modal --}}
			<div class="modal fade" id="loading_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
				aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header pb-0"></div>
						<div class="modal-body py-0 text-center">
							<img src="{{ asset('images/loading.svg') }}" alt="loading gif">
							<h3>Carregando, por favor aguarde.</h3>
						</div>
						<div class="modal-footer d-flex justify-content-center"></div>
					</div>
				</div>
			</div>
		{{-- end::loading modal --}}

		{{-- begin:alert modal --}}
			<div class="modal fade" id="alert_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
				aria-labelledby="staticBackdropLabel" aria-hidden="true">

				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header pb-0">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body py-0">
							<div class="text-center">
								<img src="{{ asset('images/icons/x-circle.svg') }}" alt="warning" class="my-2">
								<h3 class="my-3">Atenção</h3>
								<span id="message"></span>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center">
							<button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
								<span>Ok</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		{{-- end:alert modal --}}

		<div class="modal fade" id="choose_student_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">

			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header pb-0">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body py-0">
						<h4 class="title text-center">Selecione o perfil de acesso a plataforma:</h4>
						<div class="row justify-content-center students">

                        </div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button type="button" class="btn bg-secondary btn-shadow btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
							<span>Cancelar</span>
						</button>
					</div>
				</div>
			</div>
		</div>

        {{-- begin: logout modal --}}
        <div class="modal fade" id="logout_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <div class="text-center">
                            <img src="/images/icons/x-circle.svg" alt="warning" class="my-2">
                            <h3 class="my-3">Você gostaria de sair do sistema?</h3>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn bg-secondary btn-shadow text-white modal-cancel-button" data-bs-dismiss="modal">
                            <span>Cancelar</span>
                        </button>
												<form action="{{ route('logout') }}" method="POST">
													@csrf
													<button type="submit" class="btn bg-danger btn-shadow text-white d-flex align-items-center justify-content-center modal-confirm-button">
															<span>SAIR</span>
													</button>
												</form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end: logout modal --}}

		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/server/ajax_setup.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		{{-- <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
		<script src="{{ asset('js/custom/widgets.bundle.js') }}"></script>
		<script src="{{ asset('js/custom/widgets.js') }}"></script>
		@yield('extra-scripts')
		<script src="{{ asset('js/shared/validations.js') }}?version={{ getAppVersion() }}"></script>
		<script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>

		{{-- begin:notification --}}
			@if (Session::has('notification'))
				<script>
					Toast.fire({
						icon: "{{ Session::get('notification')['icon'] }}",
						title: "{{ Session::get('notification')['msg'] }}"
					});
				</script>
			@endif
		{{-- end:notification --}}

		<script src="{{ asset('js/shared/momentjs/moment.min.js') }}"></script>
		<script src="{{ asset('js/shared/momentjs/moment-with-locales.min.js') }}"></script>
		<script src="{{ asset('js/shared/momentjs/br.js') }}"></script>
		<script src="{{ asset('js/dashboard/dashboard.js') }}?version={{ getAppVersion() }}"></script>
		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

		<script>
			Pusher.logToConsole = false;

			var pusher = new Pusher('517cf3e353c83314c4ac', {
				cluster: 'us2'
			});

			subscribeToCourses();
		</script>

        @can('guardian')
            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/62e142ad37898912e95fed6d/1g8vuoua1';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
                })();
            </script>
            <!--End of Tawk.to Script-->
        @endcan
	</body>
</html>
