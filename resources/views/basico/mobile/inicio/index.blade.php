@extends('basico.mobile.base')
@section('title.page')@lang('title.inicio')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('calendar')
@endsection
@section('content')
    <div class="">
        {{--        {{dd(AppMonedas::getMonedaActual())}}--}}
        @include('basico.mobile.componentes.calendar')
    </div>
@endsection
@section('styles')
    <style>
        body {
            background-color: white !important;
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        (function () {

            var FechaNoches = parseInt({{AppBusqueda::recuperarBusqueda()->getNoches()}});
            var FechaString = "{{AppBusqueda::recuperarBusqueda()->getLlegada()}}";
            var Adultos = parseInt({{AppBusqueda::recuperarBusqueda()->getAdultos()}});
            var Ninos1 = parseInt({{AppBusqueda::recuperarBusqueda()->getNinos1()}});
            var Ninos2 = parseInt({{AppBusqueda::recuperarBusqueda()->getNinos2()}});
            var Ninos3 = parseInt({{AppBusqueda::recuperarBusqueda()->getNinos3()}});
            var nochesMax = parseInt({{$propiedad->estancia_maxima}});

            var fechaActual = convertDateMysqltoDate("{{AppBusqueda::recuperarBusqueda()->getActual()}}");  
            var FechaAMin = new Date(Date.UTC(fechaActual.getFullYear(), fechaActual.getMonth(), fechaActual.getDate(), 12, 0, 0, 0));
    
            var minDate = FechaAMin; 

            var calendar = $("#calendar").mobiscroll().range({
                theme: "default",
                display: "bottom",
                lang: '{{app()->getLocale()}}',
                startInput: "#checkin-calendar",
                endInput: "#checkout-calendar",
                minRange: msDay,
                maxRange: maxNights * msDay,
                dateFormat: dateFormat,
                min: minDate,
                //max: maxDate,
                firstDay: 0,
                closeOnOverlayTap: true,
                months: displayMonths,
                buttons: false,
                onMarkupReady: function (event, inst) {
                    setLabelPromo(inst);
                    let parts = FechaString.split('-');
                    loadInvalidDates(parseInt(parts[0]), parseInt(parts[1]), FechaNoches, inst);
                },
                onShow: function (event, inst) {
                    inst.setVal([
                        parseDate($("#checkin").val()),
                        parseDate($("#checkout").val())
                    ]);
                },
                onMonthLoaded: function (event, inst) {
                    // loadInvalidDates(event.year, event.month, inst);
                },
                onSetDate: function (event, inst) {
                    if (event.control == 'calendar') inst.select();
                },
                onSet: function (dateText, inst) {
                    var dates = inst.getVal();
                    var texto = "{{ trans('calendar.estancia_maxima',['noches'=>$propiedad->estancia_maxima]) }}";
                    let noches = dateDiff(inst.getVal()[0], inst.getVal()[1]);
                    let fechaSalidaMax = addDate(inst.getVal()[0], nochesMax);
                    if (noches-1 > nochesMax) {
                        alert(texto);
                        fillDateBox("#checkin-calendar", dates[0], "{{app()->getLocale()}}");
                        fillDateBox("#checkout-calendar", fechaSalidaMax, "{{app()->getLocale()}}");
                        fillNightBox(dates[0], fechaSalidaMax);
                    } else {
                        fillDateBox("#checkin-calendar", dates[0], "{{app()->getLocale()}}");
                        fillDateBox("#checkout-calendar", dates[1], "{{app()->getLocale()}}");
                        fillNightBox(dates[0], dates[1]);
                    }
                }
            });

            $("#frmCheck").submit(function () {
                confirmExit = false;
                $("#loader").fadeIn('fast');
            });

            // Inicializar los valores del calendario.
            var checkin = parseDate($("#checkin").val()),
                checkout = parseDate($("#checkout").val());
            calendar.mobiscroll('setVal', [checkin, checkout]);
            fillDateBox("#checkin-calendar", checkin, "{{app()->getLocale()}}");
            fillDateBox("#checkout-calendar", checkout, "{{app()->getLocale()}}");
            fillNightBox(checkin, checkout);
            $("[name=adults]").val(Adultos);
            $("[name=children1]").val(Ninos1);
            $("[name=children2]").val(Ninos2);
            $("[name=children3]").val(Ninos3);

            $('.btn-primary.cargador').click(function (e) {
                $('.loading').removeClass('d-none');
            });
        })();

    </script>
@endsection
@section('modals')
@endsection

