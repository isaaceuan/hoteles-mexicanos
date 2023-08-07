<div class="row pb-4 pt-3">
    <div class="col-12">
        <div class="rate-policies text-center">
            <b id="payment_amount">
                @lang('informacion.reserva_modificada')
            </b>
        </div>
        <div class="bg-acento text-light row py-2 my-4">
            <div class="col-6">
                Total
            </div>
            <div class="col-6 text-right">
                <carrito-total-component
                    :total_carrito="{{$total}}"
                    :mostrar_icono="0"
                    :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                </carrito-total-component>
            </div>
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
                        disabled>@lang('informacion.guardar_reserva')</button>
            </div>
        </div>
    </div>
</div>
