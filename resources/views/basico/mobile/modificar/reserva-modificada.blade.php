@extends('basico.mobile.base')
@section('title.page')@lang('title.modificaciones_confirmacion')@endsection
@section('styles')
    <style>
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        body {
            background-color: #FFFFFF !important;
        }
    </style>
@endsection
@section('content')
    <div class="contentMenu">
        <div class="card rounded-0 border-0" id="finishCancel">
            <div class="text-center">
                <div class="card-header bg-white border-bottom-0 pb-0 text-center border-top">
                    <h5>@lang('reserva.finalizada')</h5>
                    <p class="mb-1">@lang('modificar.finalizada.mensaje')</p>
                    <p>@lang('reserva.texto_finalizada', ['email' => $detalleReserva->huesped->contacto->correo])</p>
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table ">
                            <tbody>
                            <tr class="">
                                <th scope="row" class="text-uppercase">
                                    @lang('reserva.habitacion') 1
                                </th>
                                <td>@lang('reserva.confirmacion') #: <b>{{$detalleReserva->folio}}</b></td>
                                <td>
                                    <button type="button" class="btn btn-primary"
                                            onclick="return abrirVentana({{$detalleReserva->id}});">
                                        <i class="fa fa-print mr-1"></i> @lang('reserva.imprimir')
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 justify-content-between text-center">
                    <button type="button" class="btn btn-primary"
                            onclick="window.location='{{ $redireccion }}'">@lang('reserva.finalizar')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
@endsection
@section('scripts')
    <script type="text/javascript">
        function abrirVentana(id) {
                {{--var url = "{{route('api.detalle.reserva',[':id'])}}".replace(':id', id);--}}
            var url = "{{route('api.reserva.detalle.modificada',[app()->getLocale(),':id'], false)}}".replace(':id', id);
            var win = window.open(
                url,
                'print_form',
                'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=740,height=600,left=150,top=184'
            );
            return false;
        }
    </script>
@endsection
