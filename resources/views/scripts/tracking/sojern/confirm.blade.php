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
    @foreach($propiedadMotor->scripts as $script)
        @if($script->id==='sojern')
            @foreach($script->pivot->configuracion as $config)
                @if($config->codigo==='PCON' && $config->valor)
            <script>
                (function () {
                    /* Please fill the following values. */
                    var params = {
                        hd1: "{{AppBusqueda::recuperar()->getLlegada()}}", /* Check In Date. Format yyyy-mm-dd. Ex: 2015-02-14 */
                        hd2: "{{AppBusqueda::recuperar()->getSalida()}}", /* Check Out Date. Format yyyy-mm-dd. Ex: 2015-02-14 */
                        hc1: "{{$propiedad->ciudad}}", /* Destination City */
                        hs1: "{{$propiedad->pais_id}}", /* Destination State or Region */
                        hpr: "{{$propiedad->nombre}}", /* Hotel Property */
                        hr: "{{count($reservas)}}", /* Number of Rooms */
                        hpid: "{{$propiedad->id}}", /* Property ID */
                        t: "{{AppBusqueda::recuperar()->getAdultos() + AppBusqueda::recuperar()->getNinos1() + AppBusqueda::recuperar()->getNinos2() + AppBusqueda::recuperar()->getNinos3()}}", /* Number of Travelers */
                        hcu: "{{$propiedad->moneda_id}}" /* Purchase Currency */
                    };

                    /* Please do not modify the below code. */
                    var cid = [];
                    var paramsArr = [];
                    var cidParams = [];
                    var pl = document.createElement('script');
                    var defaultParams = {"vid":"hot","et":"hc"};
                    for(key in defaultParams) { params[key] = defaultParams[key]; };
                    for(key in cidParams) { cid.push(params[cidParams[key]]); };
                    params.cid = cid.join('|');
                    for(key in params) { paramsArr.push(key + '=' + encodeURIComponent(params[key])) };
                    pl.type = 'text/javascript';
                    pl.async = true;
                    pl.src = 'https://beacon.sojern.com/pixel/p/{{$config->valor}}?f_v=v6_js&p_v=1&' + paramsArr.join('&');
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(pl);
                })();
            </script>
                @endif
            @endforeach
        @endif
    @endforeach
@endif


