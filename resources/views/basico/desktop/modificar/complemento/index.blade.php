@extends('basico.desktop.base')
@section('title.page')@lang('title.modificaciones_complementos')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('content')
    <div class="row mt-3">
        <div class="col-md-9 pr-3">
            @include('basico.desktop.modificar.componentes.steps')
            <complemento-component
                :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
                :entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :color_cargador="'{{@$marca->color_acento}}'">
            </complemento-component>
        </div>
        <div class="col-md-3 p-0 sticky">
            <modificar-carrito-reservas-component
                :reserva="{{json_encode(AppModificarReserva::recuperarSesion(),true)}}"
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}"
                :monedas="{{json_encode(AppMonedas::getMonedas(),true)}}"
                :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
                :color_cargador="'{{@$marca->color_acento}}'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :codigo_promocion="'{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}'"
                :next_url="'{{ route('modificar.informacion',app()->getLocale(),false)}}'"
                :prev_url="'{{ route('modificar.disponibilidad',[
                                'locale'=>app()->getLocale()
                               ],false)}}'"
                :step="'complementos'">
            </modificar-carrito-reservas-component>
            <modal-carrito-detalle-noches-component
                :step="'complementos'"
                :color_cargador="'{{@$marca->color_acento}}'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
            </modal-carrito-detalle-noches-component>
            <modal-carrito-detalle-complemento-component
                :step="'complementos'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
            </modal-carrito-detalle-complemento-component>
        </div>
    </div>
@endsection
