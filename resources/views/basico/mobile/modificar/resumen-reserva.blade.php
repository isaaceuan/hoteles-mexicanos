@extends('basico.mobile.base')
@section('title.page')@lang('title.modificaciones_cancelaciones_resumen')@endsection
@section('styles')
    <style>
        #resumenReserva p {
            margin-bottom: 0;
        }
    </style>
@endsection
@section('content')
    <div class="contentMenu">
        <div class="card rounded-0 border-0 px-3" id="resumenReserva">
            <div class="row  bg-light border-bottom border-top  mb-3">
                <div class="col-12  py-2">
                    <a class="cursor-pointer cargador btn btn-primary btn-sm float-left"
                       href="{{route('modificar.menu', app()->getLocale(),false)}}">
                        <i class="fa fa-lg fa-arrow-left"></i>
                    </a>
                    <h6 class="text-center mb-0 mt-1">@lang('modificar.resumen.titulo_reserva'): <span
                            class="font-weight-bold">{{ $reserva->folio }}</span></h6>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 d-none">
                    <p>
                        <strong>@lang('email.nombre')
                            :</strong> {{ $reserva->huesped->nombre.' '.$reserva->huesped->apellido }}
                        <br><strong>@lang('email.telefono'):</strong> {{ $reserva->huesped->contacto->telefono_1 }}
                        <br> <span style="@if(!$reserva->huesped->contacto->telefono_2){{'display:none'}}@endif">
                                                                        <strong>@lang('email.telefono_otro'):</strong> {{ $reserva->huesped->contacto->telefono_2 }}<br></span>
                        <strong>@lang('email.correo'):</strong> {{ $reserva->huesped->contacto->correo }}
                        <br><span style="@if(!$reserva->huesped->domicilio->direccion){{'display:none'}}@endif">
                                                                        <strong>@lang('email.direccion'):</strong> {{ $reserva->huesped->domicilio->direccion }}<br></span>
                        <span style="@if(!$reserva->huesped->domicilio->codigo_postal){{'display:none'}}@endif">
                                                                        <strong>@lang('email.cp'):</strong> {{ $reserva->huesped->domicilio->codigo_postal }}<br></span>
                        <span style="@if(!$reserva->huesped->domicilio->ciudad){{'display:none'}}@endif">
                                                                        <strong>@lang('email.ciudad'):</strong> {{ $reserva->huesped->domicilio->ciudad }}<br></span>
                        <span style="@if(!$reserva->huesped->domicilio->estado){{'display:none'}}@endif">
                                                                        <strong>@lang('email.estado'):</strong> {{ $reserva->huesped->domicilio->estado }}<br></span>
                        <span style="@if(!$reserva->huesped->domicilio->pais_id){{'display:none'}}@endif">
                                                                        <strong>@lang('email.pais'):</strong> {{ $reserva->huesped->domicilio->pais_id }}<br></span>
                        <span style="@if(!$reserva->comentarios){{'display:none'}}@endif">
                                                                        <strong>@lang('email.comentarios_solicitudes'):</strong><br>  {{ $reserva->comentarios }}<br></span>
                    </p>
                </div>
                <div class="col-12">
                    <div class="row m-0 justify-content-between">
                        <p><strong>@lang('email.entrada'): </strong></p>
                        <p>{{ $reserva->fecha_entrada }}</p>
                    </div>
                    <div class="row m-0 justify-content-between">
                        <p><strong>@lang('email.salida'): </strong></p>
                        <p>{{ $reserva->fecha_salida }}</p>
                    </div>
                    <div class="row m-0 justify-content-between">
                        <p><strong>@lang('email.noches'): </strong></p>
                        <p>{{ $reserva->noches }}</p>
                    </div>
                    <div class="row m-0 justify-content-between">
                        <p><strong>@lang('email.adultos'): </strong></p>
                        <p>{{ $reserva->detalle_actual->adultos }}</p>
                    </div>
                    <div class="row m-0 justify-content-between">
                        <p><strong>@lang('email.ninos'): </strong></p>
                        <p>{{ $reserva->detalle_actual->ninos1 + $reserva->detalle_actual->ninos2 + $reserva->detalle_actual->ninos3}}</p>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="row m-0 justify-content-between">
                        <h6>@lang('email.detalle_habitacion')</h6>
                    </div>
                    <hr class="w-100 my-1">
                    <div class="row m-0 justify-content-between">
                        <p class="font-weight-bold"> {{ $detalle['nombre'] }}
                        </p>
                        <p> {{ $detalle['moneda_id'] }} {{number_format(  $detalle['total_sin_imp'] , 2, '.', ',')}}</p>
                    </div>
                    <div class="row m-0">
                        <p>{{ $tarifa['nombre'] }}</p>
                    </div>
                    @if($reserva->regla_cancelacion && $reserva->regla_cancelacion->es_reembolsable && count($reserva->regla_cancelacion->restricciones)>0)
                        <p>
                            @foreach($reserva->regla_cancelacion->restricciones as $restriccion)
                                @if($restriccion->tasa===100)
                                    *@lang('email.cancelacion_gratuita')
                                    <span class="text-capitalize">{{$restriccion->fecha_limite}}</span>
                                @endif
                            @endforeach
                        </p>
                    @endif
                </div>
                <div class="col-12 mt-2">
                    <div class="row m-0">
                        @if(count($complementosIncluidos)>0)
                            <p class="m-0 font-weight-bold">
                                @lang('email.complementos_incluidos'):
                            </p>
                            @foreach($complementosIncluidos as $complemento)
                                <p class="w-100">
                                    <span class="text-capitalize">{{$complemento->complemento->nombre}} </span>
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-12 my-2">
                    @if(count($complementosAdicionales)>0)
                        <p class="row m-0 font-weight-bold">
                            @lang('email.complementos_adicionales'):
                        </p>
                        @foreach($complementosAdicionales as $complemento)
                            <div class="row m-0 justify-content-between">
                                <p class="font-weight-bold">{{$complemento['nombre']}}
                                    (x{{$complemento['cantidad']}})
                                </p>
                                <p>
                                    {{$reserva->moneda_id}} {{number_format( $complemento['total_sin_imp'] , 2, '.', ',')}}
                                </p>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-12">
                    <hr class="w-100 my-1">
                </div>
                <div class="col-12">
                    <div class="row p-0">
                        <div class="col-8 ">
                            <p><strong>Subtotal:</strong></p>
                            <p><strong>@lang('disponibilidad.impuestos_cargos'): </strong></p>
                        </div>
                        <div class="col-4 pl-0  text-right">
                            <p>{{ $detalle['moneda_id'] }} {{ number_format($detalle['subtotal'] , 2, '.', ',')}}</p>
                            <p>{{ $detalle['moneda_id'] }} {{ number_format($detalle['total_impuestos'] , 2, '.', ',')}}</p>
                        </div>
                    </div>
                    <div class="row py-2 bg-acento text-light">
                        <div class="col-8 ">
                            <p><strong>Total:</strong></p>
                        </div>
                        <div class="col-4 pl-0  text-right">
                            <p>
                                <strong>{{ $detalle['moneda_id'] }} {{ number_format($reserva->total , 2, '.', ',')}}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2 flex-column-reverse flex-md-row">
                <div class="col-12">
                    <hr class="w-100 my-0 pb-3">
                    <a class="cursor-pointer" data-toggle="modal" data-target="#modalInfoTarifa">
                        <h6>@lang('email.info_tarifa') <i class="fa fa-plus-circle color-acento"></i></h6></a>
                    <a class="cursor-pointer" data-toggle="modal" data-target="#modalPoliticaCondiciones">
                        <h6>@lang('email.info_politicas') <i class="fa fa-plus-circle color-acento"></i></h6>
                    </a>
                </div>
                <div class="">
                    <div class="row m-0  alert alert-secondary px-0 mb-0" style="color: #000000;font-weight: bold;">
                        <div class="col-8 text-left">
                            <p>@lang('email.pago_garantia'):</p>
                            <p>@lang('email.saldo_hotel'):</p>
                        </div>
                        <div class=" col-4 text-right pl-0">
                            <p>{{ $detalle['moneda_id'] }} {{ number_format($detalle['total_anticipo'], 2, '.', ',')}}</p>
                            <p>{{ $detalle['moneda_id'] }} {{ number_format($detalle['saldo'], 2, '.', ',')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <hr class="w-100">
                    <form id="formSendReservation">
                        <div class="form-group row justify-content-center">
                            <label for="email" class="col-sm-2 col-form-label text-left font-weight-bold"> @lang('modificar.resumen.titulo_enviar')
                                : </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email"
                                       required
                                       value="{{ $reserva->huesped->contacto->correo }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-4">
                                <a href="{{route('modificar.menu', app()->getLocale(),false)}}"
                                   class="btn btn-secondary btn-block cargador">
                                    <i class="fa fa-chevron-left"></i> @lang('modificar.login.regresar')</a>
                            </div>
                            <div class="col-6 mb-4">
                                <button class="btn btn-primary btn-block"
                                        type="button"
                                        onclick="enviarFormulario()"
                                        id="btnSendReservation">
                                    @lang('modificar.resumen.enviar')
                                </button>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="mt-2">
                                    <div class="alert alert-success d-none m-auto" role="alert">
                                        @lang('modificar.resumen.enviado')
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="alert alert-danger d-none m-auto" role="alert">
                                        @lang('modificar.resumen.no_enviado')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modalPoliticaCondiciones" tabindex="-1" aria-labelledby="modalPoliticaCondiciones"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ml-auto" id="modalPoliticaCondiciones">@lang('email.info_politicas')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!!$propiedad->politica_general!!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalInfoTarifa" tabindex="-1" aria-labelledby="modalInfoTarifa"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ml-auto" id="modalInfoTarifa"> {{ $tarifa['nombre'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>{{ $tarifa['nombre'] }}</b></p>
                    @if($tarifa['plan_alimento_id'])
                        <p>
                            <b>@lang('carrito.plan_alimentos'): </b> {{ $tarifa['plan_alimento']['nombre']}}
                        </p>
                    @endif
                    <p>
                        {!! $tarifa['descripcion']  !!}
                    </p>
                    @if($permitirCancelar)
                        @if($tarifa['regla_cancelacion'] && count($tarifa['regla_cancelacion']->restricciones)>0)
                            <p><b>@lang('carrito.reglas_cancel')</b></p>
                            @foreach($tarifa['regla_cancelacion']->restricciones as $restriccion)
                                <p>
                                    @lang('disponibilidad.reembolso_del',['tasa'=>$restriccion->tasa]) {{ $restriccion->fecha_limite }}
                                </p>
                            @endforeach
                            <br>
                        @endif
                    @endif
                    @if($permitirModificar)
                        @if($tarifa['regla_modificacion'] &&
                            $tarifa['regla_modificacion']->dias_anticipacion > 0 &&
                            $tarifa['regla_modificacion']->modo === 'libre' ||
                            $tarifa['regla_modificacion']->modo === 'limitado'
                            )
                            <p><strong>@lang('carrito.reglas_modif')</strong></p>
                            <p>@lang('disponibilidad.modificar_reserva') {{$tarifa['regla_modificacion']->fecha_limite}}</p>
                        @endif
                    @else
                        <p><strong>@lang('carrito.reglas_modif')</strong></p>
                        <p>@lang('modificar.menu.modificacion_vencido')</p>
                    @endif
                    @if(count($promociones)>0)
                        <p style="text-align:left;Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#333333;">
                            <strong>@lang('disponibilidad.promociones')</strong>
                        </p>
                        @foreach($promociones as $promocion)
                            <p style="text-align:left;Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#333333;">
                            <b>- {{$promocion->nombre}}</b><br>
                            {{$promocion->descripcion}}
                            </p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts_header')
    <script src="/recursos/jquery-validate/jquery.validate.min.js"></script>

    @if(app()->getLocale() != 'en')
        <script src="/recursos/jquery-validate/localization/messages_{{app()->getLocale()}}.js"></script>
    @endif
    <script>
        let variables = {
            success: function () {
                return $('.alert-success');
            },
            error: function () {
                return $('.alert-danger');
            },
            spinner: function () {
                return $('.loading');
            },
            btnSend: function () {
                return $('#btnSendReservation');
            }
        }


        function enviarFormulario() {
            $("#formSendReservation").submit();
        }

        $(document).ready(function () {

            $('a.cargador').click(function (e) {
                variables.spinner().removeClass('d-none');
            });
            $("#formSendReservation").validate({
                lang: '{{app()->getLocale()}}',
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.after(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    enviarCorreo();
                }
            });
        });


        function enviarCorreo() {
            variables.spinner().removeClass('d-none');
            variables.btnSend().attr('disabled', true);
            var data = $('#formSendReservation').serializeArray();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: window.url_reeenviar_reserva,
                data: data,
                dataType: 'json',
                success: function (response) {
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    variables.btnSend().attr('disabled', false);
                    console.log(response + 'success');
                    variables.spinner().addClass('d-none');
                    variables.success().removeClass('d-none');
                    setTimeout(() => {
                        variables.success().addClass('d-none');
                    }, 5000)

                    // console.log('redireccion: ' + response);
                    // window.location.href = response;
                },
                error: function (xhr) {
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    console.log(xhr + 'error');
                    variables.spinner().addClass('d-none');
                    variables.btnSend().attr('disabled', false);
                    variables.error().removeClass('d-none');
                    setTimeout(() => {
                        variables.error().addClass('d-none');
                    }, 5000)
                    console.log(xhr);

                }
            });
        }
    </script>
@endsection
