{{--<div class=" modal animate__animated animate__fadeInUp" id="collapseMonedas" tabindex="-1" role="dialog"--}}
<div class=" modal fade" id="collapseMonedas" tabindex="-1" role="dialog"
     aria-labelledby="collapseMonedas"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-auto">@lang('header.moneda')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="container-fluid p-0 pb-3">
                        <monedas-component :monedas="{{json_encode($monedas,true)}}"
                                           :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                        </monedas-component>
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


{{--<nav class="fullbar fullbar bg-white collapse" id="collapseMonedas">
    <nav class="navbar navbar-expand-lg bg-light p-2 fixed-top">
        <div class=" p-0 d-flex align-items-center">
            <img class="circle mr-2" width="40" height="40" src="{{@$marca->logo_original_crop}}">
            <h6 class="m-0 mr-5">@lang('header.moneda')</h6>
        </div>
        <a class="btn position-absolute" style="right: 0.5em; top:0.5em;" data-toggle="collapse" href="#collapseMonedas" role="button" aria-expanded="true" aria-controls="collapseMonedas">
            <i class="fas fa-times"></i>
        </a>
    </nav>
    <div class="container-fluid mt-5 p-0 pt-2 mb-4 pb-3">
        <monedas-component :monedas="{{json_encode($monedas,true)}}"
                           :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
        </monedas-component>
    </div>
</nav>--}}
