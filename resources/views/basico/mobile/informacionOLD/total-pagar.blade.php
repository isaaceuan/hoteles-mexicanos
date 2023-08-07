<div class="row pb-4 pt-3">
    <div class="col-12">
        <div class="rate-policies text-center mb-4">
            <b id="payment_amount">
                <carrito-total-garantia-component
                    :total_carrito="{{$total_anticipo}}"
                    :total_saldo="{{$total_saldo}}"
                    :detalle_anticipo="{{json_encode($resumen_anticipo,true)}}"
                    :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                </carrito-total-garantia-component>
            </b>
        </div>
        <div class="field">
            <div class=" mb-3 custom-control custom-checkbox text-center">
                <input type="checkbox" class="custom-control-input" id="aceptar_terminos"
                       onclick="habilitarBotonPagar()"
                       name="aceptar_terminos" required>
                <label class="custom-control-label"
                       for="aceptar_terminos">@lang('informacion.terminos')</label>
                <a data-sidebar-close="sidebar"
                   data-toggle="modal"
                   data-target="#collapsePoliticasReservacion"
                   class="text-danger">
                    (@lang('informacion.leer_politicas'))
                </a>
            </div>
            @if($errors->has('aceptar_terminos'))
                <small class="invalid-feedback">{{$errors->first('aceptar_terminos')}}</small>
            @endif
            <div class="text-center">
                <button class="btn btn-primary" id="pagar"
                        type="button"
                        onclick="enviarFormulario()"
                        disabled>@lang('informacion.confirmar_pagar')</button>
            </div>
        </div>
    </div>
</div>
