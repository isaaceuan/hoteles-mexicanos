<template>
    <div v-if="datos">
        <template v-for="tipo in datos">
            <div class="card border-0 rounded-0 mb-2">
                <div id="headingOne" class="row m-0 bg-light p-0" style="min-height: 100px;">
                    <div class="col-4 p-0"
                         data-toggle="modal"
                         data-target="#modalDetalleHabitacion"
                         v-on:click="seleccionarHabitacion(tipo.tipo_habitacion)">
                        <div class="h-100"
                             v-if="tipo.tipo_habitacion.imagenes.length > 0"
                             v-bind:style="{ 'background-image': 'url(' + tipo.tipo_habitacion.imagenes[0].src + ')' }"
                             style="background-position: center center; background-size: cover; background-repeat: no-repeat;">
                        </div>
                        <div class="image-thumbnail"
                             v-else
                             style="height:115px; background-image: url('../imagenes/no-image.jpg');background-position: center center; background-size: cover; background-repeat: no-repeat;">
                        </div>
                        <div class="overlay-gallery" v-if="tipo.tipo_habitacion.imagenes.length > 0">
                            <i class="fa fa-images bg-acento-hover text-light p-1 rounded"></i>
                        </div>
                    </div>
                    <div class="col-8 p-2 d-inline-flex" v-on:click="colapsar($event,tipo.tipo_habitacion.id)">
                        <div class="col-10 p-0">
                            <h6 class="color-acento m-0">
                                {{tipo.tipo_habitacion.nombre}}
                            </h6>
                            <span class="badge p-0 font-12"><span class="font-weight-normal"
                            >{{$t('disponibilidad.max_ocupantes')}}:</span> <b>{{tipo.tipo_habitacion.adultos}}</b>  <i
                                class="fa fa-user ml-1"></i></span>
                            <div class="best-rate">
                                <div class="mb-0"><span
                                    class="font-12 font-weight-normal">{{$t('disponibilidad.desde')}}:</span>
                                    <div class="text-center" style="margin-top: -2px;">
                                        <tarifa-precio-formula-component
                                            :solo_precio="true"
                                            :cotizacion_resumen="tipo.tarifa_economica.formula"
                                            :moneda_seleccionada="monedaSeleccionada">
                                        </tarifa-precio-formula-component>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 pl-2 d-flex align-items-center">
                            <i class="fa fa-2x fa-chevron-circle-up text-acento"
                               v-bind:id="'arrows'+tipo.tipo_habitacion.id"></i>
                            <div class="badge bg-acento color-claro p-1 mr-1"
                                 style="position: absolute;bottom: 0;right: 0;">
                            <span class="mr-1"
                                  v-html="tipo.tarifas_conteo"></span>{{$t('disponibilidad.tarifa')}}<span v-if="tipo.tarifas_conteo>1">s</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapseOne" class="collapse border-top show" aria-labelledby="headingOne">
                    <div class="card-body p-0">
                        <div class="container-fluid" v-bind:id="tipo.tipo_habitacion.id">
                            <div class="row border-bottom py-2" v-for="tarifa in tipo.tarifas">
                                <div class="col-6 px-2">
                                    <h6 class="color-acento m-0">
                                        <span class="border-bottom border-dark"
                                              @click="seleccionarTarifa(tipo.tipo_habitacion, tarifa, tipo.busqueda)"
                                              data-toggle="modal"
                                              data-target="#modalDetalleReserva">{{tarifa.tarifa.nombre}}</span>
                                    </h6>
                                    <small class="badge p-0 font-weight-normal text-uppercase">{{$t('disponibilidad.hospedaje')}}
                                        <span v-if="tarifa.tarifa.con_plan_alimento">+ {{$t('disponibilidad.alimentos')}}</span>
                                    </small>
                                    <div v-if="tarifa.tiene_promocion" class="my-2">
                                        <span class="pr-2 rounded-pill border border-danger font-12">
                                            <i class="fas fa-tag circle-icon bg-danger p-1 text-light"></i>
                                              {{$t('disponibilidad.promocion')}}
                                        </span>
                                    </div>
                                    <div v-if="tarifa.regla_cancelacion" class="d-flex align-items-center font-12">
                                        <template v-if="tarifa.regla_cancelacion.es_reembolsable">
                                            <template
                                                v-for="restriccion of tarifa.regla_cancelacion.restricciones">
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
                                <div class="col-6 px-2 text-right">
                                    <div class="mb-2">
                                        <tarifa-precio-formula-component
                                            :cotizacion_resumen="tarifa.formula"
                                            :moneda_seleccionada="monedaSeleccionada">
                                        </tarifa-precio-formula-component>
                                    </div>
                                    <b-button :disabled="tarifa.formula.disponibles <= 0"
                                              v-b-modal="'modal-cotizar-'+tipo.tipo_habitacion.id+'-'+tarifa.tarifa.id"
                                              variant="primary" ref="button">
                                        {{$t('disponibilidad.seleccionar')}}
                                    </b-button>
                                </div>
                                <b-modal :id="'modal-cotizar-'+tipo.tipo_habitacion.id+'-'+tarifa.tarifa.id"
                                         :title="$t('disponibilidad.reservar_habitacion')" size="xl">
                                    <modal-cotizar-component v-if="propiedad"
                                                             @closemodal="cerrar('modal-cotizar-'+tipo.tipo_habitacion.id+'-'+tarifa.tarifa.id)"
                                                             :popoverId="'popover-reserva-'+tipo.tipo_habitacion.id+'-'+tarifa.tarifa.id"
                                                             :color_cargador="color"
                                                             :moneda_seleccionada="monedaSeleccionada"
                                                             :tipo="tipo.tipo_habitacion"
                                                             :tarifa="tarifa.tarifa"
                                                             :formula="tarifa.formula"
                                                             :busqueda="tipo.busqueda"
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
                                            @click="cerrar('modal-cotizar-'+tipo.tipo_habitacion.id+'-'+tarifa.tarifa.id)"
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
        <modal-detalle-habitacion-component
            :habitacion="selectedRoom">
        </modal-detalle-habitacion-component>
        <modal-detalle-reserva-component
            :busqueda="busqueda"
            :color="color"
            :habitacion="selectedRoom"
            :tarifa="selectedTarifa"
            :moneda_seleccionada="monedaSeleccionada">
        </modal-detalle-reserva-component>
        <modal-aviso-ajuste-component></modal-aviso-ajuste-component>
    </div>
