<div class="jumbotron cardPPLS text-center">
    <p class="lead">@lang('formaspagos.completar')</p>
</div>
<div id="paypal_plus"></div>
<input type="hidden" id="pago_id" name="parametros[pago_id]" value="">
<input type="hidden" id="pagador_id" name="parametros[pagador_id]" value="">
@section('scripts_paypal')
    <script type="text/javascript"
            data-namespace="paypal_sdk"
            src="https://www.paypal.com/sdk/js?client-id={{$forma_pago->pasarela_pago->configuraciones->client_id}}"></script>
    <script type="text/javascript"
            src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js?ver=3.1.2"></script>
@endsection
