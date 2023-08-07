<template>
    <div class="sticky-top">
        <div class="card rounded-0 border-0 shadow sidebar">
            <div class="card-header bg-light px-3 py-1">
                <div class="justify-content-between d-flex align-items-center">
                    <h6 class="mb-0"> {{$t('carrito.tit_resumen')}}:
                        <strong>{{reserva.folio}}</strong>
                    </h6>
                    <br>
                    <selector-monedas-component :monedas="monedas"
                                                :moneda_seleccionada="monedaSeleccionada">
                    </selector-monedas-component>
                </div>
            </div>
            <section v-if="errored">
                <p class="mt-4 p-3 text-center rounded-0 border-0">
                    {{$t('validation.error_500')}}
                </p>
            </section>
            <section v-else>
                <div class="card-body px-0 pt-2 pb-0">
                    <section class="px-2 pb-2">

                        <div class="row">
                            <div class="col-md-6"><b> {{$t('carrito.llegada')}}:</b></div>
                            <div class="col-md-6 text-right text-capitalize">
                                {{fecha_entrada | fechaDia}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b> {{$t('carrito.salida')}}:</b></div>
                            <div class="col-md-6 text-right text-capitalize">{{fecha_salida |
                                fechaDia}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b> {{$t('carrito.estancia')}}:</b></div>
                            <div class="col-md-6 text-right">
                                {{noches}}
                                {{$t('carrito.noche')}}<span v-if="noches>1">s</span>
                            </div>
                        </div>
                    </section>
                    <div v-if="loading" class="justify-content-center d-flex mt-3 mb-5">
                        <spring-spinner
                            :animation-duration="3000"
                            :size="60"
                            :color="color_cargador"
                        />
                    </div>
                    <template v-if="carrito && carrito.detalle.length>0 && !loading">
                        <section v-for="(item, idx) in carrito.detalle">
                            <div class="bg-light text-center font-16 font-weight-bold border-bottom border-top">
                                {{$t('disponibilidad.habitacion')}} {{idx+1}}
                            </div>
                            <div class="px-2 py-1 position-relative">
                                <div class="w-100 font-weight-semibold cursor-pointer">
                                    <button
                                        v-if="current_step === 'disponibilidad'"
                                        @click="eliminarTarifa(item.indice)"
                                        class="btnElminarElemento fa fa-trash cursor-pointer font-14 border border-dark p-1 m-0 px-2 bg-light text-dark "></button>
                                    <p class="m-0">
                                        <span class="border-bottom border-dark"
                                              v-on:click="verDetalleHabitacion(item)"
                                        >{{item.tipo_habitacion.nombre}}</span>
                                    </p>
                                    <div class="d-flex w-100">
                                        <div class="col-7 pl-0 line-height-1">
                                            <p class="m-0"><small class="w-100">{{item.tarifa.nombre}}</small></p>
                                            <small>
                                                {{item.busqueda.adultos}} {{$t('disponibilidad.adulto')}}<span
                                                v-if="item.busqueda.adultos>1">s</span><span v-if="item.busqueda.ninos>0">, {{item.busqueda.ninos}} {{$t('disponibilidad.ninos')}}<span
                                                v-if="item.busqueda.ninos>1">s</span></span>
                                            </small>
                                        </div>
                                        <div class="col p-0 d-flex justify-content-end align-items-end">
                                    <span class="text-danger font-12 float-right">
                                         {{ item.total_con_des_con_com_sin_imp | convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                        currency(
                                        monedaSeleccionada.id, ',', 2,
                                        '.', 'front', true
                                        ) }}
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <template v-if="item.complementos_adicionales.length>0">
                                    <div class="font-weight-semibold cursor-pointer mt-1 pt-1 border-top"
                                         v-for="complemento in item.complementos_adicionales">
                                            <button
                                                v-if="current_step === 'complementos'"
                                                @click="eliminarComplemento(complemento.complemento_id, item.indice)"
                                                class="fa fa-trash float-right cursor-pointer font-14 border border-dark p-1 m-0 px-2 bg-light text-dark"></button>
                                        <div class="d-flex col-12 p-0">
                                            <p class="m-0 col-7 p-0">
                                                <span class="border-bottom border-dark"
                                                      v-on:click="verDetalleComplemento(complemento)">{{complemento.nombre}}</span>
                                            </p>
                                            <div class="col p-0 d-flex justify-content-end align-items-end">
                                     <span class="text-danger font-12 float-right">
                                           {{ complemento.total_sin_imp | convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                        currency(
                                        monedaSeleccionada.id, ',', 2,
                                        '.', 'front', true
                                        ) }}
                                     </span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </section>
                        <section>
                            <div class="d-flex font-weight-bolder pt-3 border-top">
                                <div class="col-6 pl-2">SubTotal:</div>
                                <div class="col text-right pr-2">
                                    {{ carrito.total_con_des_con_com_sin_imp |
                                    convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                    currency(
                                    monedaSeleccionada.id, ',', 2,
                                    '.', 'front', true
                                    ) }}
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="col-7 px-2 font-weight-bolder cursor-pointer openImpCar"
                                     v-on:click="toggleImpuestos()">
                                    {{$t('disponibilidad.impuestos_cargos')}}:
                                    <span class="fa fa-plus-square ml-2 color-acento"></span>
                                </div>
                                <div class="col pr-2 pl-0 text-right font-weight-bolder">
                                    {{ carrito.total_imp_pro | convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                    currency(
                                    monedaSeleccionada.id, ',', 2,
                                    '.', 'front', true
                                    ) }}
                                </div>
                            </div>
                            <div class="col-12" style="display: none;" id="collapseImpuestosCarrito">
                                <div class="row" v-if="carrito.impuestos_propinas.length>0">
                                    <template v-for="impuesto in carrito.impuestos_propinas">
                                        <div class="col-6 pl-2"><p class="mb-0">{{impuesto.nombre}}</p></div>
                                        <div class="col-6 pr-2 text-right">
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
                        </section>
                        <section>
                            <div class="d-flex border-top mt-3 text-light">
                                <div class="col-4 font-weight-bolder bg-acento py-3"><h5>TOTAL</h5></div>
                                <div class="col text-right bg-acento py-3">
                                    <h5 class="font-weight-bolder">
                                        {{ carrito.total | convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                        currency(
                                        monedaSeleccionada.id, ',', 2,
                                        '.', 'front', true
                                        ) }}
                                    </h5>
                                </div>
                            </div>
                        </section>
                        <section class="px-2 mt-2" v-if="carrito.moneda!==monedaSeleccionada.id">
                            <div class="border rounded border rounded px-1 py-2">
                                <i class="fa fa-info-circle text-acento"></i>
                                <span class="font-13" v-html="$t('carrito.indicador',
                                    {
                                    moneda_hotel:'<b>'+carrito.moneda+'</b>',
                                    total:'<b>'+getTotalCarritoMoneda(carrito.total) +'</b>',
                                    moneda_seleccionada:monedaSeleccionada.id
                                    })">
                                </span>
                            </div>
                        </section>
                        <section class="py-3"
                                 v-if="carrito.total > 0">
                            <div class="col-md-12" v-if="current_step !== 'informacion'">
                                <button class="btn btn-primary btn-block" type="button" @click="next()">
                                    {{$t('carrito.continuar')}}
                                </button>
                            </div>
                        </section>
                    </template>
                    <template v-else-if="carrito && carrito.detalle.length===0 && !loading">
                        <div class="card-body px-0 pt-2">
                            <div class="text-center px-4">
                                <i class="far fa-shopping-cart circle-icon bg-light fa-4x p-3"></i>
                                <p class="text-uppercase font-12">
                                    {{$t('carrito.vacio_carrito_modificar')}}
                                </p>
                            </div>
                        </div>
                        <div class="card-footer bg-acento text-light">
                            <div class="d-flex">
                                <div class="col-4 font-weight-bolder">TOTAL</div>
                                <div class="col text-right bg-acento">
                                    0.00
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import {carritoEvent, cambiarMonedaEvent} from "../../../app";
    import {SpringSpinner} from "epic-spinners";

    export default {
        props: {
            reserva: Object,
            color_cargador: String,
            monedas: Object,
            moneda_seleccionada: Object,
            propiedad: Object,
            fecha_entrada: String,
            fecha_salida: String,
            noches: Number,
            codigo_promocion: String,
            prev_url: String,
            next_url: String,
            step: {
                type: String,
                default: 'disponibilidad'
            }
        },
        components: {
            SpringSpinner
        },
        data() {
            return {
                current_step: this.step,
                loading: true,
                errored: false,
                carrito: null,
                monedaSeleccionada: this.moneda_seleccionada
            }
        },
        created() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });

            carritoEvent.$on('agregarElementoCarrito', (reserva) => {
                this.getCarrito();
            });

            // Agregar complemento
            carritoEvent.$on('agregarComplementoCarrito', (datosComplemento) => {
                this.getCarrito();
            });

            // Remover complemento desde la lista de coplementos
            carritoEvent.$on('removerComplementoSelector', (datosComplemento) => {
                this.getCarrito();
            });
            // Remover complemento desde la lista de coplementos
            carritoEvent.$on('removerComplementoCarrito', (datosComplemento) => {
                this.getCarrito();
            });

        },
        mounted() {
            this.getCarrito();
        },
        methods: {
            getCarrito() {
                this.loading = true;
                this.errored = false;
                axios.post(window.url_carrito_resumen)
                    .then(response => {
                        this.carrito = response.data;

                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            },
            toggleImpuestos() {
                $('.openImpCar > span').toggleClass('fa-minus-square fa-plus-square');
                $('#collapseImpuestosCarrito').slideToggle();
            },
            getTotalCarritoMoneda(total) {
                return this.$options.filters.currency(total,
                    '$', ',', 2,
                    '.', 'front', true
                );
            },
            eliminarTarifa(indiceId) {
                this.loading = true;
                this.errored = false;
                axios.post(window.url_carrito_remover, {indice: indiceId})
                    .then(response => {
                        carritoEvent.$emit('removerElementoCarrito', response.data.elemento);
                        this.getCarrito();
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = true)
            },
            verDetalleHabitacion(detalles) {
                carritoEvent.$emit('carritoDetalleHabitacion', detalles);
            },
            eliminarComplemento(complementoId, indiceId) {
                this.loading = true;
                this.errored = false;
                let params = {indice: indiceId, complemento_id: complementoId};
                axios.post(window.url_carrito_complemento_remover, params)
                    .then(response => {
                        carritoEvent.$emit('removerComplementoCarrito', params);
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = true)
            },
            next() {
                window.location.href = this.next_url;
            },
            prev() {
                window.location.href = this.prev_url;
            },
            verDetalleComplemento(complemento) {
                carritoEvent.$emit('carritoDetalleComplemento', {
                    complemento: complemento,
                });
            }
        }
    }
</script>
<style scoped>
    .menuDetalle .nav-tabs-vertical {
        min-height: 500px !important;
    }
</style>
