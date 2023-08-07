<template>
    <div v-if="datos">
        <template v-for="tarifa in datos">
            <div class="card border-0 rounded-0 mb-2">
                <div id="headingOne" class="row m-0 bg-light p-0" style="min-height: 100px;">
                    <div class="col-12 p-2 d-inline-flex align-items-center">
                        <div class="col-6 p-0">
                            <h6 class="color-acento m-0">
                                 <span class="border-bottom border-dark cursor-pointer"
                                       @click="seleccionarTarifa(tarifa)"
                                       data-toggle="modal"
                                       data-target="#modalDetalleTarifa"
                                 >{{tarifa.tarifa.nombre}}</span>
                            </h6>
                            <div class="text-uppercase p-0 text-left">
                                <div class="my-1 w-100 font-12">
                                    <template v-if="tarifa.tarifa.con_plan_alimento">
                                        {{$t('disponibilidad.hospedaje')}} + {{tarifa.tarifa.plan_alimento.nombre}}
                                    </template>

                                    <template v-else>
                                        {{$t('disponibilidad.solo_hospedaje')}}
                                    </template>
                                </div>
                            </div>
                            <div>
                                <a @click="seleccionarTarifa(tarifa)"
                                   data-toggle="modal"
                                   data-target="#modalDetalleTarifa"
                                   class="border-bottom border-dark cursor-pointer">
                                    {{$t('disponibilidad.detalle_tarifa')}}
                                </a>
                            </div>
                        </div>
                        <div class="col-5 text-center p-0" v-on:click="colapsar($event,tarifa.tarifa.id)">
                            <div class="pl-1 rate-price">
                                <span class="font-14">{{$t('disponibilidad.desde')}}</span>
                                <tarifa-precio-formula-component
                                    :solo_precio="true"
                                    :cotizacion_resumen="tarifa.tipo_habitacion_economica.formula"
                                    :moneda_seleccionada="monedaSeleccionada">
                                </tarifa-precio-formula-component>
                            </div>
                        </div>
                        <div class="col-1 p-0 d-flex align-items-center" v-on:click="colapsar($event,tarifa.tarifa.id)">
                            <i class="fa fa-2x fa-chevron-circle-up text-acento"
                               v-bind:id="'arrows'+tarifa.tarifa.id"></i>
                        </div>
                    </div>
                </div>
                <div id="collapseOne" class="collapse border-top show" aria-labelledby="headingOne">
                    <div class="card-body p-0">
                        <div class="container-fluid" v-bind:id="tarifa.tarifa.id">
                            <div class="row border-bottom py-2" v-for="tipo in tarifa.tipos_habitaciones">
                                <div class="col-6 px-2">
                                    <h6 class="color-acento mb-1">
                                            <span @click="seleccionarHabitacion(tarifa, tipo, tarifa.busqueda)"
                                                  data-toggle="modal"
                                                  data-target="#modalDetalleReserva"
                                                  class="border-bottom border-dark cursor-pointer">{{tipo.tipo_habitacion.nombre}}</span>
                                    </h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="badge p-0 font-12">
                                            <span
                                                class="font-weight-normal">{{$t('disponibilidad.max_ocupantes')}}:</span>
                                            <b>{{tipo.tipo_habitacion.ocupacion}}</b>
                                            <i class="fa fa-user ml-1"></i>
                                        </div>
                                    </div>
                                    <div v-if="tipo.tiene_promocion" class="mb-2">
                                        <span class="pr-2 rounded-pill border border-danger font-12">
                                            <i class="fas fa-tag circle-icon bg-danger p-1 text-light"></i>
                                              {{$t('disponibilidad.promocion')}}
                                        </span>
                                    </div>
                                    <div v-if="tipo.regla_cancelacion" class="d-flex align-items-center font-12">
                                        <template v-if="tipo.regla_cancelacion.es_reembolsable">
                                            <template
                                                v-for="restriccion of tipo.regla_cancelacion.restricciones">
                                                <template v-if="restriccion.tasa === 100">
                                                    <div class="mr-2">
                                                        <i class="fas fa-check circle-icon bg-success p-1 text-light"></i>
                                                    </div>
                                                    <div><span
                                                        v-html="$t('disponibilidad.cancelacion_gratuita')"></span>
                                                        <span class="text-capitalize">{{restriccion.fecha_limite | fechaDia}}</span>
                                                    </div>
                                                </template>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <div class="mr-1">
                                                <i class="fas fa-info-circle text-danger p-1 fa-lg"></i>
                                            </div>
                                            <div class="text-danger">{{$t('disponibilidad.no_reembolsable')}}</div>
                                        </template>

                                    </div>
                                </div>
                                <div class="col-6 text-right m-auto px-2">
                                    <tarifa-precio-formula-component
                                        class="mb-2"
                                        :cotizacion_resumen="tipo.formula"
                                        :moneda_seleccionada="monedaSeleccionada">
                                    </tarifa-precio-formula-component>
                                    <div v-if="loading_add" class="text-right pr-5">
                                        <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                                    </div>
                                    <b-button :disabled="tipo.formula.disponibles <= 0 || tieneElementos"
                                              v-else
                                              @click="agregarCarrito(tarifa.busqueda,tipo.tipo_habitacion,tarifa.tarifa)"
                                              variant="primary" ref="button">
                                        {{$t('disponibilidad.agregar')}}
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <modal-detalle-tarifa-component
            :tarifa="selectedTarifa">
        </modal-detalle-tarifa-component>
        <modal-detalle-reserva-component
            :color="color"
            :habitacion="selectedHabitacion"
            :tarifa="selectedTarifa"
            :busqueda="busqueda"
            :moneda_seleccionada="monedaSeleccionada">
        </modal-detalle-reserva-component>
        <modal-aviso-ajuste-component></modal-aviso-ajuste-component>
    </div>
