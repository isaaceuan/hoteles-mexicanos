@extends('basico.mobile.base')
@section('title.page')@lang('title.disponibilidad')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('content')
    @include('basico.mobile.componentes.floating-detalle-reserva')
    @include('basico.mobile.componentes.steps')
    <total-tipo-vista-component></total-tipo-vista-component>
    <disponibilidad-component
        :propiedad="{{json_encode($propiedad,true)}}"
        :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
        :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
        :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
        :adultos="{{AppBusqueda::recuperarBusqueda()->getAdultos()}}"
        :ninos_1="{{AppBusqueda::recuperarBusqueda()->getNinos1()}}"
        :ninos_2="{{AppBusqueda::recuperarBusqueda()->getNinos2()}}"
        :ninos_3="{{AppBusqueda::recuperarBusqueda()->getNinos3()}}"
        :codigo_promocion="'{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}'"
        :color_cargador="'{{@$marca->color_acento}}'">
    </disponibilidad-component>
    @include('basico.mobile.componentes.floating-buttons')
@endsection

@section('styles')
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
            fillDateBox("#checkin-calendar", checkin, '{{app()->getLocale()}}');
            fillDateBox("#checkout-calendar", checkout, '{{app()->getLocale()}}');
            fillDateBox("#checkin-detail", checkin, '{{app()->getLocale()}}');
            fillDateBox("#checkout-detail", checkout, '{{app()->getLocale()}}');
            fillNightBox(checkin, checkout);
            $("[name=adults]").val(Adultos);
            $("[name=children1]").val(Ninos1);
            $("[name=children2]").val(Ninos2);
            $("[name=children3]").val(Ninos3);
        })();

    </script>
@endsection

@section('modals')

    <nav class="fullbar fullbar bg-white collapse" id="collapseCalendar">
        <nav class="navbar navbar-expand-lg bg-light p-2 fixed-top">
            <h5 class="m-2">@lang('disponibilidad.consultar')</h5>
            <a class="btn position-absolute" style="right: 0.5em; top:0.5em;" data-toggle="collapse"
               href="#collapseCalendar" role="button" aria-expanded="true" aria-controls="collapseCalendar">
                <i class="fas fa-times"></i>
            </a>
        </nav>
        <div class="mt-5 pt-3 mb-4 pb-3">
            @include('basico.mobile.componentes.calendar')
        </div>
    </nav>

@endsection
