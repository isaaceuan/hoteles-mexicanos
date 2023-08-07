<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{route('app.inicio',app()->getLocale(), false)}}">
            <img src="{{@$marca->logo_original_crop}}" style="max-height: 60px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{$propiedad->pagina_web}}">
                        <i class="fas fa-reply"></i>
                        @lang('header.regresar') <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        @lang('header.ayuda')
                    </a>
                    <div class="dropdown-menu dropdown-menu-right z-index1021 shadow" aria-labelledby="navbarDropdown">
                        <h6 class="dropdown-header">@lang('header.numero_persona')</h6>
                        <a class="dropdown-item {{$propiedad->telefono_1 ? '' : 'd-none'}}"
                           href="tel:{{$propiedad->telefono_1}}">
                            {{$propiedad->telefono_1}}
                        </a>
                        <a class="dropdown-item {{$propiedad->telefono_2 ? '' : 'd-none'}}"
                           href="tel:{{$propiedad->telefono_2}}">
                            {{$propiedad->telefono_2}}
                        </a>
                        <a class="dropdown-item {{$propiedad->telefono_3 ? '' : 'd-none'}}"
                           href="tel:{{$propiedad->telefono_3}}">
                            {{$propiedad->telefono_3}}
                        </a>
                        <h6 class="dropdown-header">E-mail</h6>
                        <a class="dropdown-item" href="mailto:{{$propiedad->correo}}">
                            {{$propiedad->correo}}</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('modificar.login',app()->getLocale(),false)}}">
                        @lang('header.editar_cancelar')
                    </a>
                </li>
                <monedas-component :monedas="{{json_encode($monedas,true)}}"
                                   :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                </monedas-component>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <span class="text-uppercase">{{app()->getLocale()}}</span> - @lang('header.idioma')
                    </a>
                    <div class="dropdown-menu dropdown-menu-right z-index1021 shadow" aria-labelledby="navbarDropdown">
                        @foreach($idiomas as $idioma)
                            @if('app.disponibilidad' == Route::currentRouteName())
                                <a class="dropdown-item cursor-pointer {{app()->getLocale()==$idioma->id ? 'active' : ''}}"
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
                                    @else
                                        <a class="dropdown-item cursor-pointer {{app()->getLocale()==$idioma->id ? 'active' : ''}}"
                                           href="{{ route(Route::currentRouteName(),[
                               'locale'=>$idioma->id
                               ],false)}}">
                                            @endif
                                            <img width="25" class="mr-2" src="{{$idioma->bandera}}">{{$idioma->nombre}}
                                        </a>
                                @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
