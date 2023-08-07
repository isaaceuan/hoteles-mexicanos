<div class="modal fade" id="modalSesion" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false"
     aria-labelledby="modalSesion"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-auto" id="modalSesion">@lang('carrito.atencion')</h5>
            </div>
            <div class="modal-body text-center" style="align-items: center">
                <p>
                    @lang('carrito.expirado')
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="window.location='{{ URL::route('app.inicio',app()->getLocale(),false) }}'">
                    @lang('carrito.aceptar')
                </button>
                </div>
        </div>
    </div>
</div>
