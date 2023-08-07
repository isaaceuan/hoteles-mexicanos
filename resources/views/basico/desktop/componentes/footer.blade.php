<footer class="mt-3 bg-white">
    <div class="container py-3">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-unstyled text-small">
                    <li class="py-1 cursor-pointer">
                        <a data-toggle="modal"
                           data-target="#modalPrivacidad">@lang('footer.privacidad')</a>
                    </li>
                    <li class="py-1 cursor-pointer">
                        <a data-toggle="modal"
                           data-target="#modalPolitica">@lang('footer.politicas')</a>
                    </li>
                    {{--<li class="py-1">--}}
                    {{--<a href="/v2/hotel-avandaro-golf-spa-resort/es/modify/login">@lang('footer.CRU')</a>--}}
                    {{--</li>--}}
                    <li class="py-1 cursor-pointer">
                        <a href="{{$propiedad->pagina_web}}">@lang('header.regresar')</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 pl-md-0">
                <h5 class="font-18"><i class="fa fa-lock font-16 color-acento"></i> @lang('footer.seguro')</h5>
                <p class="text-justify">
                    @lang('footer.seguro_txt')
                </p>
                <div class="security-logos">
                    <span id="siteseal">
                        {{--<script async="" type="text/javascript"
                                src="https://seal.godaddy.com/getSeal?sealID=IqlLmetbH2v60kF9pTnBEaDcDROcmm0HUs2o1KBa4mxFmrOuFLLqkHmvSTrI"></script>--}}
                    </span>
                    <img src="/imagenes/PCI.png">
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="text-left font-18"><i
                            class="fa fa-map-marker-alt font-16 color-acento"></i> @lang('footer.direccion')</h5>
                <p class="text-justify">
                    {{$propiedad->direccion}}, {{$propiedad->cp}},
                    {{$propiedad->ciudad}},
                    {{$propiedad->estado}}, {{$propiedad->pais}} </p>
                <br>
                <a data-toggle="modal" data-target="#modalUbicacion"
                   class="btn btn-default btn-sm">@lang('footer.direccion_btn')</a>
            </div>
        </div>
    </div>
    <hr>
    <div class="container by">
        <p class="text-center font-14 m-0 pb-3">
            Booking Engine por
            <a href="https://www.easy-rez.com" target="_blank">
                <img src="https://reservations.easy-rez.com/images/favicon.png" width="16">
                Easy-Rez® </a>
        </p>
    </div>
</footer>
@include('basico.desktop.componentes.footer-modal-ubicacion')
@include('basico.desktop.componentes.footer-modal-privacidad')
@include('basico.desktop.componentes.footer-modal-politica')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}"></script>
<script>
    $(document).ready(function () {
        function initMap() {
            var tit1 = "@lang('header.ayuda')";
            var tit2 = "@lang('footer.direccion')";
            var propiedad = {!! json_encode($propiedad) !!};
            var myLatLng = {
                lat: propiedad['latitud'],
                lng: propiedad['longitud']
            };
            var map = new google.maps.Map(document.getElementById('mapAddress'), {
                center: myLatLng,
                zoom: 15
            });
            var contentString = '<table class="balloon" width="100%" border="0" cellpadding="3" cellspacing="0">\n' +
                '    <tbody>\n' +
                '        <tr valign="top">\n' +
                '            <td width="80"><b>' + tit1 + ':</b></td>\n' +
                '            <td>' + propiedad['telefono_1'] + '</td>\n' +
                '        </tr>\n' +
                '        <tr valign="top">\n' +
                '            <td width="80"></td>\n' +
                '            <td>' + propiedad['telefono_2'] + '</td>\n' +
                '        </tr>\n' +
                '        <tr>\n' +
                '            <td width="80"></td>\n' +
                '            <td>' + propiedad['telefono_3'] + '</td>\n' +
                '        </tr>\n' +
                '        <tr valign="top">\n' +
                '            <td width="80"><b>E-mail:</b></td>\n' +
                '            <td>' + propiedad['correo'] + '</td>\n' +
                '        </tr>\n' +
                '        <tr valign="top">\n' +
                '            <td width="80"><b>' + tit2 + ':</b></td>\n' +
                '            <td>' + propiedad['direccion'] + ', ' + propiedad['cp'] + ', ' + propiedad['ciudad'] + ', ' + propiedad['estado'] + ', ' + propiedad['pais'] + '</td>\n' +
                '        </tr>\n' +
                '    </tbody>\n' +
                '</table>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            var image = '/imagenes/pointer.png';
            var marker = new google.maps.Marker({
                map: map,
                position: myLatLng,
                icon: image
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
            infowindow.open(map, marker);
        }

        initMap();
    });
</script>
