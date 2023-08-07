<template>
    <div class="modal fade" id="modalCarritoDetalleNoches" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold" id="modalDetalleReservaLabel" v-if="detalle">
                        {{detalle.tipo_habitacion.nombre}}
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 d-flex menuDetalle">
                    <div class="col-md-1 pl-md-0">
                        <div class="nav flex-column nav-pills nav-tabs-vertical" id="v-pills-tab-carrito-noches"
                             role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link text-center py-3" id="v-pills-desglose-tab" data-toggle="pill"
                               href="#v-pills-desglose"
                               role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fa fa-dollar-sign fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.desglose')}}</p>
                            </a>
                            <a class="nav-link text-center py-3 border-bottom" id="v-pills-habitacion-tab"
                               data-toggle="pill"
                               href="#v-pills-habitacion"
                               role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                <i class="fa fa-bed fa-2x mb-2"></i>
                                <p class="mb-0">{{$t('disponibilidad.habitacion')}}</p>
                            </a>
                            <a class="nav-link text-center" id="lineLeft">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-11 pl-4">
                        <div class="tab-content" id="v-pills-tabContentCarrito">
                            <div class="tab-pane fade show active" id="v-pills-desglose" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div role="tabpanel" class="tab-pane active">
                                    <div class="row" v-if="detalle">
                                        <div class="col-md-7 border-right" style="min-height: 480px">
                                            <h5 class="font-weight-bold">
                                                {{detalle.tarifa.nombre}}
                                            </h5>
                                            <p v-if="detalle.tarifa.plan_alimento">
                                                <i class="fa fa-coffee mr-2"></i><strong>{{$t('carrito.plan_alimentos')}}:</strong>
                                                {{detalle.tarifa.plan_alimento.nombre}}
                                            </p>
                                            <div v-html="detalle.tarifa.descripcion"></div>
                                            <div class="my-2" v-if="detalle && detalle.regla_cancelacion">
                                                <i class="fa fa-check mr-2"></i><strong>{{$t('carrito.reglas_cancel')}}</strong>
                                                <template
                                                    v-if="detalle.regla_cancelacion.es_reembolsable && detalle.regla_cancelacion.restricciones.length>0">
                                                    <p class="mb-0 ml-3 pl-1"
                                                       v-for="cancelacion in detalle.regla_cancelacion.restricciones">
                                                        {{$t('disponibilidad.reembolso_del',{tasa: cancelacion.tasa})}}
                                                        <span
                                                            class="text-capitalize">{{cancelacion.fecha_limite | fechaDia}}</span>
                                                    </p>
                                                </template>
                                                <template v-else>
                                                    <p class="mb-0 ml-3 pl-1">
                                                        {{$t('disponibilidad.no_reembolsable')}}
                                                    </p>
                                                </template>
                                            </div>
                                            <div v-if="detalle.regla_modificacion" class="my-2">
                                                <i class="fa fa-pen mr-2"></i><strong>{{$t('carrito.reglas_modif')}}</strong>
                                                <template
                                                    v-if="detalle.regla_modificacion.dias_anticipacion > 0
                        || detalle.regla_modificacion.modo === 'libre'
                        || detalle.regla_modificacion.modo === 'limitado'">
                                                    <p class="mb-0 ml-3 pl-1">{{$t('disponibilidad.modificar_reserva')}}
                                                        <span class="text-capitalize">{{detalle.regla_modificacion.fecha_limite | fechaDia}}</span>
                                                    </p>
                                                </template>
                                                <template v-else>
                                                    <p class="mb-0 ml-3 pl-1">
                                                        {{$t('disponibilidad.no_modificar_reserva')}}</p>
                                                </template>
                                            </div>
                                            <template
                                                v-if="detalle.complementos && detalle.complementos.length > 0">
                                                <i class="fa fa-shopping-bag mr-2"></i><strong>{{$t('carrito.complementos_incluidos')}}</strong>
                                                <ul class="mt-2">
                                                    <li v-for="c in detalle.complementos">
                                                        {{c.nombre}}
                                                    </li>
                                                </ul>
                                            </template>
                                            <template
                                                v-if="detalle.promociones && detalle.promociones.length > 0">
                                                <i class="fa fa-tag mr-2"></i><strong>{{$t('disponibilidad.promociones')}}</strong>
                                                <ul class="mt-2">
                                                    <li v-for="p in detalle.promociones">
                                                        {{p.nombre}}
                                                    </li>
                                                </ul>
                                            </template>
                                        </div>
                                        <div class="col-md-5" v-if="loading">
                                            <div class="justify-content-center d-flex mt-5">
                                                <spring-spinner
                                                    :animation-duration="3000"
                                                    :size="60"
                                                    :color="color_cargador"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-5" v-else>
                                            <h5 class="font-weight-bold">
                                                {{$t('disponibilidad.desglose')}} {{noches}}
                                                {{$t('disponibilidad.noche')}}<span
                                                v-if="noches>1">s</span>
                                            </h5>
                                            <div v-for="detalle in detalle.resumen.noches"
                                                 class="row ml-0 border-bottom pb-1">
                                                <div class="date col-4 p-0 text-left text-capitalize">{{detalle.fecha
                                                    | fechaDia}}
                                                </div>
                                                <div class="offset col-4 text-right">
                                                    <template v-if="detalle.con_descuentos">
                                                        {{ (detalle.total_sin_des_sin_imp) |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </template>
                                                </div>
                                                <div class="price col-4 text-right">
                                                    {{ detalle.total_con_des_sin_imp |
                                                    convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                    monedaSeleccionada.id, ',', 2,
                                                    '.', 'front', true
                                                    ) }}
                                                </div>
                                            </div>
                                            <div class="row ml-0 font-weight-bolder pt-3">
                                                <div class="col-6">SubTotal:</div>
                                                <div class="col text-right">
                                                    {{ detalle.resumen.total_con_des_con_com_sin_imp
                                                    | convertirMoneda(monedaSeleccionada.tipo_cambiario)
                                                    | currency(
                                                    monedaSeleccionada.id, ',', 2,
                                                    '.', 'front', true
                                                    ) }}
                                                </div>
                                            </div>
                                            <div class="row ml-0">
                                                <div class="col-6 font-weight-bolder cursor-pointer openImpDetailCar"
                                                     v-on:click="toggleImpuestos()">
                                                    {{$t('disponibilidad.impuestos_cargos')}}:
                                                    <span class="fa fa-plus-square ml-2 color-acento"></span>
                                                </div>
                                                <div class="col text-right font-weight-bolder">
                                                    {{ detalle.resumen.total_imp_pro
                                                    | convertirMoneda(monedaSeleccionada.tipo_cambiario)
                                                    | currency(
                                                    monedaSeleccionada.id, ',', 2,
                                                    '.', 'front', true
                                                    ) }}
                                                </div>
                                                <div class="col-12" style="display: none;" id="collapseImpuestosNoches">
                                                    <div class="row" v-if="detalle.resumen.impuestos_propinas.length>0">
                                                        <template v-for="impuesto in detalle.resumen.impuestos_propinas">
                                                            <div class="col-6"><p class="mb-0">{{impuesto.nombre}}</p>
                                                            </div>
                                                            <div class="col-6 text-right">
                                                                {{ impuesto.importe
                                                                | convertirMoneda(monedaSeleccionada.tipo_cambiario)
                                                                | currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ml-0 border-top mt-3 pt-3 text-light">
                                                <div class="col-4 font-weight-bolder bg-acento py-3"><h5>TOTAL</h5>
                                                </div>
                                                <div class="col text-right bg-acento py-3">
                                                    <h5 class="font-weight-bolder">
                                                        {{ detalle.resumen.total
                                                        | convertirMoneda(monedaSeleccionada.tipo_cambiario)
                                                        | currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </h5>
                                                    <p class="mb-0 font-weight-bolder font-12"> Total
                                                        {{$t('disponibilidad.por')}}
                                                        {{detalle.busqueda.noches}}
                                                        {{$t('disponibilidad.noche')}}<span class="text-light font-12"
                                                                                            v-if="detalle.busqueda.noches>1">s</span>
                                                    </p>
                                                    <p class="mb-0 font-weight-bolder font-12">
                                                        {{detalle.busqueda.adultos}}
                                                        {{$t('disponibilidad.adulto')}}<span class="text-light font-12"
                                                                                             v-if="detalle.busqueda.adultos>1">s</span>
                                                        <span class="mb-0 font-weight-bolder text-light font-12"
                                                              v-if="detalle.busqueda.ninos">
                                                        , {{detalle.busqueda.ninos}}
                                                        {{$t('disponibilidad.ninos')}}<span class="text-light font-12"
                                                                                            v-if="detalle.busqueda.ninos>1">s</span>
                                                    </span>
                                                    </p>
                                                    <p class="mb-0 font-12">
                                                        {{$t('disponibilidad.impuestos_cargos_incluidos')}}</p>
                                                </div>
                                            </div>
                                            <div class="row ml-0 font-weight-bolder bg-light py-3 mt-3 border"
                                                 v-if="detalle.resumen.con_descuentos">
                                                <div class="col-6">
                                                    <h6 class="mb-0"><i class="fa fa-tags color-acento mr-2"></i>{{$t('disponibilidad.ahorro')}}
                                                    </h6>
                                                </div>
                                                <div class="col text-right discount">
                                                    <h6 class="mb-0">
                                                        {{ detalle.resumen.total_des
                                                        | convertirMoneda(monedaSeleccionada.tipo_cambiario)
                                                        | currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-habitacion" role="tabpanel"
                                 aria-labelledby="v-pills-messages-tab">
                                <modal-detalle-reserva-habitacion-tab-component
                                    v-if="detalle"
                                    :habitacion="detalle.tipo_habitacion">
                                </modal-detalle-reserva-habitacion-tab-component>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="detalle">
                    <div class="col-md-2">
                        <div class="btn-details text-center font-16 text-capitalize">
                            {{fecha_entrada | fechaDia}}<br>
                            <b>{{$t('calendar.llegada')}}</b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left">
                        <div class="btn-details text-center font-16 text-capitalize">
                            {{fecha_salida | fechaDia}}<br>
                            <b>{{$t('calendar.salida')}}</b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left">
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-bed color-acento"></i>
                            {{noches}}<br>
                            <b>{{$t('disponibilidad.noche')}}<span v-if="noches>1">s</span>
                            </b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left">
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-male color-acento"></i>
                            {{detalle.busqueda.adultos}}<br>
                            <b>{{$t('disponibilidad.adulto')}}<span v-if="detalle.busqueda.adultos>1">s</span>
                            </b>
                        </div>
                    </div>
                    <div class="col-md-2 border-left" v-if="detalle.busqueda.ninos>0">
                        <div class="btn-details text-center font-16 ">
                            <i class="fa fa-child color-acento"></i>
                            {{detalle.busqueda.ninos}}<br>
                            <b>{{$t('disponibilidad.ninos')}}<span v-if="detalle.busqueda.ninos>1">s</span>
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

    import {carritoEvent, cambiarMonedaEvent} from "../../app";
    import {SpringSpinner} from "epic-spinners";

    export default {
        props: {
            step: String,
            moneda_seleccionada: Object,
            fecha_entrada: String,
            fecha_salida: String,
            noches: Number,
            color_cargador: String,
        },
        components: {
            SpringSpinner
        },
        data() {
            return {
                detalle: null,
                tarifa: null,
                current_step: this.step,
                monedaSeleccionada: this.moneda_seleccionada,
                loading: true
            }
        },
        created() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
            carritoEvent.$on('carritoDetalleHabitacion', (detalle) => {
                this.detalle = detalle
                $('#modalCarritoDetalleNoches').modal('show');
                setTimeout(() => this.loading = false, 1000);
            });
        },
        mounted() {
            $('#v-pills-tab-carrito-noches #v-pills-desglose-tab').addClass('active');
            $('#v-pills-tabContentCarrito #v-pills-desglose').addClass('show active');
        },
        methods: {
            toggleImpuestos() {
                $('.openImpDetailCar span').toggleClass('fa-plus-square fa-minus-square');
                $('#collapseImpuestosNoches').slideToggle();
            }
        },
        watch: {
            detalle: function (val, oldVal) {
                this.loading = true;
                $('#collapseImpuestosNoches').hide();
                $('.openImpDetailCar span').removeClass('fa-minus-square').addClass('fa-plus-square ');
                $('#v-pills-tab-carrito-noches .nav-link').removeClass('active');
                $('#v-pills-tabContentCarrito .tab-pane').removeClass('active');
                $('#v-pills-desglose-tab').addClass('active');
                $('#v-pills-tabContentCarrito #v-pills-desglose').addClass('show active');
            },
            monedaSeleccionada: function (val) {
                this.monedaSeleccionada = val;
            }
        }
    }
</script>
<style scoped>
</style>