</template>

<script>
    import '../../../../../js/filtros'
    import {carritoEvent, cambiarMonedaEvent} from "../../../app";

    export default {
        props: {
            datos: Array,
            color: String,
            propiedad: Object,
            tiene_elementos: Boolean,
        },
        data() {
            return {
                info: null,
                loading: true,
                loading_add: false,
                errored: false,
                selectedTarifa: null,
                selectedHabitacion: null,
                selectedHabitacionDetalle: null,
                busqueda: null,
                monedaSeleccionada: null,
                tieneElementos: this.tiene_elementos,
            }
        },
        mounted() {
            this.getMonedaActual();
            this.existeCarrito();
            // Ajustar la cantidad de habitaciones disponibles en -1
            carritoEvent.$on('agregarElementoCarrito', (elemento) => {
                this.tieneElementos = true;
                this.datos.forEach(_tarifa => {
                    _tarifa.tipos_habitaciones.forEach(habitacion => {
                        if (habitacion.tipo_habitacion.id === elemento.tipo_habitacion_id) {
                            habitacion.formula.disponibles -= 1;
                        }
                    });
                });
            });

            // Ajustar la cantidad de habitaciones disponibles en +1
            carritoEvent.$on('removerElementoCarrito', (elemento) => {
                this.tieneElementos = false;
                this.datos.forEach(_tarifa => {
                    _tarifa.tipos_habitaciones.forEach(habitacion => {
                        if (habitacion.tipo_habitacion.id === elemento.tipo_habitacion_id) {
                            habitacion.formula.disponibles += 1;
                        }
                    });
                });
            });
        },
        methods: {
            existeCarrito() {
                let existe = this.datos.find(_tarifa => {
                    return _tarifa.tipos_habitaciones.find(habitacion => habitacion.formula.en_carrito);
                });
                this.tieneElementos = !!existe;
            },
            getMonedaActual() {
                this.loading = true;
                this.errored = false;
                axios.get(window.url_get_moneda_actual)
                    .then(response => {
                        this.monedaSeleccionada = response.data;
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            },
            colapsar(event, id) {
                $('#arrows' + id).toggleClass('fa-chevron-circle-down fa-chevron-circle-up');
                $('#' + id).slideToggle();
            },
            seleccionarTarifa: function (item) {
                this.selectedTarifa = item;
            },
            seleccionarHabitacionDetalle: function (habitacion) {
                this.selectedHabitacionDetalle = habitacion;
            },
            seleccionarHabitacion: function (tarifa, habitacion, busqueda) {
                let merged = Object.assign({}, habitacion, tarifa);
                this.seleccionarTarifa(merged);
                this.selectedHabitacion = habitacion.tipo_habitacion;
                this.busqueda = busqueda;
            },
            agregarCarrito(busqueda, tipo, tarifa) {
                this.tieneElementos = true;
                this.loading_add = true;
                this.errored = false;
                const params = {
                    adultos: busqueda.adultos,
                    ninos1: busqueda.ninos1,
                    ninos2: busqueda.ninos2,
                    ninos3: busqueda.ninos3,
                    promocode: busqueda.promo_code,
                    tipo_habitacion_id: tipo.id,
                    tarifa_id: tarifa.id
                };
                axios.post(window.url_carrito_agregar, params)
                    .then(response => {
                        carritoEvent.$emit('agregarElementoCarrito', response.data.elemento);
                        this.errored = false;
                    })
                    .catch(error => {
                        this.errored = true
                        this.tieneElementos = false;
                    })
                    .finally(() => this.loading_add = false);
            },
        },
        created() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
        }
    }

</script>

<style scoped>

</style>
