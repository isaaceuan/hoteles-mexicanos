<div class="modal fade" id="collapseIdiomas" tabindex="-1" role="dialog" aria-labelledby="collapseIdiomas"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-auto">@lang('header.idioma')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="container-fluid p-0 pb-3">
                        <ul class="list-group list-group-flush ">
                            @foreach($idiomas as $idioma)
                                <li>
                                    @if('app.disponibilidad' == Route::currentRouteName())
                                        <a class="list-group-item list-group-item-action border-bottom {{app()->getLocale()==$idioma->id ? 'active' : ''}}"
                                           href="{{ route(Route::currentRouteName(),[
                               'locale'=>$idioma->id,
                                'checkin'=>AppBusqueda::recuperarBusqueda()->getLlegada(),
                               'checkout'=>AppBusqueda::recuperarBusqueda()->getSalida(),
                               'nights'=>AppBusqueda::recuperarBusqueda()->getNoches(),
                               'adults'=>AppBusqueda::recuperarBusqueda()->getAdultos(),
                               'children1'=>AppBusqueda::recuperarBusqueda()->getNinos1(),
                               'children2'=>AppBusqueda::recuperarBusqueda()->getNinos2(),
                               'children3'=>AppBusqueda::recuperarBusqueda()->getNinos3(),
                               'promocode'=>AppBusqueda::recuperarBusqueda()->getPromoCode()
                               ],false)}}">
                                            <img width="25" class="mr-2" src="{{$idioma->bandera}}">{{$idioma->nombre}}
                                        </a>
                                    @else
                                        <a class="list-group-item list-group-item-action border-top {{app()->getLocale()==$idioma->id ? 'active' : ''}}"
                                           href="{{ route(Route::currentRouteName(),[
                               'locale'=>$idioma->id
                               ],false)}}">
                                            <img width="25" class="mr-2" src="{{$idioma->bandera}}">{{$idioma->nombre}}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
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
