@extends('basico.mobile.base')
@section('title.page')@lang('title.confirmacion')@endsection
@section('scripts_header_bottom')
    @include('scripts.header-bottom')
@endsection
@section('scripts_body_bottom')
    @include('scripts.body-bottom')
@endsection
@section('styles')
    <style>
        .sticky-top-steps {
            position: static; !important;
        }
        .iconoHeaderCarrito{
            display: none !important;
        }
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
    <div class="contentConfirmacion">
        <div class=" card rounded-0 border-0 sidebar">
            @include('basico.mobile.componentes.steps')
            <div class="card-header bg-white mt-3 border-bottom-0 pb-0">
                <h5 class="text-center">@lang('reserva.finalizada')</h5>
                <p class="text-center">@lang('reserva.texto_finalizada', ['email' => $reservas[0]->huesped->contacto->correo])</p>
{{--                <hr class="bg-acento">--}}
            </div>
            <div class="card-body text-center">
                <div class="table-responsive">
                    <table class="table ">
                        <tbody>
                        @foreach($reservas as $key => $reserva)
                            <tr class="">
                                <th scope="row" class="text-uppercase font-12">
                                    @lang('reserva.habitacion') {{$key + 1}}
                                </th>
                                <td>@lang('reserva.confirmacion') #: <b>{{$reserva->folio}}</b></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm"
                                            onclick="return abrirVentana({{$reserva->id}});">
                                        <i class="fa fa-print mr-1"></i> @lang('reserva.imprimir')
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($propiedadMotor->con_mensaje_confirmacion)
                        <p class="mt-5">
                            {!!$propiedadMotor->mensaje_confirmacion!!}
                        </p>
                    @endif
                </div>
            </div>
            <div class="card-footer justify-content-between text-center border-bottom">
                <button type="button" class="btn btn-primary btn-sm"
                        onclick="window.location='{{ $redireccion }}'">@lang('reserva.finalizar')</button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function abrirVentana(id) {
                {{--var url = "{{route('api.detalle.reserva',[':id'])}}".replace(':id', id);--}}
            var url = "{{route('api.reserva.detalle',[app()->getLocale(),':id'],false)}}".replace(':id', id);
            var win = window.open(
                url,
                'print_form',
                'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=740,height=600,left=150,top=184'
            );
            return false;
        }
    </script>
@endsection

