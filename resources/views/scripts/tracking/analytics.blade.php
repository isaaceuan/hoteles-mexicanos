@foreach($propiedadMotor->scripts as $script)
    @if($script->id==='google-analy')
        <!-- Google Analytics -->
        <script type="text/javascript">
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', '{{$script->pivot->configuracion[0]->valor}}', 'auto', {'allowLinker': true});
            ga('require', 'linker');
            ga('linker:autoLink', ['{{$propiedad->pagina_web}}']);
            ga('send', 'pageview');
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
            ga('require', 'ecommerce');

            ga('ecommerce:addTransaction', {
                'id': '{{$reserva->folio}}',
                'affiliation': "{{$propiedad->nombre}}",
                'revenue': '{{$reserva->total}}',
                'tax': '{{$reserva->total_impuestos}}',
                'currency': '{{$reserva->moneda_id}}'
            });

            ga('ecommerce:addItem', {
                'id': '{{$reserva->folio}}',
                'name': "{{$reserva->tipo_habitacion->nombre}}",
                'sku': "{{$reserva->tipo_habitacion->codigo}}",
                'category': 'Room',
                'price': '{{$reserva->total}}',
                'quantity': '1'
            });

            ga('ecommerce:send');
            @endforeach
            @endif
            // End conversion.
        </script>
        <!-- End Google Analytics -->
    @endif
@endforeach


