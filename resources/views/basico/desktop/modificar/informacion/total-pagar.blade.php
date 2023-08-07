<div class="row pb-4 pt-3">
    <div class="col-12">
        <div class="rate-policies text-left px-5">
            <b>@lang('informacion.detalle')s:</b>
            <p id="payment_amount" class="mb-4">
                @lang('informacion.reserva_modificada')
{{--                <carrito-total-component--}}
{{--                    :total_carrito="{{$total_anticipo}}"--}}
{{--                    :total_saldo="{{$total_saldo}}"--}}
{{--                    :detalle_anticipo="{{json_encode($resumen_anticipo,true)}}"--}}
{{--                    :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">--}}
{{--                </carrito-total-component>--}}
            </p>
        </div>
        <div class="field">
            <div class=" mb-3 custom-control custom-checkbox text-center d-flex justify-content-center align-items-baseline">
                <input type="checkbox" class="custom-control-input" id="aceptar_terminos"
                       onclick="habilitarBotonPagar()"
                       name="aceptar_terminos" required>
                <label class="custom-control-label"
                       for="aceptar_terminos">@lang('informacion.terminos')</label>
                <a data-toggle="modal"
                   data-target="#modalPolitica" class="text-danger cursor-pointer">
                    (@lang('informacion.leer_politicas'))
                </a>
            </div>
            @if($errors->has('aceptar_terminos'))
                <small class="invalid-feedback">{{$errors->first('aceptar_terminos')}}</small>
            @endif
            <div class="text-center">
                <button class="btn btn-primary btn-lg" id="pagar"
                        type="button"
                        onclick="enviarFormulario()"
                        disabled>@lang('informacion.guardar_reserva')</button>
            </div>
        </div>
    </div>
</div>
