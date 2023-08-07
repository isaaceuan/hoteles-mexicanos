@if(count($marca->imagenes)>0)
    <div class="mb-2 contentBannerPrincipal">
        <div class=" jumbotron mb-0 banner-principal text-center text-white d-inline-flex align-items-center w-100 rounded-0 justify-content-center"
             style="min-height:250px;background-image: url({{$marca->imagenes[0]->url}});">
            <div class="animated zoomIn">
                <h1 class="font-weight-normal">{{$propiedad->nombre}}</h1>
                <hr class="mt-2 mb-3 w-25 line-border">
                <p class="lead mb-0 font-weight-normal">
                    {{$propiedad->ciudad}}, {{$propiedad->estado}}
                    , {{$propiedad->pais}}
                </p>
            </div>
        </div>
    </div>
    <br>
@endif


