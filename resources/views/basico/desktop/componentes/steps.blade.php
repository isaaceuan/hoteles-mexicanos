<ul id="steps" class="shadow-sm">
    <li class="{{ ('app.disponibilidad' == Route::currentRouteName()) ? 'complete' : ''  }}"><em>1</em>
        <span>
            @if('app.complementos' == Route::currentRouteName() || 'app.informacion' == Route::currentRouteName() || 'app.resumen' == Route::currentRouteName())
                <a href="{{route('app.disponibilidad',[
                               'locale'=>app()->getLocale(),
                               'checkin'=>AppBusqueda::recuperarBusqueda()->getLlegada(),
                               'checkout'=>AppBusqueda::recuperarBusqueda()->getSalida(),
                               'nights'=>AppBusqueda::recuperarBusqueda()->getNoches(),
                               'adults'=>AppBusqueda::recuperarBusqueda()->getAdultos(),
                               'children1'=>AppBusqueda::recuperarBusqueda()->getNinos1(),
                               'children2'=>AppBusqueda::recuperarBusqueda()->getNinos2(),
                               'children3'=>AppBusqueda::recuperarBusqueda()->getNinos3(),
                               'promocode'=>AppBusqueda::recuperarBusqueda()->getPromoCode()
                               ], false)}}">
                    @lang('steps.OPT1')
                </a>
            @else
                @lang('steps.OPT1')
            @endif
        </span>
        <div></div>
    </li>
    <li class="{{ ('app.complementos' == Route::currentRouteName()) ? 'complete' : '' }}"><em>2</em>
        <span>
             @if('app.informacion' == Route::currentRouteName() || 'app.resumen' == Route::currentRouteName())
                <a href="{{route('app.complementos',[
                               'locale'=>app()->getLocale()
                               ], false)}}">
                     @lang('steps.OPT2')
                </a>
            @else
                @lang('steps.OPT2')
            @endif
        </span>
        <div></div>
    </li>
    <li class="{{ ('app.informacion' == Route::currentRouteName() || 'app.resumen' == Route::currentRouteName() ) ? 'complete' : '' }}">
        <em>3</em>
        <span> @lang('steps.OPT3')</span>
        <div></div>
    </li>
    <li class="@if('app.reservacion.confirmada' == Route::currentRouteName() || 'app.reservacion.cancelada' == Route::currentRouteName())  {{'complete'}} @endif">
        <em>4</em>
        <span> @lang('steps.OPT4')</span>
        <div></div>
    </li>
</ul>
