@extends('basico.mobile.base')
@section('title.page')@lang('title.informacion')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('scripts')
    <script type="text/javascript">
        (function () {
            // Inicializar los valores del calendario.
            fillDateBox("#checkin-detail", parseDate('{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'), '{{app()->getLocale()}}');
            fillDateBox("#checkout-detail", parseDate('{{AppBusqueda::recuperarBusqueda()->getSalida()}}'), '{{app()->getLocale()}}');
        })();

    </script>
@endsection
@section('styles')
    <style>
        .dropdown-menu.show {
            width: 100%;
        }

        #datos-personales .form-group {
            margin-bottom: 0;
        }

        #logoOpay {
            text-align: right;
            padding: 18px 0;
        }

        #logoOpay img {
            height: 40px;
        }

        .was-validated .form-control:invalid, .form-control.is-invalid {
            background-image: none !important;
        }

        .sticky-top, .sticky-top-steps {
            z-index: 1000 !important;
        }
    </style>
@endsection
@section('content')
    @include('basico.mobile.componentes.floating-detalle-reserva')
    @include('basico.mobile.componentes.steps')
    <total-tipo-vista-component></total-tipo-vista-component>
    <div class="mt-0">
        <div class="text-center mt-4 loading d-none">
            <div class="spinner-border text-acento " style="width: 4rem; height: 4rem;" role="status">
            </div>
        </div>
        <div class="container bg-white card content_info">
            <!-- DATOS PERSONALES -->
            <form id="form" class="form">
                <div id="datos-personales">
                    <div class="row  bg-light p-2 border-bottom">
                        <div class="col-12 text-center">
                            <h5>@lang('informacion.datos_personales')</h5>
                        </div>
                    </div>
                    <div id="validation-errors" class="alert alert-danger d-none"></div>
                    @if($propiedadMotor->campo_titulo != 'apagado')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="titulo" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_titulo == 'requerido')
                                                        *@endif</span>
                                        @lang('informacion.titulo_personal')
                                    </label>
                                    <div class="col-sm-8">
                                        <select
                                            class="selectpicker form-control @if($errors->has('titulo')){{'is-invalid'}}@endif"
                                            title="---" id="titulo" name="titular[titulo]"
                                            @if($propiedadMotor->campo_titulo == 'requerido') required @endif>
                                            {{--<option value=""></option>--}}
                                            @foreach($titulos as $item)
                                                <option
                                                    value="{{$item->titulo}}" {{ $titular['titulo']  == $item->titulo ? 'selected' : '' }}>{{$item->descripcion}}</option>
                                            @endforeach
                                        </select>
                                        @if($propiedadMotor->campo_titulo == 'requerido' && $errors->has('titulo'))
                                            <small class="invalid-feedback">{{$errors->first('titulo')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-12 float-left">
                            <div class="form-group row">
                                <label for="nombres"
                                       class="col-sm-4 col-form-label">*@lang('informacion.nombre')</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           class="form-control @if($errors->has('nombres')){{'border-danger'}}@endif"
                                           id="nombres" maxlength="150" required autocomplete="off"
                                           name="titular[nombres]"
                                           value="{{ $titular['nombres']  }}">
                                    @if($errors->has('nombres'))
                                        <small class="invalid-feedback">{{$errors->first('nombres')}}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 float-left">
                            <div class="form-group row">
                                <label for="apellidos"
                                       class="col-sm-4 col-form-label">*@lang('informacion.apellido')</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           class="form-control @if($errors->has('apellidos')){{'border-danger'}}@endif"
                                           id="apellidos" maxlength="150" required autocomplete="off"
                                           name="titular[apellidos]" value="{{ $titular['apellidos']  }}">
                                    @if($errors->has('apellidos'))
                                        <small class="invalid-feedback">{{$errors->first('apellidos')}}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 float-left">
                            <div class="form-group row">
                                <label for="correo"
                                       class="col-sm-4 col-form-label">*@lang('informacion.correo')</label>
                                <div class="col-sm-8">
                                    <input type="email"
                                           class="form-control @if($errors->has('correo')){{'border-danger'}}@endif"
                                           id="correo" maxlength="85" required autocomplete="off" name="titular[correo]"
                                           value="{{ $titular['correo']  }}">
                                    @if($errors->has('correo'))
                                        <small class="invalid-feedback">{{$errors->first('correo')}}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6 float-left">
                            <div class="form-group row">
                                <label for="telefono"
                                       class="col-sm-4 col-form-label">*@lang('informacion.telefono_movil')</label>
                                <div class="col-sm-8">
                                    <input type="tel"
                                           class="form-control @if($errors->has('telefono')){{'border-danger'}}@endif"
                                           id="telefono"  maxlength="10" required autocomplete="off"
                                           name="titular[telefono]" value="{{ $titular['telefono']  }}">
                                    @if($errors->has('telefono'))
                                        <small
                                            class="invalid-feedback">{{$errors->first('telefono')}}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($propiedadMotor->campo_telefono_otro != 'apagado')
                            <div class="col-6 float-left">
                                <div class="form-group row">
                                    <label for="telefono_otro" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_telefono_otro == 'requerido')
                                                        *@endif</span>@lang('informacion.otro_telefono')</label>
                                    <div class="col-sm-8">
                                        <input type="tel"
                                               class="form-control @if($errors->has('telefono_otro')){{'border-danger'}}@endif"
                                               id="telefono_otro" maxlength="10" autocomplete="off"
                                               name="titular[telefono_otro]"
                                               @if($propiedadMotor->campo_telefono_otro == 'requerido') required
                                               @endif value="{{ $titular['telefono_otro']  }}">
                                        @if($errors->has('telefono_otro'))
                                            <small
                                                class="invalid-feedback">{{$errors->first('telefono_otro')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        @if($propiedadMotor->campo_direccion != 'apagado')
                            <div class="col-12 float-left">
                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-2 col-form-label">
                                                <span>@if($propiedadMotor->campo_direccion == 'requerido')
                                                        *@endif</span>@lang('informacion.direccion')
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control @if($errors->has('direccion')){{'border-danger'}}@endif"
                                               id="direccion" minlength="5" maxlength="190" autocomplete="off"
                                               name="titular[direccion]"
                                               @if($propiedadMotor->campo_direccion == 'requerido') required
                                               @endif value="{{ $titular['direccion']  }}">
                                        @if($errors->has('direccion'))
                                            <small
                                                class="invalid-feedback">{{$errors->first('direccion')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($propiedadMotor->campo_ciudad != 'apagado')
                            <div class="col-6 float-left">
                                <div class="form-group row">
                                    <label for="ciudad" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_ciudad == 'requerido')
                                                        *@endif</span>@lang('informacion.ciudad')
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @if($errors->has('ciudad')){{'border-danger'}}@endif"
                                               id="ciudad" maxlength="20" autocomplete="off" name="titular[ciudad]"
                                               @if($propiedadMotor->campo_ciudad == 'requerido') required
                                               @endif value="{{ $titular['ciudad']  }}">
                                        @if($errors->has('ciudad'))
                                            <small class="invalid-feedback">{{$errors->first('ciudad')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($propiedadMotor->campo_estado != 'apagado')
                            <div class="col-6 float-left">
                                <div class="form-group row">
                                    <label for="estado" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_estado == 'requerido')
                                                        *@endif</span>@lang('informacion.estado')
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @if($errors->has('estado')){{'border-danger'}}@endif"
                                               id="estado" maxlength="25" autocomplete="off" name="titular[estado]"
                                               @if($propiedadMotor->campo_estado == 'requerido') required
                                               @endif value="{{ $titular['estado']  }}">
                                        @if($errors->has('estado'))
                                            <small class="invalid-feedback">{{$errors->first('estado')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($propiedadMotor->campo_pais != 'apagado')
                            <div class="col-12 float-left">
                                <div class="form-group row">
                                    <label for="pais" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_pais == 'requerido')
                                                        *@endif</span>@lang('informacion.pais')
                                    </label>
                                    <div class="col-sm-8">
                                        <select
                                            class="selectpicker form-control w-100 @if($errors->has('pais')){{'border-danger'}}@endif"
                                            data-live-search="true"
                                            data-mobil="true"
                                            data-live-search-normalize="true"
                                            title="---" id="pais" name="titular[pais]"
                                            @if($propiedadMotor->campo_pais == 'requerido') required @endif>
                                            @foreach($paises as $pais)
                                                <option
                                                    value="{{$pais->id}}" {{ $titular['pais']  == $pais->id ? 'selected' : '' }}>{{$pais->nombre}}
                                            @endforeach
                                        </select>
                                        @if($errors->has('pais'))
                                            <small class="invalid-feedback">{{$errors->first('pais')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($propiedadMotor->campo_cp != 'apagado')
                            <div class="col-6 float-left">
                                <div class="form-group row">
                                    <label for="codigo_postal" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_cp == 'requerido')
                                                        *@endif</span>@lang('informacion.cp')
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @if($errors->has('codigo_postal')){{'border-danger'}}@endif"
                                               id="codigo_postal" maxlength="25" autocomplete="off"
                                               name="titular[codigo_postal]"
                                               @if($propiedadMotor->campo_cp == 'requerido') required
                                               @endif value="{{ $titular['codigo_postal']  }}">
                                        @if($errors->has('codigo_postal'))
                                            <small class="invalid-feedback">{{$errors->first('codigo_postal')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($propiedadMotor->campo_direccion != 'apagado' ||
                                                   $propiedadMotor->campo_ciudad != 'apagado' ||
                                                   $propiedadMotor->campo_estado != 'apagado' ||
                                                   $propiedadMotor->campo_pais != 'apagado' ||
                                                   $propiedadMotor->campo_cp != 'apagado')
                        <hr>
                    @endif
                    <div class="row">
                        <div class="col-12 float-left">
                            <div class="form-group row mb-4">
                                <label for="comentarios" class="col-sm-2 col-form-label">
                                    @lang('informacion.comentarios')
                                </label>
                                <div class="col-sm-10">
                                        <textarea
                                            class="form-control"
                                            rows="3"
                                            id="comentarios" autocomplete="off"
                                            name="titular[comentarios]">{{$titular['comentarios'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-2 mb-4">
                    <button type="button" onclick="enviarFormulario()" id="btnTitular"
                            class="btn btn-primary">
                        @lang('informacion.continuar')
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error al procesar pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

    <script type="text/javascript">
        let informacionPago = {
            error: function () {
                return $("#validation-errors");
            },
            contenedor: function () {
                return $('.content_info');
            },
            spinner: function () {
                return $('.loading');
            }
        };

        function enviarFormulario() {
            $("#form").submit();
        }

        function iniciarProceso() {
            Formulario.habilitarPagar(false);
            informacionPago.spinner().removeClass('d-none');
            informacionPago.error().addClass('d-none').html('');
        }

        function cancelarProceso() {
            Formulario.habilitarPagar(true);
            informacionPago.spinner().addClass('d-none');
        }

        function habilitarBotonPagar() {
            $('#aceptar_terminos').on('change', function (event) {
                if ($(this).is(':checked')) {
                    Formulario.habilitarPagar(true);
                } else {
                    Formulario.habilitarPagar(false);
                }
            });
        }

        function procesarReserva() {
            var data = $('#form').serializeArray();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: "{{ route('app.informacion.guardar',app()->getLocale(),false) }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    window.location.href = response;
                },
                error: function (xhr) {
                    var mensaje = '';
                    mensaje = '<ul>'
                    if (xhr.responseJSON.message) {
                        var errors = xhr.responseJSON.message;
                        Object.keys(xhr.responseJSON.message).forEach(function (key) {
                            mensaje += '<li>' + errors[key] + '</li>';
                        });
                        mensaje += '</ul>';
                    }

                    Modal.mostrar(mensaje);
                    cancelarProceso();
                }
            });
        }

        const Modal = {
            mostrar: function (mensaje, titulo = 'Aviso') {
                const elemento = $("#modal");
                elemento.find('.modal-title').html(titulo);
                elemento.find('.modal-body p').html(mensaje);
                elemento.modal('show');
            }
        };

        const Formulario = {
            getTitulo: () => $("#titulo").val() || '',
            getNombres: () => $("#nombres").val() || '',
            getApellidos: () => $("#apellidos").val() || '',
            getCorreo: () => $("#correo").val() || '',
            getTelefono: () => $("#telefono").val() || '',
            getTelefonoOtro: () => $("#telefono_otro").val() || '',
            getDireccion: () => $("#direccion").val() || '',
            getCiudad: () => $("#ciudad").val() || '',
            getEstado: () => $("#estado").val() || '',
            getPais: () => $("#pais").val() || '',
            getCodigoPostal: () => $("#codigo_postal").val() || '',
            getComentarios: () => $("#comentarios").val() || '',
            getFormaPago: () => $("#forma_pago").val() || null,
            estaVacio: function () {
                return this.getNombres() === '' && this.getApellidos() === '' && this.getCorreo() === '' && this.getTelefono() === '' && this.getTelefonoOtro() === '' && this.getDireccion() === '' && this.getCiudad() === '' && this.getEstado() === '' && this.getPais() === '' && this.getCodigoPostal() === '' && this.getComentarios() === '';
            },
            habilitarDatosPersonales: function (activo) {
                $("#form #datos-personales input, #form #datos-personales select, #form #datos-personales textarea").prop('readonly', !activo);
                $("#aceptar_terminos").prop('disabled', !activo);
            },
            habilitarPagar: function (activo) {
                $("#form #pagar").prop('disabled', !activo);
            }
        }

        $(document).ready(function () {

            $("#form").validate({
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
                    iniciarProceso();
                    procesarReserva();

                }
            });
        });

    </script>
@endsection

