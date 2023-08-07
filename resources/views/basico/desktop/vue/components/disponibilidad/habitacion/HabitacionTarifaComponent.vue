<template>
    <div v-if="datos">
        <template v-for="tipo in datos">
            <div class="card mb-3">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="thumb-container dialog-category w-100 imageOpenGalley border-right"
                                 data-toggle="modal"
                                 data-target="#modalDetalleHabitacion"
                                 v-on:click="seleccionarHabitacion(tipo.tipo_habitacion)">
                                <div class="image-thumbnail"
                                     v-if="tipo.tipo_habitacion.imagenes.length > 0"
                                     v-bind:style="{ 'background-image': 'url(' + tipo.tipo_habitacion.imagenes[0].src + ')' }">
                                </div>
                                <div class="image-thumbnail"
                                     v-else
                                     style="background-image: url('../imagenes/no-image.jpg');"></div>
                                <div class="overlay">
                                </div>
                                <div class="overlay-gallery" v-if="tipo.tipo_habitacion.imagenes.length > 0">
                                    <i class="fa fa-images fa-2x bg-acento-hover text-light p-2 rounded"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 row descripcion">
                            <div class="d-flex align-items-center p-0">
                                <div>
                                    <h5 class="color-acento mb-1">
                                        {{tipo.tipo_habitacion.nombre}}
                                    </h5>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="badge p-0 font-12">
                                            <span
                                                class="font-weight-normal">{{$t('disponibilidad.max_ocupantes')}}:</span>
                                            <b>{{tipo.tipo_habitacion.ocupacion}}</b>
                                            <i class="fa fa-user ml-1"></i>
                                        </div>
                                    </div>
                                    <div class="font-14"
                                         :inner-html.prop="tipo.tipo_habitacion.descripcion | truncar(150)">
                                    </div>
                                </div>
                            </div>
                            <div class="w-100" style="height: 25px">
                                <a data-toggle="modal"
                                   data-target="#modalDetalleHabitacion"
                                   class="border-bottom border-dark cursor-pointer"
                                   v-on:click="seleccionarHabitacion(tipo.tipo_habitacion)">
                                    {{$t('disponibilidad.detalle_habitacion')}}
                                </a>
                            </div>
                        </div>
                        <div class="col text-center cursor-pointer py-2">
                            <div class="pl-3 rate-price border-left"
                                 v-on:click="colapsar($event, tipo.tipo_habitacion.id)">
                                <span class="font-14">{{$t('disponibilidad.desde')}}</span>
                                <tarifa-precio-formula-component
                                    :cotizacion_resumen="tipo.tarifa_economica.formula"
                                    :moneda_seleccionada="monedaSeleccionada">
                                </tarifa-precio-formula-component>
                                <div class="badge bg-acento color-claro p-1"
                                     v-bind:id="tipo.tipo_habitacion.id+'collapse'">
                                         <span v-html="tipo.tarifas_conteo">
                                         </span> {{$t('disponibilidad.tarifas')}}
                                    <i class="fa fa-chevron-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container tarifas animated"
                         v-bind:id="tipo.tipo_habitacion.id">
                        <div class="row bg-light py-1 border-bottom border-top">
                            <div class="col-md-12">
                                <span class="text-uppercase font-weight-bold">{{$t('disponibilidad.tarifas')}}</span>
                            </div>
                        </div>
                        <div class="row py-2 border-bottom"
                             v-for="tarifa in tipo.tarifas">
                            <div class="col-md-6 pr-0">
                                <div class="text-uppercase font-weight-bold mb-1">
                                    <a class="border-bottom border-dark cursor-pointer"
                                       @click="seleccionarTarifa(tipo.tipo_habitacion, tarifa, tipo.busqueda)"
                                       data-toggle="modal"
                                       data-target="#modalDetalleReserva"
                                    >
                                        {{tarifa.tarifa.nombre}}
                                    </a>
                                    <div class="font-weight-normal mb-2">
                                        <template v-if="tarifa.tarifa.con_plan_alimento">
                                            {{$t('disponibilidad.hospedaje')}} + {{tarifa.tarifa.plan_alimento.nombre}}
                                        </template>
                                        <template v-else>
                                            {{$t('disponibilidad.solo_hospedaje')}}
                                        </template>
                                    </div>
                                </div>
                                <div v-if="tarifa.tiene_promocion" class="mb-2">
                                        <span class="pr-2 rounded-pill border border-danger">
                                            <i class="fas fa-tag circle-icon bg-danger p-1 text-light"></i>
                                              {{$t('disponibilidad.promocion')}}
                                        </span>
                                </div>
                                <div v-if="tarifa.regla_cancelacion" class="d-flex align-items-center">
                                    <template v-if="tarifa.regla_cancelacion.es_reembolsable">
                                        <template
                                            v-for="restriccion of tarifa.regla_cancelacion.restricciones">
                                            <template v-if="restriccion.tasa === 100">
                                                <div class="mr-2">
                                                    <i class="fas fa-check circle-icon bg-success p-1 text-light"></i>
                                                </div>
                                                <div><span v-html="$t('disponibilidad.cancelacion_gratuita')"></span>
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
                            <div class="col-md-4 text-right m-auto rate-price">
                                <tarifa-precio-formula-component
                                    :cotizacion_resumen="tarifa.formula"
                                    :moneda_seleccionada="monedaSeleccionada">
                                </tarifa-precio-formula-component>
                            </div>
                            <div class="col-md-2 m-auto text-center">
                                <b-button :id="'popover-reserva-'+tipo.tipo_habitacion.id+'-'+tarifa.tarifa.id"
                                          :disabled="tarifa.formula.disponibles <= 0"
                                          @click="closePopover()"
                                          variant="primary" ref="button">
                                    {{$t('disponibilidad.seleccionar')}}
                                </b-button>
                                <popover-reserva-component v-if="propiedad"
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
                                </popover-reserva-component>
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
            :habitacion="selectedRoom"
            :color="color"
            :tarifa="selectedTarifa"
            :busqueda="busqueda"
            :moneda_seleccionada="monedaSeleccionada">
        </modal-detalle-reserva-component>
        <modal-aviso-ajuste-component></modal-aviso-ajuste-component>
    </div>
</template>
<script>
    // import JQuery from 'jquery';
    import {carritoEvent, cambiarMonedaEvent} from "../../../app";

    // let $ = JQuery;
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
                $('#' + id + 'collapse').find('i').toggleClass('fa-chevron-down fa-chevron-up');
                $('#' + id).slideToggle();
            },
            seleccionarHabitacion: function (item) {
                this.selectedRoom = item;
            },
            seleccionarTarifa: function (habitacion, tarifa, busqueda) {
                this.closePopover();
                this.seleccionarHabitacion(habitacion);
                this.selectedTarifa = tarifa;
                this.busqueda = busqueda;
            },
            closePopover() {
                carritoEvent.$emit('closePopover');
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
