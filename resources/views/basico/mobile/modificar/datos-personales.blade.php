@extends('basico.mobile.base')
@section('title.page')@lang('title.modificaciones_cancelaciones')@endsection
@section('styles')
    <style>
        form label{
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <div class="contentMenu">
        <div class="card rounded-0 border-0" id="guest">
            <div class="col-md-12 text-center">
                <div class="text-center">
                    <div class="row  bg-light border-bottom border-top  mb-3">
                        <div class="col-12 py-2">
                            <a class="cursor-pointer cargador btn btn-primary btn-sm float-left"
                               href="{{route('modificar.menu', app()->getLocale(), false)}}">
                                <i class="fa fa-lg fa-arrow-left"></i>
                            </a>
                            <h6 class="text-center mb-0 mt-1">@lang('informacion.datos_personales')</h6>
                        </div>
                    </div>
                    <form id="formSaveGuest">
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
                                                title="---" id="titulo" name="huesped[titulo]"
                                                @if($propiedadMotor->campo_titulo == 'requerido') required @endif>
                                                {{--<option value=""></option>--}}
                                                @foreach($titulos as $item)
                                                    <option
                                                        value="{{$item->titulo}}" {{ $titular->titulo == $item->titulo ? 'selected' : '' }}>{{$item->descripcion}}</option>
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
                                               name="huesped[nombre]"
                                               value="{{ $titular->nombre }}">
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
                                               name="huesped[apellido]" value="{{ $titular->apellido }}">
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
                                               id="correo" maxlength="85" required autocomplete="off"
                                               name="huesped[contacto][correo]"
                                               value="{{ $titular->contacto->correo }}">
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
                                        <input type="text"
                                               class="form-control @if($errors->has('telefono')){{'border-danger'}}@endif"
                                               id="telefono" minlength="10" maxlength="20" required autocomplete="off"
                                               name="huesped[contacto][telefono_1]" value="{{ $titular->contacto->telefono_1 }}">
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
                                            <input type="text"
                                                   class="form-control @if($errors->has('telefono_otro')){{'border-danger'}}@endif"
                                                   id="telefono_otro" maxlength="10" autocomplete="off"
                                                   name="huesped[contacto][telefono_2]"
                                                   @if($propiedadMotor->campo_telefono_otro == 'requerido') required
                                                   @endif value="{{ $titular->contacto->telefono_2 }}">
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
                                                   id="direccion" maxlength="190" autocomplete="off"
                                                   name="huesped[domicilio][direccion]"
                                                   @if($propiedadMotor->campo_direccion == 'requerido') required
                                                   @endif value="{{ $titular->domicilio->direccion }}">
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
                                                   id="ciudad" maxlength="20" autocomplete="off" name="huesped[domicilio][ciudad]"
                                                   @if($propiedadMotor->campo_ciudad == 'requerido') required
                                                   @endif value="{{ $titular->domicilio->ciudad }}">
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
                                                   id="estado" maxlength="25" autocomplete="off" name="huesped[domicilio][estado]"
                                                   @if($propiedadMotor->campo_estado == 'requerido') required
                                                   @endif value="{{ $titular->domicilio->estado }}">
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
                                                class="selectpicker form-control @if($errors->has('pais')){{'border-danger'}}@endif"
                                                data-live-search="true"
                                                data-live-search-normalize="true"
                                                title="---" id="pais" name="huesped[domicilio][pais_id]"
                                                @if($propiedadMotor->campo_pais == 'requerido') required @endif>
                                                @foreach($paises as $pais)
                                                    <option
                                                        value="{{$pais->id}}" {{ $titular->domicilio->pais_id  == $pais->id ? 'selected' : '' }}>{{$pais->nombre}}
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
                                                   name="huesped[domicilio][codigo_postal]"
                                                   @if($propiedadMotor->campo_cp == 'requerido') required
                                                   @endif value="{{ $titular->domicilio->codigo_postal }}">
                                            @if($errors->has('codigo_postal'))
                                                <small
                                                    class="invalid-feedback">{{$errors->first('codigo_postal')}}</small>
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
                                <div class="form-group row">
                                    <label for="comentarios" class="col-sm-2 col-form-label">
                                        @lang('informacion.comentarios')
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea
                                            class="form-control"
                                            rows="3"
                                            id="comentarios" autocomplete="off"
                                            name="comentarios">{{ $comentarios }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5 mt-2">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block"
                                        type="submit"
                                        id="btnSaveGuest">
                                    @lang('modificar.datos_personales.guardar')
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="validation-errors" class="alert alert-success d-none">
                        @lang('modificar.datos_personales.completado')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div id="modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('modificar.datos_personales.error_titulo')</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang('modificar.menu.cerrar')</button>
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
        var variables = {
            success: function () {
                return $('.alert-success');
            },
            spinner: function () {
                return $('.loading');
            },
            btnSave: function () {
                return $('#btnSaveGuest');
            }
        }

        const Modal = {
            mostrar: function (mensaje) {
                const elemento = $("#modal");
                elemento.find('.modal-body p').html(mensaje);
                elemento.modal('show');
            }
        };

        $(document).ready(function () {
            $('a.cargador').click(function (e) {
                variables.spinner().removeClass('d-none');
            });
            $("#formSaveGuest").validate({
                lang: '{{app()->getLocale()}}',
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback text-left');
                    element.after(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    // Modal.mostrar();
                    saveGuest();
                }
            });
        });


        function saveGuest() {
            variables.spinner().removeClass('d-none');
            variables.btnSave().attr('disabled', true);
            var data = $('#formSaveGuest').serializeArray();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: window.url_actualizar_datos_personales,
                data: data,
                dataType: 'json',
                success: function (response) {
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    variables.btnSave().attr('disabled', false);
                    console.log(response + 'success');
                    variables.spinner().addClass('d-none');
                    variables.success().removeClass('d-none');
                    setTimeout(() => {
                        variables.success().addClass('d-none');
                    }, 5000);
                },
                error: function (xhr) {
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    variables.btnSave().attr('disabled', false)
                    variables.spinner().addClass('d-none');
                    const respuesta = JSON.parse(xhr.responseText);
                    var mensaje = '<ul>'
                    if (respuesta.message) {
                        var errors = respuesta.message;
                        Object.keys(respuesta.message).forEach(function (key) {
                            mensaje += '<li>' + errors[key] + '</li>';
                        });
                        mensaje += '</ul>';
                        Modal.mostrar(mensaje);
                    }
                }
            });
        }
    </script>
@endsection
