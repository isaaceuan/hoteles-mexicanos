@extends('basico.desktop.base-admin')
@section('title.page')@lang('title.modificaciones_cancelaciones')@endsection
@section('styles')
    <style>
        ul.reglas {
            list-style-type: none;
        }

        ul.reglas > li:before {
            content: "–"; /* en dash here */
            position: absolute;
            margin-left: -1.1em;
        }
    </style>
@endsection
@section('content')
    <div class="contentMenu my-4">
        <div class="card rounded-0 border-0 shadow" id="menu">
            <div class="col-md-12 text-center">
                <div class="row  bg-light border-bottom mb-3">
                    <div class="col-md-12 text-center py-3">
                        <a class="cursor-pointer" data-toggle="modal" data-target="#modalSalir">
                            <i class="fa mt-3 fa-3x fa-arrow-left color-acento float-left"></i>
                        </a>
                        <h3>
                            <strong>@lang('modificar.menu.bienvenido'):</strong>
                            {{$reserva->huesped->nombre}}
                        </h3>
                        <h4>@lang('modificar.menu.hacer')</h4>
                    </div>
                </div>
                <div class="text-center px-5">
                    <div class="row mb-3">
                        <div class="col-md-6 text-right">
                            <a class="btn btn-default btn-options space-normal w-100 py-4"
                               href="{{route('modificar.resumen.reserva', app()->getLocale(),false)}}">
                                <i class="fa fa-info-circle fa-3x"></i>
                                <br><br>@lang('modificar.menu.resumen') </a>
                        </div>
                        <div class="col-md-6 text-left">
                            <a class="btn btn-default btn-options space-normal w-100 py-4"
                               href="{{route('modificar.datos.personales', app()->getLocale(),false)}}">
                                <i class="fa fa-user fa-3x"></i>
                                <br><br>@lang('modificar.menu.editar') </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <a href="{{route('modificar.disponibilidad', app()->getLocale(),false)}}"
                               class="btn btn-default btn-options space-normal w-100 py-4 @if(!$permitirModificar){{'disabled'}}@endif">
                                <i class="fa fa-edit fa-3x"></i>
                                <br><br>@lang('modificar.menu.modificar') </a>
                        </div>
                        <div class="col-md-6 text-left">
                            <a class="btn btn-default btn-options space-normal w-100 py-4  @if(!$permitirCancelar){{'disabled'}}@endif"
                               data-toggle="modal"
                               data-target="#modalCancelar">
                                <i class="fa fa-calendar-times fa-3x"></i>
                                <br><br>@lang('modificar.menu.cancelar') </a>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 text-left mt-4"> 
                            <strong class="text-uppercase">@lang('modificar.menu.para_modificacion'):</strong>
                            <ul class="pl-3 reglas">
                                @if($permitirModificar)
                                    <li>@lang('modificar.menu.modificacion_hasta',['fecha_limite'=> date('d-M-Y', strtotime($reserva->regla_modificacion->fecha_limite))])</li>
                                    <li>@lang('modificar.menu.modificacion_intentos',['numero_intentos'=>$reserva->regla_modificacion->modificaciones_restantes])</li>
                                @else
                                    <li>@lang('modificar.menu.modificacion_vencido')</li>
                                @endif
                            </ul>
                            <strong class="text-uppercase">@lang('modificar.menu.para_cancelacion'):</strong>
                            <ul class="pl-3 reglas">
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
                    <a href="{{route('modificar.salir', app()->getLocale(),false)}}">
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
                    <a href="{{route('modificar.reserva.cancelar', app()->getLocale(),false)}}">
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
@endsection
