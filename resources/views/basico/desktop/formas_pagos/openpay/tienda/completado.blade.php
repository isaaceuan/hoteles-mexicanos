@extends('basico.desktop.base')
@section('title.page')@lang('title.referencias')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('styles')
    <style>
        .contentBannerPrincipal {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="contentConfirmacion">
        <div class="mt-4 card rounded-0 border-0 shadow sidebar">
            @include('basico.desktop.componentes.steps')
            <div class="card-header bg-white mt-md-3 border-bottom-0 pb-0 text-center">
                <h4>@lang('formaspagos.referencia_generada')</h4>
            </div>
            <div class="card-body text-center">
               <a href="{{$formapago->metadatos->recibo_url}}" class="btn btn-secondary" target="_blank">@lang('formaspagos.ver_recibo')</a>
                <div class="mt-3">
                    <h5>@lang('formaspagos.localizar_paynets')</h5>
                    <iframe src="https://www.paynet.com.mx/mapa-tiendas/index.html" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="card-footer justify-content-between text-center">
                <button type="button" class="btn btn-primary"
                        onclick="window.location='{{ $redireccion }}'">@lang('reserva.finalizar')</button>
            </div>
        </div>
    </div>
@endsection

