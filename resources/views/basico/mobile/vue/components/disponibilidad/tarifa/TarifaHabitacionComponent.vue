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
                            <i class="fa fa-2x fa-chevron-circle-up text-acento" v-bind:id="'arrows'+tarifa.tarifa.id"></i>
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
                                    <b-button :disabled="tipo.formula.disponibles <= 0"
                                              v-b-modal="'modal-cotizar-'+tarifa.tarifa.id+'-'+tipo.tipo_habitacion.id"
                                              variant="primary" ref="button">
                                        {{$t('disponibilidad.seleccionar')}}
                                    </b-button>
                                </div>
                                <b-modal :id="'modal-cotizar-'+tarifa.tarifa.id+'-'+tipo.tipo_habitacion.id"
                                         :title="$t('disponibilidad.reservar_habitacion')" size="xl">
                                    <modal-cotizar-component v-if="propiedad"
                                                             @closemodal="cerrar('modal-cotizar-'+tarifa.tarifa.id+'-'+tipo.tipo_habitacion.id)"
                                                             :popoverId="'popover-reserva-'+tarifa.tarifa.id+'-'+tipo.tipo_habitacion.id"
                                                             :color_cargador="color"
                                                             :moneda_seleccionada="monedaSeleccionada"
                                                             :tipo="tipo.tipo_habitacion"
                                                             :tarifa="tarifa.tarifa"
                                                             :formula="tipo.formula"
                                                             :busqueda="tarifa.busqueda"
                                                             :configuracion_hospedaje="{
                                                                tiene_ninos_1:propiedad.tiene_ninos_1,
                                                                ninos_min_1:propiedad.ninos_min_1,
                                                                ninos_max_1:propiedad.ninos_max_1,
                                                                tiene_ninos_2:propiedad.tiene_ninos_2,
                                                                ninos_min_2:propiedad.ninos_min_2,
                                                                ninos_max_2:propiedad.ninos_max_2,
                                                                tiene_ninos_3:propiedad.tiene_ninos_3,
                                                                ninos_min_3:propiedad.ninos_min_3,
                                                                ninos_max_3:propiedad.ninos_max_3
                                                            }">
                                    </modal-cotizar-component>
                                    <template v-slot:modal-footer>
                                        <b-button
                                            variant="primary"
                                            class="float-right"
                                            @click="cerrar('modal-cotizar-'+tarifa.tarifa.id+'-'+tipo.tipo_habitacion.id)"
                                        >
                                            {{$t('disponibilidad.cerrar')}}
                                        </b-button>
                                    </template>
                                </b-modal>
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
            propiedad: Object
        },
        data() {
            return {
                info: null,
                loading: true,
                errored: false,
                selectedTarifa: null,
                selectedHabitacion: null,
                selectedHabitacionDetalle: null,
                busqueda: null,
                monedaSeleccionada: null
            }
        },
        mounted() {
            this.getMonedaActual();
            // Ajustar la cantidad de habitaciones disponibles en -1
            carritoEvent.$on('agregarElementoCarrito', (elemento) => {
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
            cerrar(id) {
                this.$root.$emit('bv::hide::modal', id)
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
            }
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
