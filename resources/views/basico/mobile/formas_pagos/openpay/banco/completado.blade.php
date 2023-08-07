@extends('basico.mobile.base')
@section('title.page')@lang('title.referencias')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('styles')
    <style>
        .banner-principal {
            display: none !important;
        }
        .sticky-top-steps {
            position: static; !important;
        }
    </style>
@endsection
@section('content')
    <div class="contentConfirmacion">
        <div class="mt-4 card rounded-0 border-0 shadow sidebar">
            @include('basico.mobile.componentes.steps')
            <div class="card-header bg-white mt-md-3 border-bottom-0 pb-0 text-center">
                <h4>@lang('formaspagos.referencia_generada')</h4>
            </div>
            <div class="card-body text-center">
               <a href="{{$formapago->metadatos->recibo_url}}" class="btn btn-secondary" target="_blank">@lang('formaspagos.ver_recibo')</a>
            </div>
            <div class="card-footer justify-content-between text-center">
                <button type="button" class="btn btn-primary"
                        onclick="window.location='{{ $redireccion }}'">@lang('reserva.finalizar')</button>
            </div>
        </div>
    </div>
@endsection

