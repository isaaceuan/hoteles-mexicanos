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
    <div class="contentMenu my-4">
        <div class="card rounded-0 border-0 shadow" id="finishCancel">
            <div class="text-center">
                <div class="card-header text-center">
                    <h4>@lang('modificar.cancelar.titulo')</h4>
                </div>
                <div class="card-body">
                    <p>@lang('modificar.cancelar.mensaje')</p>
                </div>
                <div class="card-footer bg-white border-0 justify-content-between text-center">
                    <button type="button" class="btn btn-primary"
                            onclick="window.location='{{ URL::route('modificar.salir', app()->getLocale(),false) }}'">@lang('reserva.finalizar')</button>
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
                    <h5 class="modal-title">@lang('modificar.datos_personales.error_titulo')</h5>
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
@endsection
