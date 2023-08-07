<template>
    <div class="modal fade" id="modalDetalleReserva" tabindex="-1" role="dialog"
         aria-labelledby="modalDetalleReservaLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold" id="modalDetalleReservaLabel" v-if="habitacion">
                        {{habitacion.nombre}}
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 d-flex menuDetalle">
                    <div class="col-md-1 pl-md-0">
                        <div class="nav flex-column nav-pills nav-tabs-vertical" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link text-center py-3" id="v-pills-home-tab" data-toggle="pill"
                               href="#v-pills-home"
                               role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fa fa-dollar-sign fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.desglose')}}</p>
                            </a>
                            <a class="nav-link text-center py-3 border-bottom" id="v-pills-messages-tab"
                               data-toggle="pill"
                               href="#v-pills-messages"
                               role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                <i class="fa fa-bed fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.habitacion')}}</p>
                            </a>
                            <a class="nav-link text-center" id="lineLeft">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-11 pl-4">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <modal-detalle-reserva-desglose-tab-component
                                    v-if="tarifa && busqueda"
                                    :tarifa="tarifa"
                                    :busqueda="busqueda"
                                    :color="color"
                                    :moneda_seleccionada="moneda_seleccionada"
                                >
                                </modal-detalle-reserva-desglose-tab-component>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                 aria-labelledby="v-pills-messages-tab">
                                <modal-detalle-reserva-habitacion-tab-component
                                    v-if="habitacion"
                                    :habitacion="habitacion">
                                </modal-detalle-reserva-habitacion-tab-component>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="busqueda">
                    <div class="col-md-2">
                        <div class="btn-details text-center font-16 text-capitalize">
                            {{busqueda.llegada | fechaDia}}<br>
                            <b>{{$t('calendar.llegada')}}</b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left">
                        <div class="btn-details text-center font-16 text-capitalize">
                            {{busqueda.salida | fechaDia}}<br>
                            <b>{{$t('calendar.salida')}}</b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left">
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-bed color-acento"></i>
                            {{busqueda.noches}}<br>
                            <b>{{$t('disponibilidad.noche')}}<span v-if="busqueda.noches>1">s</span>
                            </b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left">
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-male color-acento"></i>
                            {{busqueda.adultos}}<br>
                            <b>{{$t('disponibilidad.adulto')}}<span v-if="busqueda.adultos>1">s</span>
                            </b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left" v-if="busqueda.ninos">
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-child color-acento"></i>
                            {{busqueda.ninos}}<br>
                            <b>{{$t('disponibilidad.ninos')}}<span v-if="busqueda.ninos>1">s</span>
                            </b>
                        </div>
                    </div>
                    <div class="col text-md-right">
                        <button type="button" class="btn btn-secondary bg-acento" data-dismiss="modal">
                            {{$t('disponibilidad.cerrar')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            habitacion: Object,
            tarifa: Object,
            busqueda: Object,
            color: String,
            moneda_seleccionada: Object
        },
        methods: {},
        mounted() {
            $('.nav-tabs-vertical a:first').addClass('active');
            $('#v-pills-tabContent .tab-pane:first').addClass('show active');
        },
        watch: {
            tarifa: function (val, oldVal) {
                $('.nav-link').removeClass('active');
                $('#v-pills-tabContent .tab-pane').removeClass('active');
                $('.nav-tabs-vertical a:first').addClass('active');
                $('#v-pills-tabContent .tab-pane:first').addClass('show active');

            },
            moneda_seleccionada: function (val) {
                this.moneda_seleccionada = val;
            }
        }
    }
</script>
<style scoped>
</style>
