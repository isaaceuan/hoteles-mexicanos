<div class="modal fade" id="collapseUbicacion" tabindex="-1" role="dialog" aria-labelledby="collapseUbicacion"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-auto">
                    @lang('footer.direccion_btn')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-left font-18"><i class="fa fa-map-marker-alt font-16 color-acento"></i> @lang('footer.direccion')</h5>
                        <p class="text-justify">
                            {{$propiedad->direccion}}, {{$propiedad->cp}},
                            {{$propiedad->ciudad}},
                            {{$propiedad->estado}}, {{$propiedad->pais}} </p>

                        <div id="mapAddress" class="w-100" style="min-height: 360px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-acento"
                        data-dismiss="modal">@lang('disponibilidad.cerrar')</button>
            </div>
        </div>
    </div>
</div>

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
                '            <td class="border-bottom pb-2"><b>' + tit1 + '</b></td>\n' +
                '        </tr>\n' +
                '        <tr valign="top">\n' +
                '            <td class="pt-2"><i class="fa fa-phone text-acento mr-2"></i>' + propiedad['telefono_1'] + '</td>\n' +
                '        </tr>\n' +
                '        <tr valign="top">\n' +
                '            <td><i class="fa fa-envelope text-acento mr-2"></i>' + propiedad['correo'] + '</td>\n' +
                '        </tr>\n' +
                '    </tbody>\n' +
                '</table>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            var image = ' /imagenes/pointer.png';
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
