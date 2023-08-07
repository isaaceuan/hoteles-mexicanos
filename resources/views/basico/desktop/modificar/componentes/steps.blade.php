<ul id="steps" class="shadow-sm">
    <li class="{{ ('modificar.disponibilidad' == Route::currentRouteName()) ? 'complete' : ''  }}"><em>1</em>
        <span>
            @if('modificar.complementos' == Route::currentRouteName() || 'modificar.informacion' == Route::currentRouteName())
                <a href="{{route('modificar.disponibilidad',[
                               'locale'=>app()->getLocale(),
                               ],false)}}">
                    @lang('steps.OPT1')
                </a>
            @else
                @lang('steps.OPT1')
            @endif
        </span>
        <div></div>
    </li>
    <li class="{{ ('modificar.complementos' == Route::currentRouteName()) ? 'complete' : '' }}"><em>2</em>
        <span>
             @if('modificar.informacion' == Route::currentRouteName())
                <a href="{{route('modificar.complementos',[
                               'locale'=>app()->getLocale()
                               ],false)}}">
                     @lang('steps.OPT2')
                </a>
            @else
                @lang('steps.OPT2')
            @endif
        </span>
        <div></div>
    </li>
    <li class="{{ ('modificar.informacion' == Route::currentRouteName()) ? 'complete' : '' }}">
        <em>3</em>
        <span> @lang('steps.OPT3')</span>
        <div></div>
    </li>
    <li class="@if('modificar.reservacion-modificada' == Route::currentRouteName())  {{'complete'}} @endif">
        <em>4</em>
        <span> @lang('steps.OPT4')</span>
        <div></div>
    </li>
</ul>
