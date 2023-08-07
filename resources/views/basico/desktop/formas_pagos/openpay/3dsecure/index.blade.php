<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="propietario">
        *@lang('informacion.nombre_titular')
    </label>
    <div class="col-sm-9">
        <input type="text" id="propietario" class="form-control" name="propietario"
               autocomplete="off" autocapitalize="off" spellcheck="false"
               data-openpay-card="holder_name" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="numero">
        *@lang('informacion.numero_tarjeta')
    </label>
    <div class="col-sm-9">
        <input type="text" minlength="13" maxlength="16" id="numero" class="form-control" name="numero" required
               data-openpay-card="card_number"  autocomplete="off" autocapitalize="off"
               spellcheck="false">
    </div>
</div>


<div class="form-group row">
    <label for="codigo"
           class="col-sm-3 col-form-label float-left">*@lang('informacion.numero_seguridad')
    </label>
    <div class="col-sm-2 float-left">
        <input type="password" size="4" maxlength="4" id="codigo" class="form-control" name="codigo"
               data-openpay-card="cvv2" autocomplete="off" autocapitalize="off" spellcheck="false" required>
    </div>
    <label for="expiracion-mes"
           class="col-sm-3 col-form-label float-left">*@lang('informacion.fecha_expiracion')</label>
    <div class="col-sm-2 float-left">

        <select
            class="form-control"
            data-openpay-card="expiration_month"
            name="expiracion-mes"
            id="expiracion-mes" required>
            <option value="" selected="selected">[@lang('informacion.mes')]</option>
            @for($mes = 1; $mes <= 12; $mes ++)
                <option
                    value="{{$mes}}" {{ old('expiracion-mes') == $mes ? 'selected' : '' }}>{{$mes}}</option>
            @endfor
        </select>

    </div>
    <div class="col-sm-2 float-left">
        <select
            class="form-control"
            data-openpay-card="expiration_year"
            name="expiracion-anio"
            id="expiracion-anio" required>
            <option value="" selected="selected">[@lang('informacion.ano')]</option>
            @for($ano = now()->year; $ano <= (now()->year + 8); $ano++)
                <option
                    value="{{substr($ano, -2)}}" {{ old('expiracion-anio') == $ano ? 'selected' : '' }}>{{$ano}}</option>
            @endfor
        </select>
    </div>
</div>
<div class="text-right">
    <img src="/imagenes/openpay.png" alt="Openpay" width="150">
</div>
<input type="hidden" id="token" name="parametros[token]" value="">
@section('scripts_openpay')
    <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script type="text/javascript" src="https://js.openpay.mx/openpay-data.v1.min.js"></script>
@endsection
