@extends('basico.desktop.base')
@section('title.page')@lang('title.cancelacion')@endsection
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
            <div class="card-header bg-white mt-md-3 border-bottom-0 pb-0">
                <h4 class="text-center">@lang('reserva.pago_cancelado')</h4>
                <hr class="bg-acento">
            </div>
            <div class="card-body text-center">
                <div class="">
                    <p>
                        @lang('reserva.texto_cancelado')
                    </p>
                    <p class="mt-5">
                        @lang('reserva.atentamente'): {{$propiedad->nombre}}
                    </p>
                </div>
            </div>
            <div class="card-footer justify-content-between text-center">
                <button type="button" class="btn btn-primary"
                        onclick="window.location='{{ URL::route('app.inicio', app()->getLocale(),false) }}'">@lang('reserva.finalizar')</button>
            </div>
        </div>
    </div>
@endsection
