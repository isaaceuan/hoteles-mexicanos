<div class="form-row">
    <div class="col-12 form-group">
        <label for="numero"> *@lang('informacion.numero_tarjeta')</label>
        <div id="numero" class="input empty form-control"></div>
    </div>
    <div class="col-12 form-group">
        <label for="codigo">*@lang('informacion.numero_seguridad')</label>
        <div id="codigo" class="input empty form-control"></div>
    </div>
    <div class="col-12 form-group">
        <label for="expiracion">*@lang('informacion.fecha_expiracion')</label>
        <div id="expiracion" class="input empty form-control"></div>
    </div>
</div>

<div class="text-right">
    <img src="/imagenes/stripelogo.svg.png" alt="Stripe" width="75">
</div>
<input type="hidden" id="token" name="parametros[token]" value="">
@section('scripts_stripe')
    <script type="text/javascript" src="https://js.stripe.com/v3"></script>
@endsection
