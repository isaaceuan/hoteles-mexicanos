<ul id="steps" class="shadow-sm mb-2 sticky-top-steps">
    <li class="{{ ('modificar.disponibilidad' == Route::currentRouteName()) ? 'complete' : ''  }}">
        @if('modificar.complementos' == Route::currentRouteName() || 'modificar.informacion' == Route::currentRouteName())
            <a href="{{route('modificar.disponibilidad',[
                               'locale'=>app()->getLocale(),
                               'checkin'=>AppBusqueda::recuperarBusqueda()->getLlegada(),
                               'checkout'=>AppBusqueda::recuperarBusqueda()->getSalida(),
                               'nights'=>AppBusqueda::recuperarBusqueda()->getNoches(),
                               'adults'=>AppBusqueda::recuperarBusqueda()->getAdultos(),
                               'children1'=>AppBusqueda::recuperarBusqueda()->getNinos1(),
                               'children2'=>AppBusqueda::recuperarBusqueda()->getNinos2(),
                               'children3'=>AppBusqueda::recuperarBusqueda()->getNinos3(),
                               'promocode'=>AppBusqueda::recuperarBusqueda()->getPromoCode()
                               ],false)}}">
                <em>1</em>
                <span class="fa fa-bed ml-3"></span>
                <div></div>
            </a>
        @else
            <em>1</em>
            <span class="fa fa-bed ml-3"></span>
            <div></div>
        @endif
    </li>
    <li class="{{ ('modificar.complementos' == Route::currentRouteName()) ? 'complete' : '' }}">
        @if('modificar.informacion' == Route::currentRouteName())
            <a href="{{route('modificar.complementos',[
                               'locale'=>app()->getLocale()
                               ],false)}}">
                <em>2</em>
                <span class="fa fa-coffee ml-3"></span>
                <div></div>
            </a>
        @else
            <em>2</em>
            <span class="fa fa-coffee ml-3"></span>
            <div></div>
        @endif
    </li>
    <li class="{{ ('modificar.informacion' == Route::currentRouteName()) ? 'complete' : '' }}">
        <em>3</em>
        <span class="fa fa-user ml-3"></span>
        <div></div>
    </li>
    <li class="@if('modificar.reservacion.confirmada' == Route::currentRouteName() || 'modificar.reservacion.cancelada' == Route::currentRouteName())  {{'complete'}} @endif">
        <em>4</em>
        <span class="fa fa-credit-card ml-3"></span>
        <div></div>
    </li>
</ul>
