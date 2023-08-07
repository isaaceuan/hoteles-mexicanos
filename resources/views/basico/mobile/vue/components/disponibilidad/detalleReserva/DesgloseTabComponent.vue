<template>
    <div class="mt-3">
        <div class="col-md-5" v-if="loading">
            <div class="justify-content-center d-flex mt-5 mb-5">
                <spring-spinner
                    :animation-duration="3000"
                    :size="60"
                    :color="color"
                />
            </div>
        </div>
        <div class="col-md-5" v-else>
            <h5 class="font-weight-bold">
                {{busqueda.noches}} {{$t('disponibilidad.noche')}}<span
                v-if="busqueda.noches>1">s</span>
            </h5>
            <div v-for="detalle in tarifa.resumen.noches" class="row border-bottom pb-1">
                <div class="date col-4 p-0 text-center text-capitalize">{{detalle.fecha | fechaDia}}</div>
                <div class="offset col-4 text-right">
                    <template v-if="detalle.con_descuentos">
                        {{ detalle.total_sin_des_sin_imp |
                        convertirMoneda(moneda_seleccionada.tipo_cambiario) | currency(
                        moneda_seleccionada.id, ',', 2,
                        '.', 'front', true
                        ) }}
                    </template>
                </div>
                <div class="price col-4 pl-0 text-right">
                    {{ detalle.total_con_des_sin_imp |
                    convertirMoneda(moneda_seleccionada.tipo_cambiario) | currency(
                    moneda_seleccionada.id, ',', 2,
                    '.', 'front', true
                    ) }}
                </div>
            </div>
            <div class="row font-weight-bolder pt-3">
                <div class="col-6">SubTotal:</div>
                <div class="col text-right">
                    {{ tarifa.resumen.total_con_des_con_com_sin_imp
                    | convertirMoneda(moneda_seleccionada.tipo_cambiario)
                    | currency(
                    moneda_seleccionada.id, ',', 2,
                    '.', 'front', true
                    ) }}
                </div>
            </div>
            <div class="row">
                <div class="col-6 pr-0 font-weight-bolder cursor-pointer openToggleImp"
                     v-on:click="toggleImpuestos()">
                    {{$t('disponibilidad.impuestos_cargos')}}:
                    <span class="fa fa-plus-square ml-2 color-acento"></span>
                </div>
                <div class="col text-right font-weight-bolder">
                    {{ tarifa.resumen.total_imp_pro
                    | convertirMoneda(moneda_seleccionada.tipo_cambiario)
                    | currency(
                    moneda_seleccionada.id, ',', 2,
                    '.', 'front', true
                    ) }}
                </div>
                <div class="col-12" style="display: none;" id="collapseImpuestos">
                    <div class="row" v-if="tarifa.resumen.impuestos_propinas.length>0">
                        <template v-for="impuesto in tarifa.resumen.impuestos_propinas">
                            <div class="col-6"><p class="mb-0">{{impuesto.nombre}}</p></div>
                            <div class="col-6 text-right">
                                {{ impuesto.importe
                                | convertirMoneda(moneda_seleccionada.tipo_cambiario)
                                | currency(
                                moneda_seleccionada.id, ',', 2,
                                '.', 'front', true
                                ) }}
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="row border-top mt-3 pt-3 text-light">
                <div class="col-4 font-weight-bolder bg-acento py-3"><h5>TOTAL</h5></div>
                <div class="col text-right bg-acento py-3">
                    <h5 class="font-weight-bolder">
                        {{ tarifa.resumen.total
                        | convertirMoneda(moneda_seleccionada.tipo_cambiario)
                        | currency(
                        moneda_seleccionada.id, ',', 2,
                        '.', 'front', true
                        ) }}
                    </h5>
                    <p class="mb-0 font-weight-bolder font-12"> Total {{$t('disponibilidad.por')}}
                        {{busqueda.noches}}
                        {{$t('disponibilidad.noche')}}<span class="text-light font-12"
                                                            v-if="busqueda.noches>1">s</span>
                    </p>
                    <p class="mb-0 font-weight-bolder font-12"> {{busqueda.adultos}}
                        {{$t('disponibilidad.adulto')}}<span class="text-light font-12"
                                                             v-if="busqueda.adultos>1">s</span>
                        <span class="mb-0 font-weight-bolder font-12 text-light"
                              v-if="busqueda.ninos>0">
                            , {{busqueda.ninos}}
                            {{$t('disponibilidad.ninos')}}<span class="text-light font-12"
                                                                v-if="busqueda.ninos>1">s</span>
                        </span>
                    </p>
                    <p class="mb-0 font-12">{{$t('disponibilidad.impuestos_cargos_incluidos')}}</p>
                </div>
            </div>
            <div class="row  font-weight-bolder bg-light py-3 mt-3 border"
                 v-if="tarifa.resumen.con_descuentos">
                <div class="col-6">
                    <h6 class="mb-0"><i class="fa fa-tags color-acento mr-2"></i>{{$t('disponibilidad.ahorro')}}
                    </h6>
                </div>
                <div class="col text-right discount">
                    <h6 class="mb-0">
                        {{ tarifa.resumen.total_des
                        | convertirMoneda(moneda_seleccionada.tipo_cambiario)
                        | currency(
                        moneda_seleccionada.id, ',', 2,
                        '.', 'front', true
                        ) }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {SpringSpinner} from 'epic-spinners'

    export default {
        props: {
            color: String,
            tarifa: Object,
            busqueda: Object,
            moneda_seleccionada: Object
        },
        data() {
            return {
                loading: true
            };
        },
        components: {
            SpringSpinner
        },
        mounted() {
            setTimeout(() => this.loading = false, 1000);
        },
        watch: {
            //El watch verifica si hay algun cambio del atributo y hace un callback
            moneda_seleccionada: function (val) {
                this.moneda_seleccionada = val;
            },
            tarifa: function (val) {
                this.loading = true
                this.tarifa = val;
                setTimeout(() => this.loading = false, 1000);
            }
        },
        methods: {
            toggleImpuestos() {
                $('.openToggleImp >span').toggleClass('fa-plus-square fa-minus-square');
                $('#collapseImpuestos').slideToggle();
            }
        }
    }
</script>
