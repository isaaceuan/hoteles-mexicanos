@foreach($propiedadMotor->scripts as $script)
    @if($script->id==='google-adwor')
        <!-- Google Ads: {% $system.hotel.seo.tracking.adwords.id %} -->
        <script type="text/javascript"
                src="https://www.googletagmanager.com/gtag/js?id=AW-{{$script->pivot->configuracion[0]->valor}}"></script>
        <script type="text/javascript">
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', 'AW-{{$script->pivot->configuracion[0]->valor}}');
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
            @foreach($reservas as $key => $reserva)
            // Begin conversion.
            gtag('event', 'conversion', {
                'send_to': "AW-{{$script->pivot->configuracion[0]->valor}}/{{$script->pivot->configuracion[1]->valor}}",
                'value': parseFloat({{round($reserva->total, 2)}}),
                'currency': "{{$reserva->moneda_id}}",
                'transaction_id': "{{$reserva->folio}}"
            });
            @endforeach
            @endif
            // End conversion.
        </script>
        <!-- /Google Ads: {% $system.hotel.seo.tracking.adwords.id %} -->
    @endif
@endforeach


