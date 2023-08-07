<!-- Sidebar Overlay  -->
<div class="sidebar-overlay"></div>

<!-- Sidebar  -->
<nav id="sidebar" class="bg-white {{ ('app.inicio' == Route::currentRouteName()) ? 'pb-5' : ''  }}pb-5">
    <nav class="navbar navbar-expand-lg navbar-light shadow-none p-2">
        <div class="w-auto mr-5">
            <div class=" d-flex align-items-center">
                <img src="{{@$marca->logo_original_crop}}" width="40" height="40" class="circle mr-1">
                <div class="">{{$propiedad->nombre}}</div>
            </div>
        </div>
        <div id="dismiss" class="btn position-absolute " style="right: 0.5em;">
            <i class="fas fa-chevron-left fa-lg"></i>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light p-0 border-top" id="sidebarBoxes">
        <a class="btn rounded-0 col-4"
           data-sidebar-close="sidebar"
           data-toggle="modal"
           data-target="#collapseIdiomas"
           aria-expanded="false">
            <i class="fas fa-globe fa-lg text-acento"></i><br>
            <span>@lang('header.idioma')</span>
        </a>
        <a href="tel:{{$propiedad->telefono_1}}" class="btn rounded-0 border-left border-right col-4">
            <i class="fas fa-phone fa-lg text-acento"></i><br>
            <span>@lang('header.llamar')</span>
        </a>
        <a href="mailto:{{$propiedad->correo}}" class="btn rounded-0 col-4">
            <i class="fas fa-envelope fa-lg text-acento"></i><br>
            <span>E-mail</span>
        </a>
    </nav>

    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action border-top bg-light text-center d-inline-flex"
           data-sidebar-close="sidebar"
           data-toggle="modal"
           data-target="#collapseMonedas"
           aria-expanded="false">
            <div class="col-10">
                <moneda-seleccionada-component
                    :moneda_seleccionada="{{json_encode(AppMonedas::getMonedaActual(),true)}}">
                </moneda-seleccionada-component>
            </div>
            <div class="col-2">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>

        <a href="{{ url('/') }}" class="list-group-item list-group-item-action border-top d-inline-flex">
            <div class="col-10 pl-0">
                @lang('header.inicio')
            </div>
            <div class="col-2">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a class="list-group-item list-group-item-action border-top d-inline-flex"
           data-sidebar-close="sidebar"
           data-toggle="modal"
           data-target="#collapseUbicacion"
           aria-expanded="false">
            <div class="col-10 pl-0">
                @lang('footer.direccion_btn')
            </div>
            <div class="col-2">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a class="list-group-item list-group-item-action border-top d-inline-flex"
           data-sidebar-close="sidebar"
           data-toggle="modal"
           data-target="#collapsePoliticasPrivacidad"
           aria-expanded="false">
            <div class="col-10 pl-0">
                @lang('footer.privacidad')
            </div>
            <div class="col-2">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a class="list-group-item list-group-item-action border-top d-inline-flex"
           data-sidebar-close="sidebar"
           data-toggle="modal"
           data-target="#collapsePoliticasReservacion"
           aria-expanded="false">
            <div class="col-10 pl-0">
                @lang('footer.politicas')
            </div>
            <div class="col-2">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a href="{{route('modificar.login',app()->getLocale(),false)}}"
           class="list-group-item list-group-item-action border-top d-inline-flex">
            <div class="col-10 pl-0">
                @lang('header.editar_cancelar')
            </div>
            <div class="col-2">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
    </div>
    <div class="p-4">
        <div class="btn btn-light btn-block border">
            <i class="fas fa-home color-acento"></i> @lang('header.regresar')
        </div>
    </div>
</nav>

<!-- Navbar  Principal-->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-1 px-2">
    <div class="container-fluid">
        <a href="javascript:void(0);" id="sidebarCollapse" class="btn">
            <i class="fas fa-bars fa-lg color-acento"></i>
        </a>
        <div class="w-auto text-center m-auto">
            <a href="{{ url('/') }}" class="ui-link">
                <img src="{{@$marca->logo_original_crop}}" style="max-height: 48px;">
            </a>
        </div>
        <a href="tel:{{$propiedad->telefono_1}}" class="btn">
            <i class="fas fa-phone text-acento fa-lg"></i>
        </a>
        @if('app.inicio' != Route::currentRouteName() &&
            'app.reservacion-confirmada' != Route::currentRouteName() &&
            'app.reservacion-cancelada' != Route::currentRouteName() &&
            'modificar.login' != Route::currentRouteName() &&
            'modificar.menu' != Route::currentRouteName() &&
            'modificar.resumen.reserva' != Route::currentRouteName() &&
            'modificar.datos.personales' != Route::currentRouteName() &&
            'modificar.reserva.cancelar' != Route::currentRouteName() &&
            'modificar.reserva.cancelada' != Route::currentRouteName() &&
            'modificar.reserva.guardada' != Route::currentRouteName()
            )
            @if(AppModificarReserva::existeSesion())
                <a class="btn iconoHeaderCarrito"
                   data-toggle="modal"
                   data-target="#modalCarritoModificar"
                   aria-expanded="false">
                    <i class="fas fa-shopping-cart text-acento"></i>
                </a>
            @else
                <a class="btn iconoHeaderCarrito"
                   data-toggle="modal"
                   data-target="#modalCarrito"
                   aria-expanded="false">
                    <i class="fas fa-shopping-cart text-acento"></i>
                </a>
            @endif

        @endif

    </div>
</nav>


