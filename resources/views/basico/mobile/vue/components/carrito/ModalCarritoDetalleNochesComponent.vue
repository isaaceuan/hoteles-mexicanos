<template>
    <div>
        <div class="modal fade" id="modalCarritoDetalleNoches" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title ml-auto" v-if="detalle">
                            {{detalle.tipo_habitacion.nombre}}
                        </h5>
                        <button type="button" class="close" v-on:click="cerrar()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0 mt-3">
                        <ul class="nav nav-tabs text-center menuDetalle nav-fill">
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="tab" id="v-pills-desglose-tab" href="#v-pills-desglose">
                                    <i class="fa fa-dollar-sign fa-2x mb-2"></i>
                                    <p class="mb-0">{{$t('carrito.desglose')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" id="v-pills-tarifas-tab"  href="#v-pills-tarifas">
                                    <i class="fa fa-tag fa-2x mb-2"></i>
                                    <p class="mb-0">{{$t('carrito.tarifas')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" id="v-pills-habitacion-tab"  href="#v-pills-habitacion">
                                    <i class="fa fa-bed fa-2x mb-2"></i>
                                    <p class="mb-0">{{$t('carrito.habitacion')}}</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content px-md-0" id="v-pills-tabContentCarrito"  v-if="detalle">
                            <div class="tab-pane fade show active" id="v-pills-desglose" role="tabpanel"
                                 aria-labelledby="v-pills-desglose-tab">
                                <div class="mt-3" v-if="loading">
                                    <div class="justify-content-center d-flex mt-5">
                                        <spring-spinner
                                            :animation-duration="3000"
                                            :size="60"
                                            :color="color_cargador"
                                        />
                                    </div>
                                </div>
                                <div class="mt-3 col" v-else>
                                    <h5 class="font-weight-bold">
                                        {{noches}}
                                        {{$t('disponibilidad.noche')}}<span
                                        v-if="noches>1">s</span>
                                    </h5>
                                    <div v-for="detalle in detalle.resumen.noches"
                                         class="row border-bottom pb-1">
                                        <div class="date col-4 p-0 text-center text-capitalize">{{detalle.fecha
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
                                        <div class="price col-4 pl-0 text-right">
                                            {{ detalle.total_con_des_sin_imp |
                                            convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                            monedaSeleccionada.id, ',', 2,
                                            '.', 'front', true
                                            ) }}
                                        </div>
                                    </div>
                                    <div class="row font-weight-bolder pt-3">
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
                                    <div class="row">
                                        <div class="col-6 font-weight-bolder cursor-pointer openImpDetailCar"
                                             v-on:click="toggleImpuestos($event)">
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
                                    <div class="row border-top mt-3 pt-3 text-light">
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
                                    <div class="row font-weight-bolder bg-light py-3 mt-3 border"
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
                            <div class="tab-pane fade" id="v-pills-tarifas" role="tabpanel"
                                 aria-labelledby="v-pills-tarifas-tab">
                                <div class="mt-3 col">
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
                                            v-if="detalle.regla_modificacion.dias_acticipacion > 0
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
                            </div>
                            <div class="tab-pane fade" id="v-pills-habitacion" role="tabpanel"
                                 aria-labelledby="v-pills-habitacion-tab">
                                <modal-detalle-reserva-habitacion-tab-component
                                    v-if="detalle"
                                    :habitacion="detalle.tipo_habitacion">
                                </modal-detalle-reserva-habitacion-tab-component>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between"  v-if="detalle">
                        <div class="">
                            <div class="btn-details text-center font-12">
                                {{fecha_entrada}}<br>
                                <b>{{$t('carrito.llegada')}}</b>
                            </div>
                        </div>
                        <div class="pl-2 border-left">
                            <div class="btn-details text-center font-12">
                                {{fecha_salida}}<br>
                                <b>{{$t('carrito.salida')}}</b>
                            </div>
                        </div>
                        <div class="pl-2 border-left">
                            <div class="btn-details text-center font-12">
                                <i class="fa fa-bed color-acento"></i>
                                <span class="numb">
                            {{noches}}<br>{{$t('carrito.noche')}}<span v-if="noches>1">s</span>
                        </span>
                            </div>
                        </div>
                        <div class="">
                            <button type="button" class="btn btn-secondary bg-acento" v-on:click="cerrar()">
                                {{$t('carrito.cerrar')}}
                            </button>
                        </div>
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
            $('.nav-tabs-vertical a:first').addClass('active');
            $('#v-pills-tabContentCarrito .tab-pane:first').addClass('show active');
        },
        methods: {
            cerrar() {
                $('#modalCarritoDetalleNoches').modal('hide');
            },
            toggleImpuestos() {
                $('.openImpDetailCar span').toggleClass('fa-plus-square fa-minus-square');
                $('#collapseImpuestosNoches').slideToggle();
            }
        },
        computed: {
        },
        watch: {
            detalle: function (val, oldVal) {
                $('#collapseImpuestosNoches').hide();
                $('.openImpDetailCar span').removeClass('fa-minus-square').addClass('fa-plus-square ');
                $('.nav-link').removeClass('active');
                $('#v-pills-tabContentCarrito .tab-pane').removeClass('active');
                $('#v-pills-desglose-tab').addClass('active');
                $('#v-pills-tabContentCarrito .tab-pane:first').addClass('show active');
                $('.nav-tabs-vertical a:first').addClass('active');
            },
            monedaSeleccionada: function (val) {
                this.monedaSeleccionada = val;
            }
        }
    }
</script>
<style scoped>
</style>
