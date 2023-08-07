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
        .dropdown-menu.show{
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

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1025;
        }

        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(152, 152, 152, .6);
        }

        .spinner-border {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -20px;
            margin-left: -25px;
            text-align: center;
            font-size: 10px;
        }
    </style>
@endsection
@section('content')
    @include('basico.mobile.componentes.floating-detalle-reserva')
    @include('basico.mobile.componentes.steps')
    <total-tipo-vista-component></total-tipo-vista-component>
    <div class="mt-3">
        <div class="text-center mt-4 loading d-none">
            <div class="spinner-border text-acento " style="width: 4rem; height: 4rem;" role="status">
            </div>
        </div>
        <div class="container bg-white card content_info">
            <!-- DATOS PERSONALES -->
            <form id="form" class="form">
            @include('basico.mobile.informacion.datos-personales')
            <!-- INFORMACION DE PAGO -->
                <div id="formas-pago">
                    <div class="row  bg-light p-2 border-bottom border-top ">
                        <div class="col-12 text-center">
                            <h5>@lang('informacion.forma_pago')</h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            @foreach($formas_pago as $indice => $formaPago)
                                @if($total_anticipo>0)
                                    <div class="alert border p-2">
                                        <div class="custom-control custom-radio custom-control-inline w-100">
                                            <input type="radio" id="payment-{{$formaPago->codigo}}"
                                                   class="custom-control-input forma_pago"
                                                   value="{{$formaPago->codigo}}"
                                                   data-indice="{{$indice}}"
                                                   name="forma_pago">
                                            <label class="custom-control-label w-100"
                                                   for="payment-{{$formaPago->codigo}}">
                                                <span class="mr-3">{{$formaPago->nombre}}</span>
                                                @if($formaPago->codigo==='tarjeta' && empty($formaPago->pasarela_pago))
                                                    @foreach($tarjetas_propiedad as $tarjeta)
                                                        <img id="card-{{$tarjeta->id}}" class="credit-card mr-2"
                                                             src="{{$tarjeta->imagen}}"
                                                             height="28" align="middle" style="opacity: 0.4;">
                                                    @endforeach
                                                @elseif($formaPago->codigo==='tarjeta' && !empty($formaPago->pasarela_pago))
                                                    @foreach($tarjetas_propiedad as $tarjeta)
                                                        <img id="card-{{$tarjeta->id}}" class="credit-card mr-2"
                                                             src="{{$tarjeta->imagen}}"
                                                             height="28" align="middle" style="opacity: 0.4;">
                                                    @endforeach
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    @if($formaPago->codigo==='tarjeta')
                                        <div class="alert border">
                                            <div class="custom-control custom-radio custom-control-inline w-100">
                                                <input type="radio" id="payment-{{$formaPago->codigo}}"
                                                       class="custom-control-input forma_pago"
                                                       value="{{$formaPago->codigo}}"
                                                       data-indice="{{$indice}}"
                                                       name="forma_pago">
                                                <label class="custom-control-label w-100"
                                                       for="payment-{{$formaPago->codigo}}">
                                                    <span class="mr-3">{{$formaPago->nombre}}</span>
                                                    @foreach($tarjetas_propiedad as $tarjeta)
                                                        <img id="card-{{$tarjeta->id}}" class="credit-card mr-2"
                                                             src="{{$tarjeta->imagen}}"
                                                             height="28" align="middle" style="opacity: 0.4;">
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                            @if($errors->has('forma_pago'))
                                <small class="invalid-feedback">{{$errors->first('forma_pago')}}</small>
                            @endif
                        </div>
                    </div>
                    @if($total_anticipo>0)
                        @foreach($formas_pago as $indice => $formaPago)
                            <section id="{{$formaPago->codigo}}" style="display: none;">
                                {{AppFormasPagos::cargarFormaPagoVista($indice, $formaPago)}}
                                @if($formaPago->codigo==='tarjeta' && empty($formaPago->pasarela_pago))
                                @section('script_'.$formaPago->codigo)
                                    {{AppFormasPagos::cargarScriptVista($indice, $formaPago)}}
                                @endsection
                                @elseif(!empty($formaPago->pasarela_pago))
                                @section('script_'.$formaPago->pasarela_pago->codigo.'_'.$formaPago->instrumento_pago->codigo)
                                    {{AppFormasPagos::cargarScriptVista($indice, $formaPago)}}
                                @endsection
                                @endif
                            </section>
                        @endforeach
                    @else
                        <section id="tarjeta" style="display: none;">
                            {{AppFormasPagos::cargarFormaPagoVista(0, $formaPago)}}
                        </section>
                    @endif
                </div>
                <input type="hidden" id="forma_pago" name="forma_pago" value="">
                @include('basico.mobile.informacion.total-pagar')
                {{--                    <button type="submit" id="pagar" class="btn btn-primary">Pagar</button>--}}
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
        let tarjetas = {!! json_encode($tarjetas_propiedad) !!};
        let informacionPago = {
            error: function () {
                return $("#validation-errors");
            },
            contenedor: function () {
                return $('.content_info');
            },
            spinner: function () {
                return $('.loading');
            },
            forma_pago: function () {
                return $('.forma_pago');
            },
            pago_tarjeta: function () {
                return $('#tarjeta');
            },
            pago_efectivo: function () {
                return $('#efectivo');
            },
            pago_transferencia: function () {
                return $('#transferencia');
            },
            pago_paypal: function () {
                return $('#paypal');
            },
            aceptar_terminos: function () {
                return $('#aceptar_terminos');
            },
            numero_tarjeta: function () {
                return $('#numero');
            },
            mes_expiracion: function () {
                return $('#expiracion-mes');
            },
            ano_expiracion: function () {
                return $('#expiracion-anio');
            },
            getTarjeta: function (numero) {
                $('.card-errors').addClass('d-none').html('');
                let tarjeta = false;
                for (let i = 0; i < tarjetas.length; i++) {
                    let exp = new RegExp(tarjetas[i].regla_numero);
                    if (exp.test(numero)) {
                        tarjeta = tarjetas[i];
                        break;
                    }
                }
                return tarjeta;
            },
            validarFechaExpiracion: function () {
                let mes = this.mes_expiracion();
                let ano = this.ano_expiracion();
                let hoy = new Date();

                if (parseInt(mes.val()) <= hoy.getMonth() + 1 && parseInt(ano.val()) <= hoy.getFullYear()) {
                    if (parseInt(mes.val()) < hoy.getMonth() + 1) {
                        mes.val(hoy.getMonth() + 1).change();
                    } else if (parseInt(ano.value) < hoy.getFullYear()) {
                        ano.val(hoy.getFullYear()).change();
                    }
                }
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
            $('#form').append('<input type="hidden" name="aceptar_terminos" value="true" />');
            var data = $('#form').serializeArray();
            // console.log(data);
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: window.url_create_reserva,
                data: data,
                dataType: 'json',
                success: function (response) {
                    // console.log('redireccion: ' + response);
                    window.location.href = response;
                },
                error: function (xhr) {
                    var mensaje = '';
                    if (!Array.isArray(xhr.responseJSON.message)) {
                        let parse = JSON.parse(xhr.responseJSON.message)
                        // console.log(parse);
                        if (Array.isArray(parse.mensaje)) {
                            mensaje = '<ul>'
                            if (parse.mensaje) {
                                var errorsAPI = parse.mensaje;
                                Object.keys(parse.mensaje).forEach(function (key) {
                                    mensaje += '<li>' + errorsAPI[key] + '</li>';
                                });
                                mensaje += '</ul>';
                            }
                        } else {
                            mensaje = parse.mensaje;
                        }
                    } else {
                        mensaje = '<ul>'
                        if (xhr.responseJSON.message) {
                            var errors = xhr.responseJSON.message;
                            Object.keys(xhr.responseJSON.message).forEach(function (key) {
                                mensaje += '<li>' + errors[key] + '</li>';
                            });
                            mensaje += '</ul>';
                        }
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

        const FormaPago = function (serializado) {
            const _modelo = JSON.parse(atob(serializado));
            this.onSelect = () => true;
            this.onUnselect = () => true;
            this.onSubmit = () => true;
            this.getModelo = () => _modelo;
            this.getContenedor = () => $(`#formas-pago #${this.getModelo().codigo}`);
            this.getElemento = (selector) => $(`#formas-pago #${this.getModelo().codigo} ${selector}`);
            this.prepararCargo = function (parametros, success) {
                Formulario.habilitarFormasPagos(false);
                Formulario.habilitarDatosPersonales(false);
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    url: window.url_preparar_pago,
                    method: 'post',
                    data: {
                        forma_pago: Formulario.getFormaPago(),
                        parametros: parametros,
                        titular: {
                            nombres: Formulario.getNombres(),
                            apellidos: Formulario.getApellidos(),
                            correo: Formulario.getCorreo(),
                            telefono: Formulario.getTelefono()
                        }
                    },
                    success: success,
                    error: function (xhr) {
                        const respuesta = JSON.parse(xhr.responseText);
                        var mensaje = '<ul>'
                        if (respuesta.message) {
                            var errors = respuesta.message;
                            Object.keys(respuesta.message).forEach(function (key) {
                                mensaje += errors[key] + '<br />';
                            });
                            mensaje += '</ul>';
                            Modal.mostrar(mensaje, 'Error de inicialización');
                        }
                        // informacionPago.forma_pago().val("").prop('checked', false);
                        // informacionPago.pago_tarjeta().hide();
                        Formulario.habilitarDatosPersonales(true);
                        Formulario.habilitarFormasPagos(true);
                    }
                });
            };
            this.debug = function (mensaje) {
                console.info(`[${this.getModelo().pasarela_pago.codigo}.${this.getModelo().instrumento_pago.codigo}] ${mensaje}`);
            };
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
            },
            habilitarFormasPagos: function (activo) {
                $("#payment-tarjeta").prop('disabled', !activo);
                $("#payment-efectivo").prop('disabled', !activo);
                $("#payment-transferencia").prop('disabled', !activo);
                $("#payment-paypal").prop('disabled', !activo);
            },
        }

        $(document).ready(function () {
            informacionPago.numero_tarjeta().on('blur', function () {
                let card = informacionPago.getTarjeta(this.value);
                $('.credit-card').fadeTo('fast', 0.4);
                if (!card) return false;
                $('#card-' + card.id).fadeTo('fast', 1);
            });
            informacionPago.ano_expiracion().on('change', function () {
                informacionPago.validarFechaExpiracion();
            });
            informacionPago.forma_pago().on('change', function (e) {
                let metodo = $(this).val();
                const indice = $(e.target).data('indice');
                const formaPago = FormasPago[indice];
                $("#forma_pago").val(indice);
                // console.log(metodo);
                formaPago.onSelect();
                if (metodo === 'tarjeta') {
                    informacionPago.pago_tarjeta().show();
                    informacionPago.pago_efectivo().hide();
                    informacionPago.pago_transferencia().hide();
                    informacionPago.pago_paypal().hide();
                }
                if (metodo === 'efectivo') {
                    informacionPago.pago_tarjeta().hide();
                    informacionPago.pago_efectivo().show();
                    informacionPago.pago_transferencia().hide();
                    informacionPago.pago_paypal().hide();
                }
                if (metodo === 'transferencia') {
                    informacionPago.pago_tarjeta().hide();
                    informacionPago.pago_efectivo().hide();
                    informacionPago.pago_transferencia().show();
                    informacionPago.pago_paypal().hide();
                }
                if (metodo === 'paypal') {
                    informacionPago.pago_tarjeta().hide();
                    informacionPago.pago_efectivo().hide();
                    informacionPago.pago_transferencia().hide();
                    informacionPago.pago_paypal().show();
                }
            });
            const totalPagar = parseFloat({!! $total_anticipo !!}) || 0.00;

            // if (totalPagar > 0) $('#formas-pago input, #formas-pago select, #formas-pago textarea').prop('disabled', true);

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
                    const indice = Formulario.getFormaPago();
                    const hayPasarela = indice !== null;
                    if (totalPagar > 0 && !hayPasarela) {
                        Modal.mostrar('Debe elegir una forma de pago.');
                        cancelarProceso();
                        return false;
                    } else if (totalPagar > 0 && hayPasarela) {
                        if (FormasPago[indice].getModelo().pasarela_pago) {
                            return FormasPago[indice].onSubmit(this);
                        } else {
                            let numeroInvalido = informacionPago.getTarjeta(FormasPago[indice].getElemento("#numero").val())
                            if (!numeroInvalido) {
                                cancelarProceso();
                                Modal.mostrar('Número de tarjeta invalida.');
                            } else {
                                procesarReserva();
                            }
                        }
                    } else if (totalPagar === 0) {
                        let numeroInvalido = informacionPago.getTarjeta(FormasPago[indice].getElemento("#numero").val())
                        if (!numeroInvalido) {
                            cancelarProceso();
                            Modal.mostrar('Número de tarjeta invalida.');
                        } else {
                            procesarReserva();
                        }
                    }
                }
            });
        });

        const FormasPago = [
            @foreach($formas_pago as $formaPago)
            new FormaPago('{{ AppFormasPagos::jshex($formaPago)}}'),
            @endforeach
        ];


    </script>
@endsection

