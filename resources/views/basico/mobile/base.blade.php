<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', $propiedad->nombre) - @yield('title.page')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (App::environment('local'))
        <meta name="robots" content="noindex,nofollow">
    @endif
    <link rel="icon" type="image/png" href="{{ $marca->favicon_url }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/temas/basico/dist/mobile/css/app.css">
    <link rel="stylesheet" href="/recursos/mobiscroll/mobiscroll.min.css">
    <link rel="stylesheet" href="/recursos/fontawesome/css/all.css">
    <link rel="stylesheet" href="/recursos/boostrap/css/bootstrap.css">
    <link rel="stylesheet" href="/recursos/bootstrap-select/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/recursos/touchspin/jquery.bootstrap-touchspin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="/recursos/custom-scrollbar/jquery.mCustomScrollbar.min.css">
    @yield('styles')
    <style type="text/css">#modalSesion{background: rgba(0,0,0,0.5);}</style>
    <link rel="stylesheet" href="{{ route('app.estilos', app()->getLocale(),false) }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/recursos/dist/js/html5shiv.js"></script>
    <script src="/recursos/dist/js/respond.min.js"></script>
    <![endif]-->
    <!-- configuracion de la variable del lang para el Vue -->
    <script>
        //API
        window.url_cotizacion_simple = '{{route('api.cotizacion.simple',app()->getLocale(), false)}}';
        window.url_cotizacion_multipe = '{{route('api.cotizacion.multiple',app()->getLocale(),false)}}';
        window.url_carrito_resumen = '{{route('api.carrito.resumen',app()->getLocale(),false)}}';
        window.url_carrito_lista = '{{route('api.carrito.lista',app()->getLocale(),false)}}';
        window.url_carrito_agregar = '{{route('api.carrito.elemento.agregar',app()->getLocale(),false)}}';
        window.url_carrito_remover = '{{route('api.carrito.elemento.remover',app()->getLocale(),false)}}';
        window.url_carrito_limpiar = '{{route('api.carrito.remover.limpiar',app()->getLocale(),false)}}';
        window.url_complemento = '{{route('api.carrito.complemento',app()->getLocale(),false)}}';
        window.url_complemento_cotizar = '{{route('api.carrito.complemento.cotizar',app()->getLocale(),false)}}';
        window.url_carrito_complemento_agregar = '{{route('api.carrito.complemento.agregar',app()->getLocale(),false)}}';
        window.url_carrito_complemento_remover = '{{route('api.carrito.complemento.remover',app()->getLocale(),false)}}';
        window.url_get_moneda_actual = '{{route('api.moneda.actual',app()->getLocale(),false)}}';
        window.url_set_moneda_actual = '{{route('api.cambiar.moneda.actual',app()->getLocale(),false)}}';
        window.url_get_sesion = '{{route('api.sesion',[],false)}}';
        window.lang = '{{app()->getLocale()}}';


        window.url_preparar_pago = '{{route('api.preparar.pago',app()->getLocale(),false)}}';
        window.url_get_restricciones = '{{route('api.restricciones',app()->getLocale(),false)}}';
        window.url_get_restricciones_calendario = '{{route('api.restricciones-calendario',app()->getLocale(),false)}}';
        window.url_get_impuestos = '{{route('api.impuestos',app()->getLocale(),false)}}';
        window.url_get_propinas = '{{route('api.propinas',app()->getLocale(),false)}}';
        window.url_get_titulos = '{{route('api.titulos',app()->getLocale(),false)}}';
        window.url_get_paises = '{{route('api.paises',app()->getLocale(),false)}}';
        window.url_create_reserva = '{{route('api.reserva.crear',app()->getLocale(),false)}}';

        window.url_reeenviar_reserva = '{{route('api.reserva.reenviar.correo',app()->getLocale(),false)}}';
        window.url_actualizar_datos_personales = '{{route('api.reserva.actualizar.datos.personales',app()->getLocale(),false)}}';
        window.url_modificar_reserva = '{{route('api.reserva.modificar',app()->getLocale(),false)}}';

    </script>
    <script src="/recursos/js/jquery-3.5.1.js"></script>
    @yield('scripts_header')
    @yield('scripts_header_bottom')
</head>


