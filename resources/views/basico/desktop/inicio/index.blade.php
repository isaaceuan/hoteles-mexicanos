@extends('basico.desktop.base')
@section('title.page')@lang('title.inicio')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('calendar')
    @include('basico.desktop.componentes.calendar')
@endsection
@section('content')

    <div class="contentInicio">
        <div class="row">
            <div class="col-md-12 pr-0">
                <div class="card rounded-0 border-0 shadow">
                    <div class="card-header bg-white mt-md-3 border-bottom-0 pb-0">
                        <h4 class="text-center">{{$propiedad->nombre}}</h4>
                        <hr class="bg-acento">
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <h4>@lang('footer.politicas')</h4>
                            <div class="text-dark">{!!$propiedad->politica_general!!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('styles')
@endsection
@section('scripts')
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--                $("#demo").mobiscroll().range({--}}
{{--                    startInput: '#startHome',--}}
{{--                    endInput: '#endHome',--}}
{{--                    theme: 'mobiscroll',--}}
{{--                    months: 2,--}}
{{--                    closeOnSelect: true,--}}
{{--                    display: ($(window).width() <= 360) ? 'bottom' : 'bubble',--}}
{{--                    dateFormat: 'yy-mm-dd',--}}
{{--                    lang: "{{app()->getLocale()}}",--}}
{{--                });--}}

{{--            $(' #demo').mobiscroll("setVal", [new Date(), new Date()], true)--}}
{{--        });--}}
{{--        </script>--}}
        <script>
        /**
         * Si existe datos en la sesion de fechas los setea, si no, el controlador de la ruta crea una por default.
         * */
        var FechaNoches = parseInt({{AppBusqueda::recuperarBusqueda()->getNoches()}});
        var Adultos = parseInt({{AppBusqueda::recuperarBusqueda()->getAdultos()}});
        var Ninos1 = parseInt({{AppBusqueda::recuperarBusqueda()->getNinos1()}});
        var Ninos2 = parseInt({{AppBusqueda::recuperarBusqueda()->getNinos2()}});
        var Ninos3 = parseInt({{AppBusqueda::recuperarBusqueda()->getNinos3()}});
        var FechaString = "{{AppBusqueda::recuperarBusqueda()->getLlegada()}}";
        var FechaE = convertDateMysqltoDate("{{AppBusqueda::recuperarBusqueda()->getLlegada()}}");
        var FechaEMin = new Date(Date.UTC(FechaE.getFullYear(), FechaE.getMonth(), FechaE.getDate(), 12, 0, 0, 0));

        var fechaActual = convertDateMysqltoDate("{{AppBusqueda::recuperarBusqueda()->getActual()}}");  
        var FechaAMin = new Date(Date.UTC(fechaActual.getFullYear(), fechaActual.getMonth(), fechaActual.getDate(), 12, 0, 0, 0));
    
        var minDate = FechaAMin;
        var nochesMax = parseInt({{$propiedad->estancia_maxima}});

        // var cacheDatesInvalid = {},
        //     cacheDatesPromo = {},
        //     reqDates = null;

        function setLabelPromo(calendar) {
            calendar._markup.find(
                '.mbsc-cal-c'
            ).addClass('mbsc-cal-tag-promo');
        }

        $(document).ready(function () {
            $("#demo").mobiscroll().range({
                startInput: '#startHome',
                endInput: '#endHome',
                theme: 'mobiscroll',
                months: 2,
                closeOnSelect: true,
                display: ($(window).width() <= 360) ? 'bottom' : 'bubble',
                min: minDate,
                dateFormat: 'yy-mm-dd',
                lang: "{{app()->getLocale()}}",
                onMarkupReady: function (event, inst) {
                    setLabelPromo(inst);
                    let parts = FechaString.split('-');
                    loadInvalidDates(parseInt(parts[0]), parseInt(parts[1]), FechaNoches, inst);
                },
                onSet: function (event, inst) {
                    var texto = "{{ trans('calendar.estancia_maxima',['noches'=>$propiedad->estancia_maxima]) }}";
                    let noches = dateDiff(inst.getVal()[0], inst.getVal()[1]);
                    if (noches - 1 > nochesMax) {
                        alert(texto);
                        let fechaSalidaMax = addDate(inst.getVal()[0], nochesMax);
                        $(' #demo').mobiscroll("setVal", [inst.getVal()[0], fechaSalidaMax], true)

                    } else if (noches > 1) {
                        $(' #nights').val(noches - 1).change();
                    }
                    inst.hide();

                }

            });
            //establecer noches
            $(' #nights').val(FechaNoches);
            $(' #adults').val(Adultos);
            $(' #children1').val(Ninos1);
            $(' #children2').val(Ninos2);
            $(' #children3').val(Ninos3);
            //obtener la fecha de salida en base a las noches
            let fechaSalida = addDate(FechaEMin, FechaNoches);
            //setear en el rango la fecha de inicio y fin.
            $(' #demo').mobiscroll("setVal", [FechaEMin, fechaSalida], true)

            //si se cambia de noches, cambiar la fecha de slida del rango.
            $(' #nights').change(function () {
                let rango = $(' #demo').mobiscroll("getVal"),
                    noches = $(this).val();
                fechaSalida = addDate(rango[0], noches);
                $(' #demo').mobiscroll("setVal", [rango[0], fechaSalida], true)
            });

            $('.input-group .checkin').click(function () {
                $('.input-group #startHome').click();
                return false;
            });

            $('.input-group .checkout').click(function () {
                $('.input-group #endHome').click();
                return false;
            });

            /**PROMOCION**/

            $(document).on("click", ' .Cpromocion a', function () {
                $(" .inptCpromocion").slideDown("slow");
            });

            $(document).on("click", ' .inptCpromocion button', function () {
                $(" .inptCpromocion").slideUp("slow");
            });
        });
    </script>
@endsection
@section('modals')
@endsection

