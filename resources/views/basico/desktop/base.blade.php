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
    <link rel="stylesheet" href="/temas/basico/dist/desktop/css/app.css">
    <link rel="stylesheet" href="/recursos/mobiscroll/mobiscroll.min.css">
    <link rel="stylesheet" href="/recursos/fontawesome/css/all.css">
    <link rel="stylesheet" href="/recursos/boostrap/css/bootstrap.css">
    <link rel="stylesheet" href="/recursos/bootstrap-select/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/recursos/touchspin/jquery.bootstrap-touchspin.css">
    {{--    <link rel="stylesheet" href="/dist/css/animate.min.css">--}}
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
        window.url_modificar_reserva = '{{route('api.reserva.modificar',app()->getLocale(),false)}}';

    </script>

    <script src="/recursos/js/jquery-3.5.1.js"></script>
    @yield('scripts_header')
    @yield('scripts_header_bottom')
</head>


<body>
<div id="app">
    @include('basico.desktop.componentes.header')
    @include('basico.desktop.componentes.banner')
    <div class="container p-0">
        @yield('calendar')
        @yield('content')
    </div>
</div>
@yield('modals')
@include('basico.desktop.componentes.modal-sesion')
@include('basico.desktop.componentes.footer')
<script src="/recursos/js/jquery-ui.js"></script>

<script src="/recursos/boostrap/js/popper.js"></script>
<script src="/recursos/boostrap/js/bootstrap.js"></script>
<script src="/recursos/bootstrap-select/js/bootstrap-select.js"></script>
<script src="/recursos/mobiscroll/mobiscroll.min.js"></script>
<script src="/temas/basico/js/basico.js"></script>
<script type="text/javascript" src="/recursos/touchspin/jquery.bootstrap-touchspin.js"></script>
<script type="text/javascript" src="/temas/basico/js/complementos.js"></script>

@yield('scripts')
{{--index blade--}}
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
<script>

    $(document).ready(function () {
        $('#startHome').prop('disabled',false);
        $('#endHome').prop('disabled',false);
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

    });
</script>

<script src="/temas/basico/dist/desktop/vue/app.js"></script>
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
