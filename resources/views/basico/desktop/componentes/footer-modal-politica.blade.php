<div class="modal fade" id="modalPolitica" tabindex="-1" role="dialog" aria-labelledby="modalPolitica"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-auto" id="modalPolitica">@lang('footer.politicas')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!!$propiedad->politica_general!!}
            </div>
        </div>
    </div>
</div>
