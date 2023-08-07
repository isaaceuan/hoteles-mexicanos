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
    </style>
@endsection
@section('content')
    <div class="contentMenu">
        <div class="card rounded-0 border-0" id="finishCancel">
            <div class="text-center">
                <div class="card-header text-center border-top">
                    <h5 class="mb-0"> @lang('modificar.cancelar.titulo')</h5>
                </div>
                <div class="card-body">
                    <p>@lang('modificar.cancelar.mensaje')</p>
                </div>
                <div class="card-footer bg-white border-0 justify-content-between text-center">
                    <button type="button" id="btnFinalizar" class="btn btn-primary"
                            onclick="window.location='{{ URL::route('modificar.salir', app()->getLocale(), false) }}'">@lang('reserva.finalizar')</button>
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
            $('#btnFinalizar').click(function (e) {
                variables.spinner().removeClass('d-none');
            });

        });
    </script>
@endsection