<body>
<div id="appMobile">
    @include('basico.mobile.componentes.header')
    {{--    @include('basic.mobile.componentes.banner')--}}
    <div class="wrapper" style="{{('app.inicio' == Route::currentRouteName())? 'margin-bottom: 40px;': ''}}">
        <div class="text-center mt-4 loading d-none">
            <div class="spinner-border text-acento " style="width: 4rem; height: 4rem;" role="status">
            </div>
        </div>
        @yield('calendar')
        @yield('content')
    </div>
    @include('basico.mobile.componentes.modal-politica')
    @include('basico.mobile.componentes.modal-privacidad')
    @include('basico.mobile.componentes.selector-idiomas')
    @include('basico.mobile.componentes.selector-monedas')
    @include('basico.mobile.componentes.filtros')
    @if(AppModificarReserva::existeSesion())
        @include('basico.mobile.modificar.componentes.carrito')
    @else
        @include('basico.mobile.componentes.carrito')
    @endif

</div>

{{-- @if('app.inicio' != Route::currentRouteName())
     @include('basic.mobile.componentes.floating-buttons')
 @endif--}}

@yield('modals')
@include('basico.desktop.componentes.modal-sesion')
{{--@include('basic.mobile.componentes.footer')--}}
<script src="/recursos/js/jquery-ui.js"></script>
<script src="/recursos/boostrap/js/popper.js"></script>
<script src="/recursos/boostrap/js/bootstrap.js"></script>
@include('basico.mobile.componentes.footer')
@include('basico.mobile.componentes.ubicacion')

<script src="/recursos/bootstrap-select/js/bootstrap-select.js"></script>
<script src="/recursos/mobiscroll/mobiscroll.min.js"></script>
<script src="/recursos/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/recursos/bootstrap-input-spinner/bootstrap-input-spinner.js"></script>
<script type="text/javascript" src="/recursos/touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="/temas/basico/js/basico.js"></script>
<script src="/temas/basico/dist/mobile/vue/app.js"></script>
<script type="text/javascript" src="/temas/basico/js/complementos.js"></script>
@yield('scripts')
{{--pasarelas--}}
@yield('scripts_conekta')
@yield('scripts_openpay')
@yield('scripts_stripe')
@yield('scripts_paypal')



{{--GARANTIA--}}
@yield('script_tarjeta')

{{--STRIPE--}}
@yield('script_stripe_token')
{{--CONEKTA--}}
@yield('script_conekta_token')
@yield('script_conekta_oxxo')
@yield('script_conekta_spei')
{{--OPENPAY--}}
@yield('script_openpay_token')
@yield('script_openpay_3dsecure')
@yield('script_openpay_tienda')
@yield('script_openpay_banco')
{{--PAYPAL--}}
@yield('script_paypal_paypal-plus')
@yield('script_paypal_paypal-checkout')


@yield('scripts_body_bottom')

<script type="text/javascript">
    function continuarSesion() {
        location.reload();
    }

    $(document).ready(function () {

        var minutos = 5;
        setInterval(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    url: window.url_get_sesion,
                    method: "post",
                    success: function (response) {
                        if (response.vigente === false) {
                            $('#modalSesion').modal('show', {backdrop: 'static', keyboard: false})
                        }
                    },
                    error:
                        function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + " -> " + errorThrown);
                        }
                }
            );
        }, minutos * 60 * 1000);

        // sidebar
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .sidebar-overlay, [data-sidebar-close="sidebar"]').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.sidebar-overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.sidebar-overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        $('.input-spinner').inputSpinner({
            buttonsClass: "btn-light border"
        });


        // Flaoting buttons
        if ($('.floating-footer').length > 0) {
            $('#footer').css({'margin-bottom': '40px'});
        }

        $('.floating-footer span.toggler').on('click', function () {
            if ($('.floating-footer').hasClass('hidden')) {
                $('#footer').css({'margin-bottom': '40px'});
                $('.floating-footer').removeClass('hidden');
            } else {
                $('#footer').css({'margin-bottom': 0});
                $('.floating-footer').addClass('hidden');
            }
        });
    });
</script>
@if (App::environment('production'))
    {{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-11193429-14"></script>--}}
    {{--<script>--}}
    {{--window.dataLayer = window.dataLayer || [];--}}
    {{--function gtag() {--}}
    {{--dataLayer.push(arguments);--}}
    {{--}--}}
    {{--gtag('js', new Date());--}}
    {{--gtag('config', 'UA-11193429-14');--}}
    {{--</script>--}}
@endif
</body>
</html>
