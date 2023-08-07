@extends('basico.desktop.base')
@section('title.page')@lang('title.modificaciones_informacion')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('styles')
    <style>
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
    <div class="row mt-3">
        <div class="col-md-9 pr-3">
            @include('basico.desktop.modificar.componentes.steps')
            <div class="text-center mt-4 loading d-none">
                <div class="spinner-border text-acento " style="width: 4rem; height: 4rem;" role="status">
                </div>
            </div>
            <div class="container bg-white card content_info">
                <!-- DATOS PERSONALES -->
                <form id="form" class="form">
                @include('basico.desktop.modificar.informacion.datos-personales')
                <!-- INFORMACION DE PAGO -->
                    @include('basico.desktop.modificar.informacion.total-pagar')
                </form>
            </div>
        </div>
        <div class="col-md-3 p-0 sticky">
            <modificar-carrito-reservas-component
                :reserva="{{json_encode(AppModificarReserva::recuperarSesion(),true)}}"
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}"
                :monedas="{{json_encode(AppMonedas::getMonedas(),true)}}"
                :propiedad="{{json_encode(AppPropiedad::getPropiedad(),true)}}"
                :color_cargador="'{{@$marca->color_acento}}'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :codigo_promocion="'{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}'"
                :next_url="''"
                :prev_url="'{{ route('modificar.complementos',[
'locale'=>app()->getLocale()
],false)}}'"
                :step="'informacion'">
            </modificar-carrito-reservas-component>
            <modal-carrito-detalle-noches-component
                :step="'informacion'"
                :color_cargador="'{{@$marca->color_acento}}'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
            </modal-carrito-detalle-noches-component>
            <modal-carrito-detalle-complemento-component
                :step="'informacion'"
                :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
            </modal-carrito-detalle-complemento-component>
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
            },
            aceptar_terminos: function () {
                return $('#aceptar_terminos');
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
            // console.log(data);
             $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
             $.ajax({
                 type: "POST",
                 url: window.url_modificar_reserva,
                 data: data,
                 dataType: 'json',
                 success: function (response) {
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
                    procesarReserva();
                }
            });
        });
    </script>
@endsection

