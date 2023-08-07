<template>
    <div class="modal fade" id="modalDetalleReserva" tabindex="-1" role="dialog"
         aria-labelledby="modalDetalleReservaLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" v-if="busqueda">
                    <h6 class="modal-title ml-auto" id="modalDetalleReservaLabel">
                        <b>{{$t('calendar.llegada')}}</b> {{busqueda.llegada | fechaDia}} / <b>{{$t('calendar.salida')}}</b>
                        {{busqueda.salida | fechaDia}}
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 mt-3">
                    <ul class="nav nav-tabs text-center menuDetalle nav-fill">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#v-pills-home">
                                <i class="fa fa-dollar-sign fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.desglose')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#v-pills-profile">
                                <i class="fa fa-tag fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.tarifas')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#v-pills-messages">
                                <i class="fa fa-bed fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.habitacion')}}</p>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content px-md-0" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <modal-detalle-reserva-desglose-tab-component
                                v-if="tarifa && busqueda"
                                :color="color"
                                :busqueda="busqueda"
                                :tarifa="tarifa"
                                :moneda_seleccionada="moneda_seleccionada"
                            >
                            </modal-detalle-reserva-desglose-tab-component>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                             aria-labelledby="v-pills-profile-tab">
                            <modal-detalle-reserva-tarifa-tab-component
                                v-if="tarifa"
                                :tarifa="tarifa">
                            </modal-detalle-reserva-tarifa-tab-component>
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
                <div class="modal-footer justify-content-between" v-if="busqueda">
                    <div class="pl-3">
                        <div class="btn-details text-center font-16">
                            <i class="fa fa-male color-acento"></i>
                            <span class="numb">
                            {{busqueda.adultos}}<br>{{$t('disponibilidad.adulto')}}<span
                                v-if="busqueda.adultos>1">s</span>
                            </span>
                        </div>
                    </div>
                    <template v-if="busqueda.ninos">
                        <div class="border-left">
                            &nbsp;
                        </div>
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-child color-acento"></i>
                            <span class="numb">
                                {{busqueda.ninos}}<br>{{$t('disponibilidad.ninos')}}<span
                                v-if="busqueda.ninos>1">s</span>
                            </span>
                        </div>
                    </template>
                    <template>
                        <div class="border-left">
                            &nbsp;
                        </div>
                        <div class="btn-details text-center font-16">
                            <i class="fa fa-bed color-acento"></i>
                            <span class="numb">
                            {{busqueda.noches}}<br>{{$t('disponibilidad.noche')}}<span
                                v-if="busqueda.noches>1">s</span>
                        </span>
                        </div>
                    </template>
                    <div class=" text-md-right">
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
        methods: {
        },
        mounted() {
            $('.menuDetalle a:first').addClass('active');
            $('#v-pills-tabContent .tab-pane:first').addClass('show active');
        },
        watch: {
            tarifa: function (val, oldVal) {
                $('.nav-link').removeClass('active');
                $('#v-pills-tabContent .tab-pane').removeClass('active');
                $('.menuDetalle a:first').addClass('active');
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
