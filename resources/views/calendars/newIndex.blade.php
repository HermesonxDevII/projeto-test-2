@extends('layouts.app')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ __('calendar.title') }}
@endsection

@section('extra-styles')
    <style>
        .fc-toolbar-title {
            margin-right: 100px !important;
        }

        .fc-list-event-title,
        .fc-list-event-time,
        .fc-event-title,
        .fc-event-time,
        .fc-event-title-container {
            font-family: 'Inter', sans-serif !important;
            font-size: 15px !important;
            font-weight: bold !important;
            color: #000 !important;
        }

        .fc-event-time {
            display: none;
        }

        @media (min-width: 768px) {

            .fc-event-title,
            .fc-list-event-title {
                white-space: normal !important;
                word-wrap: break-word;
            }
        }

        .month-selector {
            position: absolute;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            top: 405px;
            width: 270px;
            height: auto;
        }

        .month-selector-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            color: #5e6278;
            font-weight: 600;
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }

        #prev-year,
        #next-year {
            border: none;
            background: #fff;
            color: #5e6278;
            font-weight: 600;
            transition: color 0.1s ease;
        }

        #prev-year:hover,
        #next-year:hover {
            color: #329fba;
        }

        .month-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .month-button {
            padding: 5px;
            background: #fff;
            border: none;
            cursor: pointer;
            width: 60px;
            color: #5e6278;
            font-weight: 600;
            transition: color 0.1s ease;
        }

        .month-button:hover {
            color: #329fba;
        }

        .month-button.selected,
        .flatpickr-day.selected.prevMonthDay,
        .flatpickr-day.selected.nextMonthDay {
            background: #329fba;
            border-radius: 5px;
            color: #fff;
        }

        .form-check.form-check-solid .form-check-input {
            width: 30px;
            height: 30px;
            border-radius: 5px !important;
        }

        .form-check.form-check-solid .form-check-input:checked {
            background-color: #329fba;
        }

        .gap-5px {
            gap: 5px;
        }

        .flatpickr-day.selected {
            background: #329fba;
        }

        .flatpickr-day.selected:hover {
            background: #329fba;
        }

        .flatpickr-day:hover {
            color: #329fba;
        }

        .border-error,
        .form-select.form-select-solid.border-error:focus {
            border-color: #ea868f !important;
        }

        .swal2-confirm,
        .swal2-cancel {
            padding: calc(.75rem + 1px) calc(1.5rem + 1px) !important;
        }
    </style>
@endsection

