@extends('basico.mobile.base')
@section('title.page')@lang('title.modificaciones_cancelaciones')@endsection
@section('styles')
    <style>
        body {
            background-color: #FFFFFF !important;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        ul {
            list-style-type: none;
        }

        ul > li:before {
            content: "–"; /* en dash here */
            position: absolute;
            margin-left: -1.1em;
        }

    </style>
@endsection
@section('content')
    <div class="contentMenu">
        <div class="card rounded-0 border-0" id="menu">
            <div class="col-12 text-center">
                <div class="row  bg-light border-bottom border-top mb-3">
                    <div class="col-12 text-center py-2">
                        <a class="cursor-pointer btn btn-primary btn-sm float-left" data-toggle="modal"
                           data-target="#modalSalir">
                            <i class="fa fa-lg fa-arrow-left  "></i>
                        </a>
                        <h6 class="mb-0 mt-1">
                            <strong>@lang('modificar.menu.modificar'):</strong>
                            {{$reserva->folio}}
                        </h6>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-12">
                        <h6 class="text-center">
                            <strong>@lang('modificar.menu.bienvenido'):</strong>
                            {{$reserva->huesped->nombre}}
                        </h6>
                        <h6 class=" text-center">@lang('modificar.menu.hacer')</h6>
                    </div>

                </div>
                <div class="text-center">
                    <div class="row my-3">
                        <div class="col-6 text-right">
                            <a class="border cargador btn btn-default btn-options space-normal w-100 py-2 text-wrap"
                               href="{{route('modificar.resumen.reserva', app()->getLocale(),false)}}">
                                <i class="fa fa-info-circle fa-lg"></i>
                                <br>@lang('modificar.menu.resumen') </a>
                        </div>
                        <div class="col-6 text-left">
                            <a class="border cargador btn btn-default btn-options space-normal w-100 py-2 text-wrap"
                               href="{{route('modificar.datos.personales', app()->getLocale(),false)}}">
                                <i class="fa fa-user fa-lg"></i>
                                <br> @lang('modificar.menu.editar') </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-right">
                            <a href="{{route('modificar.disponibilidad', app()->getLocale(),false)}}"
                               class="border cargador btn btn-default btn-options space-normal w-100 py-2 text-wrap @if(!$permitirModificar){{'disabled'}}@endif">
                                <i class="fa fa-edit fa-lg"></i>
                                <br>@lang('modificar.menu.modificar') </a>
                        </div>
                        <div class="col-6 text-left">
                            <a class="border btn btn-default btn-options space-normal w-100 py-2 text-wrap @if(!$permitirCancelar){{'disabled'}}@endif"
                               data-toggle="modal"
                               data-target="#modalCancelar">
                                <i class="fa fa-calendar-times fa-lg"></i>
                                <br>@lang('modificar.menu.cancelar') </a>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 text-left mt-4">
                            <strong class="text-uppercase">@lang('modificar.menu.para_modificacion'):</strong>
                            <ul class="pl-3">
                                @if($permitirModificar)
                                    <li>
                                        @lang('modificar.menu.modificacion_hasta',['fecha_limite'=> date('d-M-Y', strtotime($reserva->regla_modificacion->fecha_limite))])</li>
                                    <li>
                                        @lang('modificar.menu.modificacion_intentos',['numero_intentos'=>$reserva->regla_modificacion->modificaciones_restantes])</li>
                                @else
                                    <li>@lang('modificar.menu.modificacion_vencido')</li>
                                @endif
                            </ul>
                            <strong class="text-uppercase">@lang('modificar.menu.para_cancelacion'):</strong>
                            <ul class="pl-3">
                                @if($reserva->regla_cancelacion && 
                                $reserva->regla_cancelacion->es_reembolsable && 
                                count($reserva->regla_cancelacion->restricciones)>0)
                                   @foreach($reserva->regla_cancelacion->restricciones as $key => $restriccion)
                                       @if(strtotime($restriccion->fecha_limite) <= strtotime("now"))
                                           <li style="@if($key>0){{'display:none'}}@endif"><span>
                                           @lang('modificar.menu.cancelacion_vencido')
                                           </span></li>
                                       @else
                                           <li>
                                               @lang('modificar.menu.cancelacion_hasta',[
                                                       'fecha_limite'=>date('d-M-Y', strtotime($restriccion->fecha_limite)),
                                                       'tasa'=>$restriccion->tasa]
                                               )
                                           </li>
                                       @endif
                                   @endforeach
                               @else
                                   <li> @lang('modificar.menu.cancelacion_vencido')</li>
                               @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modalSalir" tabindex="-1" role="dialog" aria-labelledby="modalSalir" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body row">
                    <div class="col-2">
                        <i class="fa fa-3x fa-question-circle color-acento"></i>
                    </div>
                    <div class="col-10" v-if="datos">
                        <p class="my-2"> @lang('modificar.menu.estas_seguro')</p>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <a href="{{route('modificar.salir', app()->getLocale(),false)}}" class="cargador">
                        <button type="button" class="btn btn-primary">
                            @lang('modificar.menu.salir')
                        </button>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        @lang('modificar.menu.cerrar')
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-labelledby="modalCancelar"
         aria-hidden="true">
        >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('modificar.menu.cancelar_titulo')</h6>
                </div>
                <div class="modal-body row">
                    <div class="col-2 pt-3">
                        <i class="fa fa-3x fa-exclamation-triangle color-acento"></i>
                    </div>
                    <div class="col-10">
                        <p class="my-2 @if(!$permitirCancelar){{'d-none'}}@endif">
                            @lang('modificar.menu.cancelar_texto')
                        </p>
                        <p class="my-2 @if($permitirCancelar){{'d-none'}}@endif">
                            @lang('modificar.menu.cancelar_texto_noreembolsable')
                        </p>
                        <p class="font-weight-bold">
                            @lang('modificar.menu.cancelar_seguro')
                        </p>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <a href="{{route('modificar.reserva.cancelar', app()->getLocale(),false)}}" class="cargador">
                        <button type="button" class="btn btn-primary">
                            @lang('modificar.menu.cancelar')
                        </button>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        @lang('modificar.menu.cerrar')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts_header')
    <script>
        var variables = {
            spinner: function () {
                return $('.loading');
            }
        }
        $(document).ready(function () {
            $('a.cargador').click(function (e) {
                variables.spinner().removeClass('d-none');
            });
        });

    </script>

@endsection
