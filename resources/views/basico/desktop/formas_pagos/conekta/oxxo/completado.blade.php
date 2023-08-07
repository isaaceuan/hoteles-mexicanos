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

        .opps {
            width: 496px;
            border-radius: 4px;
            box-sizing: border-box;
            padding: 0 45px;
            margin: 40px auto;
            overflow: hidden;
            border: 1px solid #b0afb5;
            font-family: 'Open Sans', sans-serif;
            color: #4f5365;
        }

        .opps-reminder {
            position: relative;
            top: -1px;
            padding: 9px 0 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            color: #ffffff;
            background: #000000;
        }

        .opps-info {
            margin-top: 26px;
            position: relative;
        }

        .opps-info:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;

        }

        .opps-brand {
            width: 45%;
            float: left;
        }

        .opps-brand img {
            max-width: 150px;
            margin-top: 2px;
        }

        .opps-ammount {
            width: 55%;
            float: right;
        }

        .opps-ammount h2 {
            font-size: 36px;
            color: #000000;
            line-height: 24px;
            margin-bottom: 15px;
        }

        .opps-ammount h2 sup {
            font-size: 16px;
            position: relative;
            top: -2px
        }

        .opps-ammount p {
            font-size: 10px;
            line-height: 14px;
        }

        .opps-reference {
            margin-top: 14px;
        }

        h1 {
            font-size: 27px;
            color: #000000;
            text-align: center;
            margin-top: -1px;
            padding: 6px 0 7px;
            border: 1px solid #b0afb5;
            border-radius: 4px;
            background: #f8f9fa;
        }

        .opps-instructions {
            margin: 32px -45px 0;
            padding: 32px 45px 45px;
            border-top: 1px solid #b0afb5;
            background: #f8f9fa;
        }

        ol {
            text-align: left;
            margin: 17px 0 0 16px;
        }

        li + li {
            margin-top: 10px;
            color: #000000;
        }

        a {
            color: #1155cc;
        }

        .opps-footnote {
            margin-top: 22px;
            padding: 22px 20px 24px;
            color: #108f30;
            text-align: center;
            border: 1px solid #108f30;
            border-radius: 4px;
            background: #ffffff;
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
                <div class="opps">
                    <div class="opps-header">
                        <div class="opps-reminder">@lang('formaspagos.ficha_digital')</div>
                        <div class="opps-info">
                            <div class="opps-brand"><img src="/imagenes/Oxxo_Logo.svg.png" width="200" alt="OXXOPay"></div>
                            <div class="opps-ammount">
                                <h3>@lang('formaspagos.monto')</h3>
                                <h2> {{ number_format($formapago->metadatos->importe, 2)}} <sup>{{$formapago->moneda}}</sup></h2>
                                <p>@lang('formaspagos.oxxo_comision')</p>
                            </div>
                        </div>
                        <div class="opps-reference">
                            <h3>@lang('formaspagos.referencia')</h3>
                            <h1>{{$formapago->metadatos->referencia}}</h1>
                        </div>
                        <div class="opps-reference">
                            <img src="{{$formapago->metadatos->codigo_barras}}" alt="QR" width="100%" height="75">
                        </div>
                    </div>
                    <div class="opps-instructions">
                        <h3>@lang('formaspagos.instrucciones')</h3>
                        <ol>
                            <li>@lang('formaspagos.oxxo_acude') <a
                                    href="https://www.google.com.mx/maps/search/oxxo/"
                                    target="_blank">@lang('formaspagos.aqui')</a>.
                            </li>
                            <li>@lang('formaspagos.oxxo_1')</li>
                            <li>@lang('formaspagos.oxxo_2')</li>
                            <li>@lang('formaspagos.oxxo_3')</li>
                            <li>@lang('formaspagos.oxxo_4')</li>
                        </ol>
                        <div class="opps-footnote">@lang('formaspagos.confirmar_pago',['propiedad'=>$propiedad->nombre])</div>
                    </div>
                </div>
            </div>
            <div class="card-footer justify-content-between text-center">
                <button type="button" class="btn btn-primary"
                        onclick="window.location='{{ $redireccion }}'">@lang('reserva.finalizar')</button>
            </div>
        </div>
    </div>
@endsection

