<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="propietario">
                *@lang('informacion.nombre_titular')
            </label>
            <div class="col-sm-9">
                <input type="text"
                       id="propietario"
                       name="tarjeta[propietario]"
                       class="form-control"
                       value="{{ old('propietario') }}"
                       required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                *@lang('informacion.numero_tarjeta')
            </label>
            <div class="col-sm-9">
                <input type="text"
                       minlength="13"
                       maxlength="16"
                       id="numero"
                       name="tarjeta[numero]"
                       class="form-control"
                       required>
            </div>
        </div>
        <div class="form-group row">
            <label for="codigo"
                   class="col-sm-3 col-form-label float-left">*@lang('informacion.numero_seguridad')
            </label>
            <div class="col-sm-2 float-left">
                <input type="password"
                       size="4"
                       maxlength="4"
                       id="codigo"
                       name="tarjeta[codigo]"
                       class="form-control"
                       value="{{ old('codigo') }}"
                       required>
            </div>
            <label for="expiracion-mes"
                   class="col-sm-3 col-form-label float-left">*@lang('informacion.fecha_expiracion')</label>
            <div class="col-6 float-left">

                <select
                    class="form-control"
                    name="tarjeta[expiracion_mes]"
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
                    name="tarjeta[expiracion_anio]"
                    id="expiracion-anio" required>
                    <option value="" selected="selected">[@lang('informacion.ano')]</option>
                    @for($ano = now()->year; $ano <= (now()->year + 8); $ano++)
                        <option
                            value="{{$ano}}" {{ old('expiracion-anio') == $ano ? 'selected' : '' }}>{{$ano}}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
</div>
