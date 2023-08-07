<div class="modal fade" id="modalCarritoModificar" tabindex="-1" role="dialog" aria-labelledby="modalCarrito"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header py-1">
                <div class="justify-content-between d-flex align-items-center">
                    <h5 class="modal-title mr-5">
                        @lang('carrito.tit_resumen')
                    </h5>
                    <selector-monedas-component :monedas="{{json_encode(AppMonedas::getMonedas(),true)}}"
                                                :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                    </selector-monedas-component>
                </div>
                <button type="button" class="close pt-4" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                @if('modificar.disponibilidad' == Route::currentRouteName())
                    @php
                        $prev=route('modificar.menu',['locale'=>app()->getLocale()],false);
                        $next=route('modificar.complementos',['locale'=>app()->getLocale()],false);
                        $step='disponibilidad';
                    @endphp
                @elseif('modificar.complementos' == Route::currentRouteName())
                    @php
                        $prev = route('modificar.disponibilidad',[
                                   'locale'=>app()->getLocale(),
                                   'checkin'=>AppBusqueda::recuperarBusqueda()->getLlegada(),
                                   'checkout'=>AppBusqueda::recuperarBusqueda()->getSalida(),
                                   'nights'=>AppBusqueda::recuperarBusqueda()->getNoches(),
                                   'adults'=>AppBusqueda::recuperarBusqueda()->getAdultos(),
                                   'children1'=>AppBusqueda::recuperarBusqueda()->getNinos1(),
                                   'children2'=>AppBusqueda::recuperarBusqueda()->getNinos2(),
                                   'children3'=>AppBusqueda::recuperarBusqueda()->getNinos3(),
                                   'promocode'=>AppBusqueda::recuperarBusqueda()->getPromoCode()
                                   ],false);
                        $next=route('modificar.informacion',app()->getLocale(),false);
                          $step='complementos';
                    @endphp
                @elseif('modificar.informacion' == Route::currentRouteName())
                    @php
                        $prev = route('modificar.complementos',['locale'=>app()->getLocale()],false);
                        $next='';
                        $step='informacion';
                    @endphp
                @else
                    @php
                        $prev=null;
                        $next=null;
                        $step='disponibilidad';
                    @endphp
                @endif
                <modificar-carrito-reservas-component
                    :color_cargador="'{{@$marca->color_acento}}'"
                    :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}"
                    :propiedad="{{json_encode($propiedad,true)}}"
                    :fecha_entrada="'{{AppBusqueda::recuperarBusqueda()->getLlegada()}}'"
                    :fecha_salida="'{{AppBusqueda::recuperarBusqueda()->getSalida()}}'"
                    :noches="{{AppBusqueda::recuperarBusqueda()->getNoches()}}"
                    :codigo_promocion="'{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}'"
                    :next_url="'{{$next}}'"
                    :prev_url="'{{$prev}}'"
                    :step="'{{$step}}'">
                </modificar-carrito-reservas-component>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-acento"
                        data-dismiss="modal">@lang('disponibilidad.cerrar')</button>
            </div>
        </div>
    </div>
</div>
