@extends('basico.mobile.base')
@section('title.page')@lang('title.modificaciones_complementos')@endsection
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
    <div class="row  bg-light border-bottom border-top m-0">
        <div class="col-12 p-2">
            <h6 class="text-center mb-0 mt-1"><strong>@lang('modificar.menu.modificar'):</strong>
                {{AppModificarReserva::recuperarSesion()->folio}}</h6>
        </div>
    </div>
    @include('basico.mobile.modificar.componentes.floating-detalle-reserva')
    @include('basico.mobile.modificar.componentes.steps')
    <total-tipo-vista-component></total-tipo-vista-component>
    <complemento-component
        :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
        :entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
        :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
        :color_cargador="'{{@$marca->color_acento}}'">
    </complemento-component>
    @include('basico.mobile.modificar.componentes.floating-buttons')
@endsection

