<div class="modal fade" id="collapsePoliticasPrivacidad" tabindex="-1" role="dialog" aria-labelledby="collapsePoliticasPrivacidad"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-auto">@lang('footer.privacidad')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        {!!$propiedad->aviso_privacidad!!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-acento"
                        data-dismiss="modal">@lang('disponibilidad.cerrar')</button>
            </div>
        </div>
    </div>
</div>
