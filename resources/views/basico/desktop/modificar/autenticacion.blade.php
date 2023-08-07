@extends('basico.desktop.base-admin')
@section('title.page')@lang('title.modificaciones_cancelaciones')@endsection
@section('styles')
    <style>
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="contentInicio my-4">
        <div class="row">
            <div class="col-md-12 pr-0">
                <div class="card rounded-0 border-0 shadow">
                    <div class="card-header bg-white mt-md-3 border-bottom-0 pb-0">
                        <h4 class="text-center">@lang('modificar.login.especifique')</h4>
                        <hr class="bg-acento">
                    </div>
                    <div class="card-body">
                        <form id="formLogin" class="validate"
                              action="{{route('modificar.validacion',app()->getLocale(),false)}}"
                              method="post">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-right font-weight-bold">
                                    @lang('modificar.login.correo'):
                                </label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" required id="email" name="email"
                                           autocomplete="false">
                                    @if( $errors->has('email'))
                                        <small class="text-danger">{{$errors->first('email')}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="code" class="col-sm-4 col-form-label text-right font-weight-bold">
                                    @lang('modificar.login.clave_reservacion'):
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" required id="code" name="code"
                                           autocomplete="false">
                                    @if( $errors->has('code'))
                                        <small class="text-danger">{{$errors->first('code')}}</small>
                                    @endif
                                </div>

                            </div>
                            <div class="text-center">
                                <a class="btn btn-secondary" href="{{route('app.inicio', app()->getLocale(),false)}}">
                                    <i class="fa fa-chevron-left"></i> @lang('modificar.login.regresar') </a>
                                <button id="btnBuscar" class="btn btn-primary" type="submit">
                                    @lang('modificar.login.buscar')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modalError" tabindex="-1" role="dialog"
         data-backdrop="static" data-keyboard="false"
         aria-labelledby="modalError"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body row">
                    <div class="col-1">
                        <i class="fa fa-3x fa-info color-acento"></i>
                    </div>
                    <div class="col-10" v-if="datos">
                        <p class="my-2"> @lang('modificar.login.sin_registros')</p>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        @lang('modificar.login.aceptar')
                    </button>
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
        $(document).ready(function () {
            $("#formLogin").validate({
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
                    $('#btnBuscar').hide();
                    form.submit();
                }
            });
        });
    </script>
    @if(!empty(Session::get('reserva')))
        <script>
            $(function () {
                $('#modalError').modal('show');
            });
        </script>
    @endif
@endsection
