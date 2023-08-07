<template>
    <div v-if="datos">
        <template v-for="tarifa in datos">
            <div class="card mb-3">
                <div class="card-body p-0">
                    <div class="row m-0">
                        <div class="col descripcion py-2">
                            <div class="d-flex align-items-center tarifaInfo" style="min-height: 80%">
                                <div class="w-100">
                                    <h5 class="color-acento mb-1">
                                        <span class="border-bottom border-dark cursor-pointer"
                                              @click="seleccionarTarifa(tarifa)"
                                              data-toggle="modal"
                                              data-target="#modalDetalleTarifa"
                                        >{{tarifa.tarifa.nombre}}</span>
                                    </h5>
                                    <div class="font-weight-normal text-uppercase mb-2">
                                        <template v-if="tarifa.tarifa.con_plan_alimento">
                                            {{$t('disponibilidad.hospedaje')}} + {{tarifa.tarifa.plan_alimento.nombre}}
                                        </template>
                                        <template v-else>
                                            {{$t('disponibilidad.solo_hospedaje')}}
                                        </template>
                                    </div>
                                    <div class="font-14 descripcionTarifa"
                                         :inner-html.prop="tarifa.tarifa.descripcion | truncar(140)"></div>
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
                        <div class="col-md-4 text-center cursor-pointer py-2">
                            <div class="pl-3 rate-price border-left" v-on:click="colapsar($event, tarifa.tarifa.id)">
                                <span class="font-14">{{$t('disponibilidad.desde')}}</span>
                                <tarifa-precio-formula-component
                                    :cotizacion_resumen="tarifa.tipo_habitacion_economica.formula"
                                    :moneda_seleccionada="monedaSeleccionada">
                                </tarifa-precio-formula-component>

                                <div class="badge bg-acento color-claro p-1" v-bind:id="tarifa.tarifa.id+'collapse'">
                                         <span v-html="tarifa.tipos_habitaciones_conteo">
                                         </span> {{$t('disponibilidad.habitaciones')}}
                                    <i class="fa fa-chevron-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container tarifas animated" v-bind:id="tarifa.tarifa.id">
                        <div class="row bg-light py-1 border-bottom border-top">
                            <div class="col-md-12">
                                <span class="text-uppercase font-weight-bold">
                                    {{$t('disponibilidad.habitaciones')}}
                                </span>
                            </div>
                        </div>
                        <div class="row border-bottom"
                             v-for="tipo in tarifa.tipos_habitaciones">
                            <div class="col-md-3 pl-0">
                                <div class="thumb-container dialog-category w-100 imageOpenGalley border-right"
                                     data-toggle="modal"
                                     data-target="#modalDetalleHabitacion"
                                     v-on:click="seleccionarHabitacionDetalle(tipo.tipo_habitacion)">
                                    <div class="image-thumbnail"
                                         v-if="tipo.tipo_habitacion.imagenes.length > 0"
                                         v-bind:style="{ 'background-image': 'url(' + tipo.tipo_habitacion.imagenes[0].src + ')' }">
                                    </div>
                                    <div class="image-thumbnail"
                                         v-else
                                         v-bind:style="{ 'background-image': 'url(../../imagenes/no-image.jpg)' }">
                                    </div>
                                    <div class="overlay">
                                    </div>
                                    <div class="overlay-gallery" v-if="tipo.tipo_habitacion.imagenes.length > 0">
                                        <i class="fa fa-images fa-2x bg-acento-hover text-light p-2 rounded"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 row">
                                <div class="d-flex align-items-center p-0">
                                    <div>
                                        <h5 class="color-acento mb-1">
                                            <span @click="seleccionarHabitacion(tarifa, tipo, tarifa.busqueda)"
                                                  data-toggle="modal"
                                                  data-target="#modalDetalleReserva"
                                                  class="border-bottom border-dark cursor-pointer">{{tipo.tipo_habitacion.nombre}}</span>
                                        </h5>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="badge p-0 font-12">
                                            <span
                                                class="font-weight-normal">{{$t('disponibilidad.max_ocupantes')}}:</span>
                                                <b>{{tipo.tipo_habitacion.ocupacion}}</b>
                                                <i class="fa fa-user ml-1"></i>
                                            </div>
                                        </div>
                                        <div v-if="tipo.tiene_promocion" class="mb-2">
                                        <span class="pr-2 rounded-pill border border-danger">
                                            <i class="fas fa-tag circle-icon bg-danger p-1 text-light"></i>
                                              {{$t('disponibilidad.promocion')}}
                                        </span>
                                        </div>
                                        <div v-if="tipo.regla_cancelacion" class="d-flex align-items-center">
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
                                </div>
                            </div>
                            <div class="col-md-4 text-right m-auto rate-price">
                                <tarifa-precio-formula-component
                                    class="mb-2"
                                    :cotizacion_resumen="tipo.formula"
                                    :moneda_seleccionada="monedaSeleccionada">
                                </tarifa-precio-formula-component>
                                <div v-if="loading_add" class="text-right pr-5">
                                    <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                                </div>
                                <b-button v-else :id="'popover-reserva-'+tarifa.tarifa.id+'-'+tipo.tipo_habitacion.id"
                                          :disabled="tipo.formula.disponibles <= 0 || tieneElementos"
                                          @click="agregarCarrito(tarifa.busqueda,tipo.tipo_habitacion,tarifa.tarifa)"
                                          variant="primary" ref="button">
                                    {{$t('disponibilidad.agregar')}}
                                </b-button>
                                <!--<popover-reserva-component v-if="propiedad"
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
                                </popover-reserva-component>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <modal-detalle-tarifa-component
            :tarifa="selectedTarifa">
        </modal-detalle-tarifa-component>
        <modal-detalle-habitacion-component
            :habitacion="selectedHabitacion">
        </modal-detalle-habitacion-component>
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
                tieneElementos: this.tiene_elementos,
                busqueda: null,
                monedaSeleccionada: null
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
                $('#' + id + 'collapse').find('i').toggleClass('fa-chevron-down fa-chevron-up');
                $('#' + id).slideToggle();
            },
            seleccionarTarifa: function (item) {
                this.selectedTarifa = item;
            },
            seleccionarHabitacionDetalle: function (habitacion) {
                this.selectedHabitacionDetalle = habitacion;
            },
            seleccionarHabitacion: function (tarifa, habitacion, busqueda) {
                this.closePopover();
                let merged = Object.assign({}, habitacion, tarifa);
                this.seleccionarTarifa(merged);
                this.selectedHabitacion = habitacion.tipo_habitacion;
                this.busqueda = busqueda;
            },
            closePopover() {
                carritoEvent.$emit('closePopover');
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