@section('content')
    <div style="width: 100%; margin-bottom: 30px; align-items: center;" class="row">
        <div class="col">
            <h1 style="font-size: 36px; line-height: 48px;" class="p-0 m-0">{{ __('calendar.title') }}</h1>
        </div>

        @canany(['admin', 'teacher'])
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-center">
                @if (count($classrooms) > 1)
                    <select class="form-select" id="classroom_filter" style="height: 50px">
                        @can('admin')
                            <option value="all" selected>Todas</option>
                        @elsecan('teacher')
                            <option value="all" selected>Minhas Turmas</option>
                        @endcan
                        @foreach ($classrooms as $index => $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                @endif
                @can('admin')
                    <a id="openEventModal" class="default-btn bg-primary btn-shadow text-white m-3" style="width: 130px">
                        Incluir
                    </a>
                @endcan
            </div>
        @endcanany
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="justify-content-center">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    @can('admin')
        <div class="modal fade" id="eventModal" tabindex-="1" aria-hidden="true" data-bs-focus="false">

            <div class="modal-dialog modal-dialog-centered mw-650px">

                <div class="modal-content">

                    <form class="form" action="#" id="kt_modal_add_event_form">

                        <div class="modal-header justify-content-between border-bottom-gray">

                            <h2 id="event-modal-title" class="fw-bold m-0">Inluir novo evento</h2>

                            <button type="button" class="btn bg-light text-gray-600" data-bs-dismiss="modal"
                                style="width: 30px">X</button>
                        </div>

                        <div class="modal-body p-30px">

                            <input type="hidden" id="event_id">
                            <input type="hidden" id="event_day">

                            <div class="d-flex align-items-center justify-content-between mb-20px">
                                <div class="col-4">
                                    <label class="required form-label m-0">Turma</label>
                                </div>

                                <div class="col-8 d-flex align-items-center gap-20px">
                                    <div class="w-100">
                                        <select name="event_classroom" class="form-select form-select-solid">
                                            <option value="">Selecione</option>
                                            <option value="all">Todas</option>
                                            @foreach ($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}">
                                                    {{ $classroom->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-20px">
                                <div class="col-4">
                                    <label class="form-label m-0 required">Nome</label>
                                </div>

                                <div class="col-8 d-flex gap-20px">
                                    <div class="w-100">
                                        <input name="event_name" type="text" class="form-control form-control-solid"
                                            placeholder="Nome da Aula ou evento" />
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-20px">
                                <div class="col-4">
                                    <label class="form-label m-0 required">Cor</label>
                                </div>

                                <div class="col-8 d-flex gap-20px">
                                    <div class="w-48">
                                        <input id="hex-input" name="event_color" type="text"
                                            class="form-control form-control-solid" placeholder="Digite a cor" />
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-20px">
                                <div class="col-4">
                                    <label class="form-label m-0 required">Horário</label>
                                </div>

                                <div class="col-8 d-flex gap-20px">
                                    <div class="w-100">
                                        <input name="event_start" type="text" class="form-control form-control-solid hour"
                                            placeholder="Insira o início" />
                                    </div>
                                    <div class="w-100">
                                        <input name="event_end" type="text" class="form-control form-control-solid hour"
                                            placeholder="Insira o final" />
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-30px">
                                <div class="col-4">
                                    <h3 class="fw-bold m-0">Datas e períodos</h3>
                                </div>

                                <div class="col-8 d-flex align-items-center gap-20px"></div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-20px">
                                <div class="col-4">
                                    <label class="form-label m-0 required">Meses</label>
                                </div>

                                <div class="col-8 d-flex gap-20px">
                                    <div class="w-48">
                                        <input name="months" type="text" class="form-control form-control-solid months"
                                            placeholder="Selecione" autocomplete="off" readonly />
                                    </div>
                                    <div id="month-selector" class="month-selector" style="display: none;">
                                        <div class="month-selector-header">
                                            <button type="button" id="prev-year">&lt;</button>
                                            <span id="current-year"></span>
                                            <button type="button" id="next-year">&gt;</button>
                                        </div>
                                        <div class="month-buttons">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="eventRepeatWrapper"
                                class="d-flex align-items-center justify-content-between mb-20px d-none">
                                <div class="col-4">
                                    <label class="form-label m-0 required">Repete</label>
                                </div>

                                <div class="col-8 d-flex align-items-center gap-20px">
                                    <div class="w-48">
                                        <select id="repeat" name="repeat" class="form-select form-select-solid">
                                            <option value="" selected>Selecione</option>
                                            <option value="never">Nunca</option>
                                            <option value="weekly">Semanalmente</option>
                                            <option value="biweekly">Quinzenalmente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="eventWeekdaysWrapper"
                                class="d-flex align-items-center justify-content-between mb-20px d-none">
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="monday" />
                                    <label class="form-label m-0 ml-10px">Seg</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="tuesday" />
                                    <label class="form-label m-0 ml-10px">Ter</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="wednesday" />
                                    <label class="form-label m-0 ml-10px">Qua</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="thursday" />
                                    <label class="form-label m-0 ml-10px">Qui</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="friday" />
                                    <label class="form-label m-0 ml-10px">Sex</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="saturday" />
                                    <label class="form-label m-0 ml-10px">Sab</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid d-flex align-items-center gap-5px">
                                    <input name="weekdays[]" class="form-check-input" type="checkbox" value="sunday" />
                                    <label class="form-label m-0 ml-10px">Dom</label>
                                </div>
                            </div>

                            <div id="eventStopRepetitionWrapper"
                                class="d-flex align-items-center justify-content-between mb-20px d-none">
                                <div class="col-4">
                                    <label class="form-label m-0">Parar Repetição</label>
                                </div>

                                <div class="col-8 d-flex gap-20px">
                                    <div class="w-48">
                                        <input name="stop_repetition" type="text"
                                            class="form-control form-control-solid stop-repetition"
                                            placeholder="Selecione o dia" />
                                    </div>
                                </div>
                            </div>

                            <div id="eventDaysWrapper"
                                class="d-flex align-items-center justify-content-between mb-20px d-none">
                                <div class="col-4">
                                    <label class="form-label m-0 required">Dia(s)</label>
                                </div>

                                <div class="col-8 d-flex">
                                    <div class="w-100">
                                        <input name="event_days" type="text" class="form-control form-control-solid days"
                                            placeholder="Selecione os dias" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <div class="d-flex gap-10px">
                                <button type="button" id="deleteBtn" class="btn bg-white text-danger d-none"
                                    style="width: 100px; margin-right: 10px;">Excluir</button>
                            </div>
                            <div class="d-flex gap-10px">
                                <button type="button" class="btn bg-light text-gray-600" data-bs-dismiss="modal"
                                    style="width: 100px; margin-right: 10px;">Cancelar</button>
                                <button type="button" id="saveEventBtn" class="default-btn bg-primary text-white"
                                    style="width: 100px;">
                                    <span class="indicator-label">Salvar</span>
                                </button>
                                <button type="button" id="updateEventBtn" class="default-btn bg-primary text-white d-none"
                                    style="width: 100px;">
                                    <span class="indicator-label">Salvar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('extra-plugins')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>
@endsection
@section('extra-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const classroomFilter = $('#classroom_filter');
        const eventClassroom = $('select[name="event_classroom"]');
        const eventName = $('input[name="event_name"]');
        const eventColor = $('input[name="event_color"]');
        const eventStart = $('input[name="event_start"]');
        const eventEnd = $('input[name="event_end"]');
        const eventMonths = $('.months');
        const eventRepeatWrapper = $('#eventRepeatWrapper');
        const eventRepeat = $('#repeat');
        const eventWeekdaysWrapper = $('#eventWeekdaysWrapper');
        const eventWeekdays = $('input[name="weekdays[]"]');
        const eventDaysWrapper = $('#eventDaysWrapper');
        const eventDays = $('input[name="event_days"]');
        const eventStopRepetitionWrapper = $('#eventStopRepetitionWrapper');
        const eventStopRepetition = $('input[name="stop_repetition"]');

        function setFlatpickrs(dates, daysInputMode = "single", weekdays = [], repeat = '', stopRepetition = '', selectedDays = []) {
            let allowedMonths = dates.map(date => {
                let [month, year] = date.split('/');
                return new Date(year, month - 1);
            }).sort((a, b) => a - b);

            function isDateAllowed(date) {
                return allowedMonths.some(month => {
                    return date.getFullYear() === month.getFullYear() && date.getMonth() === month.getMonth();
                });
            }

            const dayNames = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            let allowedWeekdays = weekdays.map(day => dayNames.indexOf(day.toLowerCase()));

            let stopRepetitionDate = stopRepetition ? new Date(stopRepetition.split('/').reverse().join('-')) : null;

            let lastMonth = allowedMonths[allowedMonths.length - 1];
            let lastDayOfMonth = new Date(lastMonth.getFullYear(), lastMonth.getMonth() + 1, 0);

            function getPreselectedDates() {
                let preselectedDates = [];

                allowedMonths.forEach(month => {
                    let year = month.getFullYear();
                    let monthIndex = month.getMonth();

                    allowedWeekdays.forEach(dayOfWeek => {
                        let firstDay = new Date(year, monthIndex, 1);
                        while (firstDay.getDay() !== dayOfWeek && firstDay.getMonth() === monthIndex) {
                            firstDay.setDate(firstDay.getDate() + 1);
                        }

                        if (firstDay.getMonth() === monthIndex) {
                            if (!stopRepetitionDate || firstDay <= stopRepetitionDate) {
                                preselectedDates.push(new Date(
                                    firstDay));
                            }

                            let interval = repeat === 'biweekly' ? 14 : (repeat === 'weekly' ? 7 : 0);
                            if (interval > 0) {
                                let nextDate = new Date(firstDay);
                                while (true) {
                                    nextDate.setDate(nextDate.getDate() + interval);
                                    if (nextDate.getMonth() !== monthIndex || (stopRepetitionDate &&
                                            nextDate > stopRepetitionDate)) break;
                                    if (!stopRepetitionDate || nextDate <= stopRepetitionDate) {
                                        preselectedDates.push(new Date(nextDate));
                                    }
                                }
                            }
                        }
                    });
                });

                return preselectedDates;
            }

            let preselectedDates = [];
            if (selectedDays && typeof selectedDays === 'string') {
                preselectedDates = selectedDays.split(',').map(d => {
                    const [day, month, year] = d.trim().split('/');
                    let date = new Date(`${year}-${month}-${day}T00:00:00`);
                    return date;
                });
            } else {
                // Caso contrário, usamos a lógica de getPreselectedDates()
                preselectedDates = getPreselectedDates();
            }

            let eventDaysFp = eventDays.flatpickr({
                mode: daysInputMode,
                dateFormat: "d/m/Y",
                allowInput: true,
                locale: {
                    weekdays: {
                        shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                        longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira',
                            'Quinta-feira', 'Sexta-feira', 'Sábado'
                        ],
                    },
                    months: {
                        shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                            'Out', 'Nov', 'Dez'
                        ],
                        longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ],
                    },
                    rangeSeparator: ' até ',
                    weekAbbreviation: 'Sem',
                },
                enable: [
                    function(date) {
                        return isDateAllowed(date);
                    }
                ],
                defaultDate: preselectedDates
            });

            let stopRepetitionFp = eventStopRepetition.flatpickr({
                dateFormat: "d/m/Y",
                allowInput: true,
                defaultDate: stopRepetition == '' ? lastDayOfMonth : stopRepetition,
                locale: {
                    weekdays: {
                        shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                        longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira',
                            'Quinta-feira', 'Sexta-feira', 'Sábado'
                        ],
                    },
                    months: {
                        shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                            'Out', 'Nov', 'Dez'
                        ],
                        longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ],
                    },
                    rangeSeparator: ' até ',
                    weekAbbreviation: 'Sem',
                },
                enable: [
                    function(date) {
                        return isDateAllowed(date);
                    }
                ]
            });
        }


        $(document).ready(function() {

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                dayMaxEvents: 4, // Limite de eventos,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay"
                },
                customButtons: {
                    today: {
                        text: 'Hoje',
                        click: function() {
                            calendar.today();
                        }
                    }
                },
                views: {
                    dayGridMonth: {
                        buttonText: "Mês"
                    },
                    timeGridWeek: {
                        buttonText: "Semana"
                    },
                    timeGridDay: {
                        buttonText: "Dia"
                    },
                    listMonth: {
                        buttonText: "Lista"
                    }
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                locale: 'pt-br',
                dayHeaderContent: function(args) {
                    var translatedDays = @json(__('calendar.weekdays'));
                    var dayIndex = args.date.getUTCDay();

                    if (dayIndex === 0) {
                        dayIndex = 6;
                    } else {
                        dayIndex -= 1;
                    }

                    return translatedDays[dayIndex];
                },
                datesSet: function(dateInfo) {
                    var view = calendar.view;
                    var year = new Date(view.calendar.getDate()).getFullYear();
                    var monthIndex = new Date(view.calendar.getDate()).getMonth();

                    var translatedMonths = @json(__('calendar.months'));

                    var title = translatedMonths[monthIndex] + " " + year;

                    adjustMaxEventsAndMoreLinkText();
                    getCalendarEvents();
                },
                dateClick: function(info) {
                    if (window.innerWidth <= 768) {
                        var eventsForDate = calendar.getEvents().filter(event => {
                            return event.start.getFullYear() === info.date.getFullYear() &&
                                event.start.getMonth() === info.date.getMonth() &&
                                event.start.getDate() === info.date.getDate();
                        });

                        showMoreEventsPopup(info.date, eventsForDate);
                    }
                },
                eventClick: function(info) {
                    if (window.innerWidth <= 768) {
                        var eventsForDate = calendar.getEvents().filter(event => {
                            return event.start.getFullYear() === info.event.start
                                .getFullYear() &&
                                event.start.getMonth() === info.event.start.getMonth() &&
                                event.start.getDate() === info.event.start.getDate();
                        });

                        showMoreEventsPopup(info.event.start, eventsForDate);
                    } else {
                        var eventDate = info.event.start;

                        var formattedDate = eventDate.toLocaleDateString('pt-BR');

                        var dayOfWeek = eventDate.toLocaleDateString('pt-BR', {
                            weekday: 'long'
                        });

                        openEditEventModal(info.event.id, formattedDate);
                    }
                },


                windowResize: function(view) {
                    adjustMaxEventsAndMoreLinkText();
                },

                headerToolbar: {
                    left: "prev,next",
                    center: "title",
                    right: ""
                },
            });

            function showMoreEventsPopup(date, events) {
                var existingPopup = document.querySelector('.more-events-popup');
                if (existingPopup) {
                    existingPopup.parentElement.remove();
                }

                var title = @json(__('calendar.events_on'))

                var popupContent =
                    '<div class="more-events-popup" style="border-radius: 8px; position: relative;">';
                popupContent +=
                    '<button class="close-popup" style="position: absolute; right: -7px; top: -6px; border: none; background: none; font-size: 30px; color: #329fba; cursor: pointer; height: 30px; line-height: 0 !important;">&times;</button>';
                popupContent += '<span style="font-size: 14px; color: #485558; font-weight: 600;">' + title + ' ' +
                    date.toLocaleDateString('pt-BR') + ':</span>';
                popupContent += '<ul style="list-style: none; padding: 0;">';

                events.forEach(function(event) {
                    var eventColor = event.backgroundColor
                    popupContent +=
                        '<li style="margin-top: 10px; margin-left: 10px; display: flex; align-items: center; color: #767F82; font-size: 14px; font-weight: 600">';
                    popupContent +=
                        '<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: ' +
                        eventColor + '; margin-right: 10px;"></span>';
                    popupContent += event.title + ' (' + event.start.toLocaleTimeString('pt-BR') + ')';
                    popupContent += '</li>';
                });

                popupContent += '</ul>';
                popupContent += '</div>';

                var popup = document.createElement('div');
                popup.innerHTML = popupContent;
                popup.style.position = 'absolute';
                popup.style.background = '#fff';
                popup.style.border = '2px solid #ccc';
                popup.style.padding = '10px';
                popup.style.top = '350px';
                popup.style.left = '50px';
                popup.style.zIndex = '10';
                popup.style.borderRadius = '8px';
                popup.style.width = '75%';
                document.body.appendChild(popup);

                var closeButton = popup.querySelector('.close-popup');
                closeButton.addEventListener('click', function() {
                    popup.remove();
                });
            }



            function adjustMaxEventsAndMoreLinkText() {
                if (window.innerWidth <= 768) {
                    calendar.setOption('dayMaxEvents', 20);
                    calendar.setOption('height', 500);
                    calendar.setOption('moreLinkText', 'visualizar');
                    calendar.setOption('moreLinkText', 'visualizar');
                } else {
                    calendar.setOption('dayMaxEvents', 4);
                    calendar.setOption('moreLinkText', function(num) {
                        return num + ' more';
                    });
                }
            }

            adjustMaxEventsAndMoreLinkText();

            calendar.render();

            $(".hour").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            classroomFilter.on('change', function() {
                getCalendarEvents();
            })

            $('#openEventModal').on('click', function() {
                clearEventModal();
                $('#saveEventBtn').removeClass('d-none');
                $('#updateEventBtn').addClass('d-none');
                $('#deleteBtn').addClass('d-none');
                $('#eventModal').modal('show');
            })

            eventColor.mask('XXXXXXX', {
                translation: {
                    'X': {
                        pattern: /[0-9A-Fa-f]/
                    }
                },
            });

            eventColor.on('input', function() {
                var value = $(this).val();
                if (value.charAt(0) !== '#') {
                    $(this).val('#' + value);
                }
            });

            eventColor.on('focus', function() {
                if ($(this).val() === '') {
                    $(this).val('#');
                }
            });

            const monthSelector = $("#month-selector");
            const currentYearSpan = $("#current-year");
            const monthButtonsContainer = $(".month-buttons");
            let currentYear = new Date().getFullYear();
            let selectedMonths = [];

            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            function updateMonthButtons() {
                monthButtonsContainer.empty();
                $.each(months, function(index, month) {
                    const monthYear = `${String(index + 1).padStart(2, '0')}/${currentYear}`;
                    const button = $(`<button class="month-button">${month}</button>`);
                    if (selectedMonths.includes(monthYear)) {
                        button.addClass("selected");
                    }
                    button.on("click", function(event) {
                        event.stopPropagation();
                        if (selectedMonths.includes(monthYear)) {
                            selectedMonths = selectedMonths.filter(m => m !== monthYear);
                        } else {
                            selectedMonths.push(monthYear);
                        }
                        sortSelectedMonths();
                        updateEventMonths();
                        updateMonthButtons();
                    });
                    monthButtonsContainer.append(button);
                });

                eventDaysWrapper.addClass('d-none');
                eventRepeatWrapper.addClass('d-none');
                eventWeekdaysWrapper.addClass('d-none');
                eventStopRepetitionWrapper.addClass('d-none');
                eventRepeat.val('')
                eventDays.val('')
                eventStopRepetition.val('')

                eventWeekdays.each(function() {
                    $(this).prop('checked', false);
                });

                if (selectedMonths.length > 0) {
                    eventRepeatWrapper.removeClass('d-none');
                }
            }

            function sortSelectedMonths() {
                selectedMonths.sort((a, b) => {
                    const [monthA, yearA] = a.split("/").map(Number);
                    const [monthB, yearB] = b.split("/").map(Number);
                    return yearA !== yearB ? yearA - yearB : monthA - monthB;
                });
            }

            function updateEventMonths() {
                eventMonths.val(selectedMonths.join(", "));
            }

            eventMonths.on("click", function(event) {
                event.stopPropagation();
                monthSelector.show();
            });

            $("#prev-year").on("click", function() {
                currentYear--;
                currentYearSpan.text(currentYear);
                updateMonthButtons();
            });

            $("#next-year").on("click", function() {
                currentYear++;
                currentYearSpan.text(currentYear);
                updateMonthButtons();
            });

            monthSelector.on("click", function(event) {
                event.stopPropagation();
            });


            $(document).on("click", function(event) {
                if (!monthSelector.is(event.target) && monthSelector.has(event.target).length === 0 && !
                    eventMonths.is(event.target)) {
                    monthSelector.hide();
                }
            });

            currentYearSpan.text(currentYear);
            updateMonthButtons();

            function openEditEventModal(event_id, day) {
                $.ajax({
                    type: "GET",
                    url: "/calendars/get-event-by-id/" + event_id,
                    dataType: "json",
                    success: function(response) {
                        clearEventModal();
                        $('#event_id').val(event_id);
                        $('#event_day').val(day);
                        if (response.data.all_classrooms == 1) {
                            eventClassroom.val('all');
                        } else {
                            eventClassroom.val(response.data.classroom_id);
                        }
                        eventName.val(response.data.name)
                        eventColor.val(response.data.color)
                        eventStart.val(response.data.start_formatted)
                        eventEnd.val(response.data.end_formatted)
                        eventMonths.val(response.data.months)

                        selectedMonths = response.data.months.split(", ");
                        sortSelectedMonths();
                        updateMonthButtons();

                        eventRepeatWrapper.removeClass('d-none');
                        eventRepeat.val(response.data.repeat);

                        if (response.data.repeat == 'weekly' || response.data.repeat ==
                            'biweekly') {
                            $('#stopRepetitionWrapper').removeClass('d-none');

                            eventWeekdays.each(function() {
                                if (response.data.weekdays.includes($(this).val())) {
                                    $(this).prop('checked', true);
                                }
                            });
                            eventWeekdaysWrapper.removeClass('d-none');
                            eventStopRepetitionWrapper.removeClass('d-none');
                            eventStopRepetition.val(response.data.stop_repetition);
                        }

                        eventDaysWrapper.removeClass('d-none');
                        eventDays.val(response.data.days);

                        $('#saveEventBtn').addClass('d-none');
                        $('#updateEventBtn').removeClass('d-none');
                        $('#deleteBtn').removeClass('d-none');

                        var monthsArray = eventMonths.val().split(',')
                        var selectedWeekDays = [];

                        eventWeekdays.each(function() {
                            if ($(this).is(':checked')) {
                                selectedWeekDays.push($(this).val());
                            }
                        });

                        var daysInputMode = '';

                        if (eventRepeat.val() == 'never') {
                            daysInputMode = 'single';
                        } else {
                            daysInputMode = 'multiple';
                        }

                        setFlatpickrs(monthsArray, daysInputMode, selectedWeekDays, eventRepeat.val(),
                            eventStopRepetition.val(), response.data.days)

                        $('#eventModal').modal('show');
                    }
                });
            }

            eventRepeat.on('change', function() {

                eventWeekdaysWrapper.addClass('d-none');
                eventWeekdays.each(function() {
                    $(this).prop('checked', false);
                });

                eventDaysWrapper.addClass('d-none');
                eventDays.val('');

                eventStopRepetitionWrapper.addClass('d-none');
                eventStopRepetition.val('');


                if ($(this).val() == 'weekly' || $(this).val() == 'biweekly') {
                    var monthsArray = eventMonths.val().split(',')
                    setFlatpickrs(monthsArray)

                    eventWeekdaysWrapper.removeClass('d-none');
                    eventStopRepetitionWrapper.removeClass('d-none');
                    eventDaysWrapper.removeClass('d-none');
                }
                if ($(this).val() == 'never') {
                    var monthsArray = eventMonths.val().split(',')
                    setFlatpickrs(monthsArray)

                    eventDaysWrapper.removeClass('d-none');
                }
            });

            eventWeekdays.on('change', function() {
                var selectedWeekDays = [];

                eventWeekdays.each(function() {
                    if ($(this).is(':checked')) {
                        selectedWeekDays.push($(this).val());
                    }
                });

                if (selectedWeekDays.length > 0) {
                    var monthsArray = eventMonths.val().split(',')
                    setFlatpickrs(monthsArray, "multiple", selectedWeekDays, eventRepeat.val(),
                        eventStopRepetition.val())
                } else {
                    eventDays.val('');
                }
            });

            eventStopRepetition.on('change', function() {
                var monthsArray = eventMonths.val().split(',')
                var selectedWeekDays = [];

                eventWeekdays.each(function() {
                    if ($(this).is(':checked')) {
                        selectedWeekDays.push($(this).val());
                    }
                });
                setFlatpickrs(monthsArray, "multiple", selectedWeekDays, eventRepeat.val(),
                    eventStopRepetition.val())
            });

            function clearEventModal() {
                eventClassroom.val('');
                eventName.val('');
                eventColor.val('');
                eventStart.val('');
                eventEnd.val('');
                eventMonths.val('');

                $('.month-button').removeClass('selected')

                selectedMonths = [];
                sortSelectedMonths();
                updateMonthButtons();

                eventRepeatWrapper.addClass('d-none');
                eventRepeat.val('')
                eventWeekdaysWrapper.addClass('d-none');
                eventWeekdays.each(function() {
                    $(this).prop('checked', false);
                });
                eventDaysWrapper.addClass('d-none');
                eventDays.val('')
                eventStopRepetitionWrapper.addClass('d-none');
                eventStopRepetition.val('')
            }

            function clearInvalidFields() {
                eventClassroom.removeClass('is-invalid border-error');
                eventName.removeClass('is-invalid border-error');
                eventColor.removeClass('is-invalid border-error');
                eventStart.removeClass('is-invalid border-error');
                eventEnd.removeClass('is-invalid border-error');
                eventMonths.removeClass('is-invalid border-error');
                eventRepeat.removeClass('is-invalid border-error');
                eventWeekdays.removeClass('is-invalid border-error');
                eventDays.removeClass('is-invalid border-error');
                eventStopRepetition.removeClass('is-invalid border-error');
            }

            function validateEventFields() {
                clearInvalidFields();

                var errorText = '';

                if (eventClassroom.val() == '') {
                    eventClassroom.addClass('is-invalid border-error');
                    errorText += 'O campo Turma é obrigatório!<br>';
                }

                if (eventName.val() == '') {
                    eventName.addClass('is-invalid border-error');
                    errorText += 'O campo Nome é obrigatório!<br>';
                }

                var hexColorRegex = /^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/;
                var colorValue = eventColor.val();

                if (colorValue === '') {
                    eventColor.addClass('is-invalid border-error');
                    errorText += 'O campo Cor é obrigatório!<br>';
                } else if (!hexColorRegex.test(colorValue)) {
                    eventColor.addClass('is-invalid border-error');
                    errorText += 'O campo Cor deve ser um valor hexadecimal válido!<br>';
                }

                var start = eventStart.val();
                var end = eventEnd.val();

                if (start == '' || end == '') {
                    if (start == '') {
                        eventStart.addClass('is-invalid border-error');
                    }
                    if (end == '') {
                        eventEnd.addClass('is-invalid border-error');
                    }
                    errorText += 'Os campos de Horário são obrigatórios!<br>';
                }

                if (start > end || end == start) {
                    eventStart.addClass('is-invalid border-error');
                    eventEnd.addClass('is-invalid border-error');

                    errorText += 'O início do Horário não pode ser após o fim!<br>';
                }

                if (end == start) {
                    eventStart.addClass('is-invalid border-error');
                    eventEnd.addClass('is-invalid border-error');

                    errorText += 'O início do Horário não pode ser igual ao fim!<br>';
                }

                if (eventMonths.val() == '') {
                    eventMonths.addClass('is-invalid border-error');
                    errorText += 'O campo Meses é obrigatório!<br>';
                } else {
                    if (eventRepeat.val() == '') {
                        eventRepeat.addClass('is-invalid border-error');
                        errorText += 'O campo Repete é obrigatório!<br>';
                    } else {
                        if (eventDays.val() == '') {
                            eventDays.addClass('is-invalid border-error');
                            errorText += 'O campo Dias é obrigatório!<br>';
                        }
                    }
                }

                if (errorText != '') {
                    Swal.fire({
                        html: errorText,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, entendi!",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                    return false;
                }

                return true;
            }

            $('#saveEventBtn').on('click', function() {
                var validation = validateEventFields();

                if (validation) {

                    var weekdays = [];

                    eventWeekdays.each(function() {
                        if ($(this).is(':checked')) {
                            weekdays.push($(this).val());
                        }
                    });

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var requestData = {
                        classroom_id: eventClassroom.val(),
                        name: eventName.val(),
                        color: eventColor.val(),
                        start: eventStart.val(),
                        end: eventEnd.val(),
                        months: eventMonths.val(),
                        repeat: eventRepeat.val(),
                        weekdays: weekdays,
                        days: eventDays.val(),
                        stop_repetition: eventStopRepetition.val(),
                    }

                    $.ajax({
                        type: "POST",
                        url: "/calendars/register-event/",
                        data: requestData,
                        dataType: "json",
                        success: function(response) {
                            if (response.status == 'error') {
                                Swal.fire({
                                    text: response.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, entendi!",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                });
                                return;
                            } else {
                                $('#eventModal').modal('hide');

                                Swal.fire({
                                    text: response.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, entendi!",
                                    customClass: {
                                        confirmButton: "btn bg-primary text-white"
                                    }
                                });

                                clearEventModal();

                                getCalendarEvents();
                            }
                        }
                    });
                }
            })

            $('#updateEventBtn').on('click', function() {
                var validation = validateEventFields();

                if (validation) {
                    $.ajax({
                        type: "GET",
                        url: "/calendars/get-event-by-id/" + $('#event_id').val(),
                        dataType: "json",
                        success: function(response) {
                            if (response.data.repeat != 'never') {
                                Swal.fire({
                                    title: 'Confirmação',
                                    text: "Este evento se repete. Deseja atualizar todos os eventos ou apenas este?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Todos os eventos',
                                    cancelButtonText: 'Apenas este',
                                    customClass: {
                                        confirmButton: 'btn btn-primary',
                                        cancelButton: 'btn btn-secondary'
                                    },
                                    buttonsStyling: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        updateEvent('all');
                                    } else if (result.dismiss === Swal.DismissReason
                                        .cancel) {
                                        updateEvent('single');
                                    }
                                });
                            } else {
                                updateEvent('single');
                            }
                        }
                    });
                }
            })

            function updateEvent(option) {
                var weekdays = [];

                eventWeekdays.each(function() {
                    if ($(this).is(':checked')) {
                        weekdays.push($(this).val());
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var requestData = {
                    option: option,
                    event_id: $('#event_id').val(),
                    event_day: $('#event_day').val(),
                    classroom_id: eventClassroom.val(),
                    name: eventName.val(),
                    color: eventColor.val(),
                    start: eventStart.val(),
                    end: eventEnd.val(),
                    months: eventMonths.val(),
                    repeat: eventRepeat.val(),
                    weekdays: weekdays,
                    days: eventDays.val(),
                    stop_repetition: eventStopRepetition.val(),
                }

                $.ajax({
                    type: "POST",
                    url: "/calendars/update-event/",
                    data: requestData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'error') {
                            Swal.fire({
                                text: response.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, entendi!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                }
                            });
                            return;
                        } else {
                            $('#eventModal').modal('hide');

                            getCalendarEvents();

                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, entendi!",
                                customClass: {
                                    confirmButton: "btn bg-primary text-white"
                                }
                            });

                            clearEventModal();
                        }
                    }
                });
            }

            $('#deleteBtn').on('click', function() {
                $.ajax({
                    type: "GET",
                    url: "/calendars/get-event-by-id/" + $('#event_id').val(),
                    dataType: "json",
                    success: function(response) {
                        if (response.data.repeat != 'never') {
                            Swal.fire({
                                title: 'Confirmação',
                                text: "Este evento se repete. Deseja excluir todos os eventos ou apenas este?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Todos os eventos',
                                cancelButtonText: 'Apenas este',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                    cancelButton: 'btn btn-secondary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    deleteEvent('all');
                                } else if (result.dismiss === Swal.DismissReason
                                    .cancel) {
                                    deleteEvent('single');
                                }
                            });
                        } else {
                            deleteEvent('single');
                        }
                    }
                });
            })

            function deleteEvent(option) {
                var weekdays = [];

                eventWeekdays.each(function() {
                    if ($(this).is(':checked')) {
                        weekdays.push($(this).val());
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var requestData = {
                    option: option,
                    event_id: $('#event_id').val(),
                    event_day: $('#event_day').val(),
                }

                $.ajax({
                    type: "POST",
                    url: "/calendars/delete-event/",
                    data: requestData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'error') {
                            Swal.fire({
                                text: response.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, entendi!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                }
                            });
                            return;
                        } else {
                            $('#eventModal').modal('hide');

                            getCalendarEvents();

                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, entendi!",
                                customClass: {
                                    confirmButton: "btn bg-primary text-white"
                                }
                            });

                            clearEventModal();
                        }
                    }
                });
            }

            function getCalendarEvents() {
                calendar.removeAllEvents();
                var view = calendar.view;
                var month = String(new Date(view.calendar.getDate()).getMonth() + 1).padStart(2, '0');
                var year = new Date(view.calendar.getDate()).getFullYear();
                var classroom = $('#classroom_filter').val();

                $.ajax({
                    type: "GET",
                    url: `/calendars/get-events/${classroom}/${month}/${year}`,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            response.data.forEach(function(data) {
                                var days = data.days.split(',');
                                var events = days.map(day => ({
                                    id: data.id,
                                    title: data.name,
                                    start: eventFormat(day, data.start),
                                    end: eventFormat(day, data.end),
                                    backgroundColor: data.color,
                                    borderColor: data.color,
                                }));
                                calendar.addEventSource(events);
                            });
                        }
                    }
                });
            }

            function eventFormat(date, time) {
                if (typeof date !== 'string' || typeof time !== 'string') {
                    console.error('Invalid date or time format. Expected a string.');
                    return '';
                }

                var splitDate = date.split('/');

                if (splitDate.length !== 3) {
                    console.error('Invalid date format. Expected format: dd/mm/yyyy');
                    return '';
                }

                var day = splitDate[0].trim();
                var month = splitDate[1].trim();
                var year = splitDate[2].trim();

                if (!day || !month || !year) {
                    console.error('Invalid date components. Please check the input.');
                    return '';
                }

                var dateFormatted = year + '-' + month + '-' + day + 'T' + time;
                return dateFormatted;
            }

        });
    </script>
    <script src="{{ asset('js/calendars/index.js') }}?version={{ getAppVersion() }}"></script>
@endsection
