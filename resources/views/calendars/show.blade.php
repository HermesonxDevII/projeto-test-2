@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ __('sidebar.calendars') }}
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col-md-9 col-xs-12">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">{{ __('sidebar.calendars') }}</h1>
        </div>
        @if($type == 'student' && ($calendars && $calendars->count() > 1))

            <div class="col-md-3 col-xs-12" style="text-align: end;">
                <div class="align-items-stretch flex-shrink-0 navbar-item ps-4" id="kt_calendar_menu_toggle"
                    data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <div class="d-flex justify-content-between">
                        <span>{{$calendars->first()->title}}</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800"
                        data-kt-menu="true" id="dropwdown-calendar">
                        @foreach($calendars as $thisCalendar)
                        <div class="menu-item p-2">
                            <a href="{{ url('/calendars/student/'.$thisCalendar->id) }}" class="menu-link link-calendar">
                                <span>{{ $thisCalendar->title }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        @elseif($type == 'admin')
            <div class="col-md-3 col-xs-12" style="text-align: end;">
                <a href="{{ route('calendars.index') }}">
                    <button class="btn bg-primary btn-shadow" style="width: 200px; height: 40px;">
                        <span class="text-white">Voltar</span>
                    </button>
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div class="table-container p-0">

                        <div class="embed-iframe">
                            {!! isset($calendars) ? $calendars->first()->embed_code : $calendar->embed_code !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')
    <script src="{{asset('js/calendars/show.js')}}?version={{ getAppVersion() }}"></script>
@endsection
