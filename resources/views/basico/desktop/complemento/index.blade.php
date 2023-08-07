@extends('basico.desktop.base')
@section('title.page')@lang('title.complementos')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('content')
    <div class="row mt-3">
        <div class="col-md-9 pr-3">
            @include('basico.desktop.componentes.steps')
            <complemento-component
                :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
                :entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :color_cargador="'{{@$marca->color_acento}}'">
            </complemento-component>
        </div>
        <div class="col-md-3 p-0 sticky">
            <carrito-reservas-component
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}"
                :monedas="{{json_encode(AppMonedas::getMonedas(),true)}}"
                :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
                :color_cargador="'{{@$marca->color_acento}}'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :codigo_promocion="'{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}'"
                :next_url="'{{ route('app.informacion',app()->getLocale(), false)}}'"
                :prev_url="'{{ route('app.disponibilidad',[
                                'locale'=>app()->getLocale(),
                               'checkin'=>AppBusqueda::recuperarBusqueda()->getLlegada(),
                               'checkout'=>AppBusqueda::recuperarBusqueda()->getSalida(),
                               'nights'=>AppBusqueda::recuperarBusqueda()->getNoches(),
                               'adults'=>AppBusqueda::recuperarBusqueda()->getAdultos(),
                               'children1'=>AppBusqueda::recuperarBusqueda()->getNinos1(),
                               'children2'=>AppBusqueda::recuperarBusqueda()->getNinos2(),
                               'children3'=>AppBusqueda::recuperarBusqueda()->getNinos3(),
                               'promocode'=>AppBusqueda::recuperarBusqueda()->getPromoCode()
                               ], false)}}'"
                :step="'complementos'">
            </carrito-reservas-component>
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
