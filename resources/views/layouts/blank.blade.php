<!DOCTYPE html>
	<html lang="pt_BR">
	<head>
		<base href="../../">
		<title>Melis Education</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="{{asset('images/favicon.png')}}"/>
		{{-- <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" /> --}}
		{{-- <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
		<link rel="stylesheet" href="{{ asset('css/site/styles.css') }}">
		<link rel="stylesheet" href="{{ asset('css/site/blank.css') }}">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<!-- <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet"> -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script>
			(function(h,o,t,j,a,r){
				h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
				h._hjSettings={hjid:{{ env("HOTJAR_ID","") }},hjsv:6};
				a=o.getElementsByTagName('head')[0];
				r=o.createElement('script');r.async=1;
				r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
				a.appendChild(r);
			})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
		</script>

		@yield('extra-plugins')
		@yield('extra-styles')
		@yield('csrf-token')

		<style>
			body {
				background-color: white;
			}
		</style>

	</head>
	<body class="screen-height @yield('custom-body')">
		@yield('content')
		@yield('footer')
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('js/app.js') }}?version={{ getAppVersion() }}"></script>
		{{-- <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
		<script src="{{ asset('js/custom/widgets.bundle.js') }}"></script>
		<script src="{{ asset('js/custom/widgets.js') }}"></script>
		<script src="{{ asset('js/shared/validations.js') }}?version={{ getAppVersion() }}"></script>
		<script src="{{ asset('js/shared/common.js') }}?version={{ getAppVersion() }}"></script>
		<script src="{{ asset('js/shared/momentjs/moment.min.js') }}"></script>
		<script src="{{ asset('js/shared/momentjs/moment-with-locales.min.js') }}"></script>
		<script src="{{ asset('js/shared/momentjs/br.js') }}"></script>
		<script src="{{ asset('js/dashboard/dashboard.js') }}?version={{ getAppVersion() }}"></script>
		@yield('extra-scripts')

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
	</body>
</html>
