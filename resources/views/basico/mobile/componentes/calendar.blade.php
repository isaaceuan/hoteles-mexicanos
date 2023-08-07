<div class="container-fluid bg-white pb-3">
    <form id="frmCheck" action="{{ route('app.disponibilidad',app()->getLocale(), false)}}" method="get">
        <div id="calendar"></div>
        <div class="row">
            <div class="col-12 col-sm-6 border-bottom py-3">
                <div id="checkin-calendar" data-input="checkin" data-display="str_checkin" class="card bg-light">
                    <div class="card-body px-2 py-3 ">
                        <div class="d-flex">
                            <div class="w-50">
                                <h2 class="fecha font-weight-bold text-center"></h2>
                                <p class="text-center font-14 m-0 font-weight-bold">@lang('calendar.llegada')</p>
                            </div>
                            <div class="w-75 border-left ml-2 pl-3 d-flex align-items-center">
                                <div>
                                    <span class="dia d-block font-weight-bold font-16"></span>
                                    <span class="mes d-block font-13"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="checkin" name="checkin" type="hidden"
                       value="{{AppBusqueda::recuperarBusqueda()->getLlegada()}}">
                <input type="hidden" value="{{AppBusqueda::recuperarBusqueda()->getLlegada()}}" class="str_checkin">
            </div>
            <div class="col-12 col-sm-6 border-bottom py-3">
                <div id="checkout-calendar" data-input="checkout" data-display="str_checkout" class="card bg-light">
                    <div class="card-body px-2 py-3 ">
                        <div class="d-flex">
                            <div class="w-50">
                                <h2 class="fecha font-weight-bold text-center"></h2>
                                <p class="text-center font-14 m-0 font-weight-bold">@lang('calendar.salida')</p>
                            </div>
                            <div class="w-75 border-left ml-2 pl-3 d-flex align-items-center">
                                <div>
                                    <span class="dia d-block font-weight-bold font-16"></span>
                                    <span class="mes d-block font-13"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="checkout" name="checkout" type="hidden"
                       value="{{AppBusqueda::recuperarBusqueda()->getSalida()}}">
                <input type="hidden" class="str_checkout" value="{{AppBusqueda::recuperarBusqueda()->getSalida()}}">
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="top-header alert bg-light rounded-0 border-bottom text-center">
                    <span id="nights"></span>
                    <input type="hidden" name="nights">
                    @lang('calendar.noches')
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-5">@lang('calendar.adultos')</div>
            <div class="col-7">
                <input class="input-spinner" type="number" name="adults" value="1" min="1" max="{{$propiedad->max_adultos}}" step="1"/>
            </div>
        </div>
        <div class="row mb-3 {{ ($propiedad->tiene_ninos_1) ? 'd-inline-flex' : 'd-none'  }}">
            <div class="col-5">@lang('calendar.nino') ({{$propiedad->ninos_min_1}}-{{$propiedad->ninos_max_1}})</div>
            <div class="col-7">
                <input class="input-spinner" type="number" name="children1" value="0" min="0" max="{{($propiedad->max_adultos)-1}}" step="1"/>
            </div>
        </div>
        <div class="row mb-3 {{ ($propiedad->tiene_ninos_2) ? 'd-inline-flex' : 'd-none'  }}">
            <div class="col-5">@lang('calendar.nino') ({{$propiedad->ninos_min_2}}-{{$propiedad->ninos_max_2}})</div>
            <div class="col-7">
                <input class="input-spinner" type="number" name="children2" value="0" min="0" max="{{($propiedad->max_adultos)-1}}" step="1"/>
            </div>
        </div>
        <div class="row mb-3 {{ ($propiedad->tiene_ninos_3) ? 'd-inline-flex' : 'd-none'  }}">
            <div class="col-5">@lang('calendar.nino') ({{$propiedad->ninos_min_3}}-{{$propiedad->ninos_max_3}})</div>
            <div class="col-7">
                <input class="input-spinner" type="number" name="children3" value="0" min="0" max="{{($propiedad->max_adultos)-1}}" step="1"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="codigopromocional">
                    <div data-toggle="collapse" href="#collapsePromocode" role="button" aria-expanded="false"
                         aria-controls="collapsePromocode">
                        <p class="font-weight-bold text-center">
                            <a href="javascript:void(0);"
                               class="text-decoration-none text-body border-bottom border-dark">
                                @lang('calendar.promocion')&nbsp;
                                <span class="fa fa-tag text-acento"></span>
                            </a>
                        </p>
                    </div>
                    <div id="collapsePromocode" class="collapse mb-3">
                        <input class="form-control input-lg" id="promocode" name="promocode"
                               value="{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}"
                               autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col-12">
                <div class="w-50 m-auto">
                    <button type="submit" class="btn btn-primary btn-block cargador">@lang('calendar.buscar')</button>
                </div>
            </div>
        </div>
    </form>
</div>