</template>
<script>
    import {carritoEvent, cambiarMonedaEvent} from "../../../app";

    export default {
        props: {
            datos: Array,
            color: String,
            propiedad: Object,
        },
        data() {
            return {
                info: null,
                loading: true,
                errored: false,
                selectedRoom: {id: 0, nombre: '', imagenes: [], descripcion: ''},
                selectedTarifa: null,
                busqueda: null,
                monedaSeleccionada: null,
            }
        },
        mounted: function () {
            this.getMonedaActual();
            // Ajustar la cantidad de habitaciones disponibles en -1
            carritoEvent.$on('agregarElementoCarrito', (elemento) => {
                let _habitacion = this.datos.find(habitacion => habitacion.tipo_habitacion.id === elemento.tipo_habitacion_id);
                _habitacion.tarifas.forEach(tarifa => {
                    tarifa.formula.disponibles -= 1;
                });

            });
            // Ajustar la cantidad de habitaciones disponibles en +1
            carritoEvent.$on('removerElementoCarrito', (elemento) => {
                let _habitacion = this.datos.find(habitacion => habitacion.tipo_habitacion.id === elemento.tipo_habitacion_id);
                _habitacion.tarifas.forEach(tarifa => {
                    tarifa.formula.disponibles += 1;
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
            seleccionarHabitacion: function (item) {
                this.selectedRoom = item;
            },
            seleccionarTarifa: function (habitacion, tarifa, busqueda) {
                this.seleccionarHabitacion(habitacion);
                this.seleccionarHabitacion(habitacion);
                this.selectedTarifa = tarifa;
                this.busqueda = busqueda;
            }
        },
        created() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
        },
    }
</script>
<style scoped>
</style>
