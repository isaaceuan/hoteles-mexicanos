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
        window.lang = '{{app()->getLocale()}}';
        window.url_get_sesion = '{{route('api.sesion',[],false)}}';
        window.url_reeenviar_reserva = '{{route('api.reserva.reenviar.correo',app()->getLocale(),false)}}';
        window.url_actualizar_datos_personales = '{{route('api.reserva.actualizar.datos.personales',app()->getLocale(),false)}}';
    </script>

    <script src="/recursos/js/jquery-3.5.1.js"></script>
    @yield('scripts_header')
    @yield('scripts_header_bottom')
</head>
<body>
<div id="app">
    @include('basico.desktop.componentes.header')
    <div class="container p-0">
        <div class="text-center mt-4 loading d-none">
            <div class="spinner-border text-acento " style="width: 4rem; height: 4rem;" role="status">
            </div>
        </div>
        @yield('content')
    </div>
</div>
@yield('modals')
@include('basico.desktop.modificar.componentes.modal-sesion')
@include('basico.desktop.componentes.footer')
<script src="/recursos/js/jquery-ui.js"></script>

<script src="/recursos/boostrap/js/popper.js"></script>
<script src="/recursos/boostrap/js/bootstrap.js"></script>
<script src="/recursos/bootstrap-select/js/bootstrap-select.js"></script>
<script src="/recursos/mobiscroll/mobiscroll.min.js"></script>
<script src="/temas/basico/js/basico.js"></script>
<script src="/temas/basico/dist/desktop/vue/app.js"></script>
<script type="text/javascript" src="/recursos/touchspin/jquery.bootstrap-touchspin.js"></script>
<script type="text/javascript" src="/temas/basico/js/complementos.js"></script>

@yield('scripts')

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
