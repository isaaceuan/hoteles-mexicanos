@foreach($propiedadMotor->scripts as $script)
        @if($script->id==='google-tagm')

            <!-- Begin Google Tag Manager -->
            <script type="text/javascript" src="https://www.googletagmanager.com/gtm.js?id={{$script->pivot->configuracion[0]->valor}}"></script>
            <!-- End Google Tag Manager -->
            @if('app.reservacion.garantia.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.conekta.token.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.conekta.oxxo.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.conekta.spei.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.openpay.token.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.openpay.3dsecure.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.openpay.tienda.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.openpay.banco.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.stripe.token.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.paypal.plus.confirmada' == Route::currentRouteName() ||
                  'app.reservacion.paypal.chekout.confirmada' == Route::currentRouteName())
            <!-- Begin Google Tag Manager Data Layer -->
            <script type="text/javascript">
                window.dataLayer = window.dataLayer || [];
                @foreach($reservas as $key => $reserva)
                dataLayer.push({
                        'transactionId': "{{$reserva->folio}}",
                        'transactionAffiliation': "{{$propiedad->nombre}}",
                        'transactionTotal': {{$reserva->total}},
                    'transactionTax': {{$reserva->total_impuestos}},
                'transactionProducts': [{
                    'sku': "{{$reserva->tipo_habitacion->codigo}}",
                    'name': "{{$reserva->tipo_habitacion->nombre}}",
                    'price': {{$reserva->total_hospedaje+$reserva->total_alimentos+$reserva->total_complementos}},
                    'quantity': 1
                }],
                'extra': {
                    'checkin': "{{ $reserva->fecha_entrada }}",
                        'checkout': "{{ $reserva->fecha_salida }}",
                        'adults': {{ $reserva->detalle_actual->adultos }},
                    'children': {{ $reserva->detalle_actual->ninos1 + $reserva->detalle_actual->ninos2 + $reserva->detalle_actual->ninos3}},
                    'promocode': "{{ $reserva->codigo_promocional }}",
                        'guest': "{{ $reserva->titular->nombres.' '.$reserva->titular->apellidos }}",
                        'rate': "{{ $reserva->tarifa->nombre}}",
                        'currency': "{{$reserva->moneda_id}}",
                        'amount': {
                            'stay': {{$reserva->total_hospedaje}},
                            'addons': {{$reserva->total_complementos}},
                            'taxes': {{$reserva->total_impuestos}},
                            'fees': {{$reserva->total_propinas}},
                            'total': {{$reserva->total}},
                    }
                }
                });
                @endforeach
            </script>
            <!-- End Google Tag Manager Data Layer -->
            @endif
        @endif
    @endforeach


