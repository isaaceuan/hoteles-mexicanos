<div class="floating-details sticky-top container-fluid bg-acento border-bottom shadow-sm text-white">
    <div class="row px-2 pb-2 py-2 font-12">
        <div class="col-7 pl-0 pr-2" data-toggle="collapse" href="#collapseCalendar" role="button" aria-expanded="false"
             aria-controls="collapseCalendar">
            <div class="row" id="checkin-detail">
                <div class="col-4"><b>@lang('calendar.llegada'):</b></div>
                <div class="col-8 text-right">
                    <span class="dia_corto"></span>
                    <span class="fecha"></span>
                    <span class="mes_corto"></span>
                </div>
            </div>
            <div class="row" id="checkout-detail">
                <div class="col-4"><b>@lang('calendar.salida'):</b></div>
                <div class="col-8 text-right">
                    <span class="dia_corto"></span>
                    <span class="fecha"></span>
                    <span class="mes_corto"></span>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-4 p-0"><b>@lang('calendar.noche')<span class="{{ (AppBusqueda::recuperarBusqueda()->getNoches()>1) ? 'd-inline-block' : 'd-none'  }}">s</span>:</b>
                    {{AppBusqueda::recuperarBusqueda()->getNoches()}}
                </div>
                <div class="col-4 p-0 text-center"><b>@lang('calendar.adulto')<span class="{{ (AppBusqueda::recuperarBusqueda()->getAdultos()>1) ? 'd-inline-block' : 'd-none'  }}">s</span>:</b>
                    {{AppBusqueda::recuperarBusqueda()->getAdultos()}}
                </div>
                @php
                    $totalNino1= AppBusqueda::recuperarBusqueda()->getNinos1();
                    $totalNino2= AppBusqueda::recuperarBusqueda()->getNinos2();
                    $totalNino3= AppBusqueda::recuperarBusqueda()->getNinos3();
                    $totalNinos= $totalNino1 + $totalNino2 + $totalNino3;
                @endphp
                <div class="p-0 text-center {{ ($totalNinos>0) ? 'col' : 'd-none'  }}">
                    <b>@lang('calendar.nino')<span class="{{ ($totalNinos>1) ? 'd-inline-block' : 'd-none'  }}">s</span>:</b>
                    {{$totalNinos}}
                </div>
            </div>
        </div>
        <div class="col-5 d-flex align-items-center border-left pl-2 pr-0">
            <a data-toggle="modal"
               data-target="#modalCarritoModificar"
               aria-expanded="false"
               class="w-100 text-center font-weight-bold text-white wrap-">
                @if(isset($total))
                    <carrito-total-component
                        :total_carrito="{{$total}}"
                        :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                    </carrito-total-component>
                @else
                    <carrito-total-component
                        :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                    </carrito-total-component>
                @endif
            </a>
        </div>
    </div>
</div>

