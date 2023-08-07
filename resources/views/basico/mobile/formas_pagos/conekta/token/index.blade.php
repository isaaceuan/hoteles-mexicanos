<div class="row">
    <div class="col-md-12">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="propietario">
                    *@lang('informacion.nombre_titular')
                </label>
                <div class="col-sm-9">
                    <input type="text" size="20"  id="propietario" class="form-control" name="propietario" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="numero">
                    *@lang('informacion.numero_tarjeta')
                </label>
                <div class="col-sm-9">
                    <input type="text" minlength="13"  maxlength="16" id="numero" class="form-control" name="numero" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="codigo"
                       class="col-sm-3 col-form-label float-left">*@lang('informacion.numero_seguridad')
                </label>
                <div class="col-sm-2 float-left">
                    <input type="password" size="4" maxlength="4" id="codigo" name="codigo" class="form-control" required>
                </div>
                <label for="expiracion-mes"
                       class="col-sm-3 col-form-label float-left">*@lang('informacion.fecha_expiracion')</label>
                <div class="col-6 float-left">

                    <select
                        class="form-control"
                        name="expiracion-mes"
                        id="expiracion-mes" required>
                        <option value="" selected="selected">[@lang('informacion.mes')]</option>
                        @for($mes = 1; $mes <= 12; $mes ++)
                            <option
                                value="{{$mes}}" {{ old('expiracion-mes') == $mes ? 'selected' : '' }}>{{$mes}}</option>
                        @endfor
                    </select>

                </div>
                <div class="col-6 float-left">
                    <select
                        class="form-control"
                        name="expiracion-anio"
                        id="expiracion-anio" required>
                        <option value="" selected="selected">[@lang('informacion.ano')]</option>
                        @for($ano = now()->year; $ano <= (now()->year + 8); $ano++)
                            <option
                                value="{{$ano}}" {{ old('expiracion-anio') == $ano ? 'selected' : '' }}>{{$ano}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        <div class="text-right">
            <img src="/imagenes/logo_conekta_color.svg" alt="Conekta" width="75">
        </div>
    </div>
</div>
<input type="hidden" id="token" name="parametros[token]" value="">
@section('scripts_conekta')
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
@endsection
