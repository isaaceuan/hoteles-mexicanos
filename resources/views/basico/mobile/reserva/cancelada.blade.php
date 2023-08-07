@extends('basico.mobile.base')
@section('title.page')@lang('title.cancelacion')@endsection
@section('styles')
    <style>
        .sticky-top-steps {
            position: static;
        !important;
        }

        .iconoHeaderCarrito {
            display: none !important;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        body {
            background-color: #FFFFFF !important;
        }
    </style>
@endsection
@section('content')
    <div class="contentConfirmacion">
        <div class="mt-4 card rounded-0 border-0 shadow sidebar">
            @include('basico.mobile.componentes.steps')
            <div class="card-header bg-white mt-md-3 border-bottom-0 pb-0">
                <h5 class="text-center">@lang('reserva.pago_cancelado')</h5>
                {{--                <hr class="bg-acento">--}}
            </div>
            <div class="card-body text-center">
                <div class="">
                    <p>
                        @lang('reserva.texto_cancelado')
                    </p>
                    {{--                    <p class="mt-5">--}}
                    {{--                        @lang('reserva.atentamente'): {{$propiedad->nombre}}--}}
                    {{--                    </p>--}}
                </div>
            </div>
            <div class="card-footer justify-content-between text-center">
                <button type="button" class="btn btn-primary btn-sm"
                        onclick="window.location='{{ URL::route('app.inicio',app()->getLocale(),false) }}'">@lang('reserva.finalizar')</button>
            </div>
        </div>
    </div>
@endsection
