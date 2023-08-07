@if('app.disponibilidad' == Route::currentRouteName())
    @foreach($propiedadMotor->scripts as $script)
        @if($script->id==='123compare')
            <script type="text/javascript" src="https://www.123compare.me/v2/js/CmprmInit-min.js"></script>
            <script>
                document.addEventListener('CmprmInitLoaded', function () {
                    CmprmInit.Init({{$script->pivot->configuracion[0]->valor}});
                }, false);
            </script>
        @endif
    @endforeach
@endif


