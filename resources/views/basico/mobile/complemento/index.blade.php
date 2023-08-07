@extends('basico.mobile.base')
@section('title.page')@lang('title.complementos')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('scripts')
    <script type="text/javascript">
        (function () {
            // Inicializar los valores del calendario.
            fillDateBox("#checkin-detail", parseDate('{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'), '{{app()->getLocale()}}');
            fillDateBox("#checkout-detail", parseDate('{{AppBusqueda::recuperarBusqueda()->getSalida()}}'), '{{app()->getLocale()}}');
        })();

    </script>
@endsection
@section('content')
    @include('basico.mobile.componentes.floating-detalle-reserva')
    @include('basico.mobile.componentes.steps')
    <total-tipo-vista-component></total-tipo-vista-component>
    <complemento-component
        :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
        :entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
        :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
        :color_cargador="'{{@$marca->color_acento}}'">
    </complemento-component>
    @include('basico.mobile.componentes.floating-buttons')
@endsection

