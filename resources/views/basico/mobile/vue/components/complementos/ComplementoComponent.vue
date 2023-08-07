<template>
    <section v-if="errored">
        <p class="card mt-4 p-3 text-center card rounded-0 border-0 shadow-sm">
            {{$t('validation.error_500')}}
        </p>
    </section>
    <section v-else>
        <div v-if="loading" class="justify-content-center d-flex my-5">
            <spring-spinner
                :animation-duration="3000"
                :size="60"
                :color="color_cargador"
            />
        </div>
        <template v-else>
           <div v-if="listaComplementos.length > 0 ">
                <template v-for="(complemento) in listaComplementos">
                    <div class="rounded-0 border-0 card shadow mb-3">
                        <div class="row m-0">
                            <div class="col-4 pl-0">
                                <div class="thumb-container dialog-category w-100 imageOpenGalley"
                                     data-toggle="modal" data-target="#modalDetalleComplemento"
                                     v-on:click="verDetalleComplemento(complemento)">
                                    <div class="image-thumbnail"
                                         v-if="complemento.imagen_crop"
                                         v-bind:style="{ 'background-image': 'url(' + complemento.imagen_crop + ')' }">
                                    </div>
                                    <div class="image-thumbnail"
                                         v-else
                                         style="background-image: url('/imagenes/no-image-complement.jpg');"></div>
                                    <div class="overlay-gallery">
                                        <i class="fa fa-info-circle  bg-acento-hover text-light p-1 rounded"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 p-0">
                                <div class="p-0 col-12">
                                    <h6 class="mt-1">{{complemento.nombre}}</h6>
                                    <div class="font-12">
                                        <span
                                            v-if="complemento.modo_cobro == 'estancia' || complemento.modo_cobro == 'noche' && monedaSeleccionada">
                                                     {{$t('complemento.precio')}}:
                                                    <span class="font-weight-bold">
                                                        {{ complemento.precio_unitario |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </span>
                                                </span>
                                        <span
                                            v-if="complemento.modo_cobro == 'persona' || complemento.modo_cobro == 'persona_noche' && monedaSeleccionada">
                                                    <template v-if="complemento.aplica_adultos">
                                                        {{$t('complemento.adultos')}}:
                                                        <span class="font-weight-bold">
                                                            {{ complemento.precio_adultos |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                    <template v-if="complemento.aplica_ninos1 && monedaSeleccionada">
                                                        <br>
                                                        {{$t('complemento.ninos')}} ({{propiedad.ninos_min_1}}-{{propiedad.ninos_max_1}} {{$t('complemento.anios')}}):
                                                        <span class="font-weight-bold">
                                                            {{ complemento.precio_ninos1 |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                    <template v-if="complemento.aplica_ninos2 && monedaSeleccionada">
                                                        <br>
                                                        {{$t('complemento.ninos')}} ({{propiedad.ninos_min_2}}-{{propiedad.ninos_max_2}} {{$t('complemento.anios')}}):
                                                        <span class="font-weight-bold">
                                                            {{ complemento.precio_ninos2 |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                    <template v-if="complemento.aplica_ninos3 && monedaSeleccionada">
                                                        <br>
                                                        {{$t('complemento.ninos')}} ({{propiedad.ninos_min_3}}-{{propiedad.ninos_max_3}} {{$t('complemento.anios')}}):
                                                        <span class="font-weight-bold">
                                                            {{ complemento.precio_ninos3 |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                </span>
                                    </div>
                                    <div class="font-12 my-1">
                                        <strong>
                                            <span v-if="complemento.modo_cobro == 'persona_noche'">{{$t('complemento.persona_noche')}}</span>
                                            <span
                                                v-if="complemento.modo_cobro == 'persona'">{{$t('complemento.persona')}}</span>
                                            <span
                                                v-if="complemento.modo_cobro == 'estancia' || complemento.modo_cobro == 'noche'">{{$t('complemento.por_'+complemento.modo_cobro)}} </span><br>
                                        </strong>
                                    </div>
                                </div>
<!--                                <div class="mb-1 mt-2">-->
<!--                                    <b-button variant="primary" ref="button"-->
<!--                                              :disabled="cargadorAgregarComplemento"-->
<!--                                              :class="'btn-sm reservar-complemento-'+complemento.id"-->
<!--                                              v-show="indexOfComplementoSeleccionado(complemento.id) == -1"-->
<!--                                              v-on:click="colapsar(complemento)">-->
<!--                                        {{$t('complemento.agregar')}}-->
<!--                                    </b-button>-->
<!--                                    <button type="button" class="btn btn-sm btn-outline-danger addon-remove"-->
<!--                                            :disabled="indexOfComplementoSeleccionado(complemento.id) < 0 || cargadorAgregarComplemento"-->
<!--                                            :id="'btn-remove-'+complemento.id"-->
<!--                                            v-show="indexOfComplementoSeleccionado(complemento.id) >= 0"-->
<!--                                             v-on:click="removerComplementoSeleccionado(complemento)">-->
<!--                                        <i class="fa fa-remove"></i>-->
<!--                                        {{$t('complemento.remover')}}-->
<!--                                    </button>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <div class="container habitaciones" v-bind:id="complemento.id">
<!--                             :style="(indexOfComplementoSeleccionado(complemento.id) >= 0 ?'display:block;':'display:none')"-->

                            <div class="row bg-light py-1 border-bottom border-top">
                                <div class="col-12">
                                    <span
                                        class="text-uppercase font-weight-bold font-12">{{$t('complemento.habitaciones')}}</span>
                                </div>
                            </div>
                            <div
                                v-if="complemento.tipos_habitaciones.length > 0">
                                <div v-for="(habitacion) in complemento.tipos_habitaciones">
                                       <div class="row py-2 border-bottom reserva">
                                        <div class="col-6">
                                            <h6 class="font-weight-bold font-14 mb-0">{{$t('disponibilidad.habitacion')}}
                                                {{habitacion.indice}}:</h6>
                                            <h6 class="color-acento mb-0 font-14">
                                                {{habitacion.tipo_habitacion}}
                                            </h6>
                                        </div>
                                        <div class="col-6 pl-0 text-center">
                                            <complemento-selector-component
                                                :class="{ 'd-none': cargadorAgregarComplemento }"
                                                :mostrar_selector="complemento.modo_cobro == 'estancia' ? true: false"
                                                :complemento="complemento"
                                                :habitacion="habitacion"
                                                :is_checked="habitacion.seleccionado"
                                                :is_disabled="false"
                                            >
                                            </complemento-selector-component>
                                            <div :class="{ 'd-none': !cargadorAgregarComplemento }">
                                                <i class="fas fa-circle-notch fa-spin fa-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <modal-detalle-complemento-component
                    :complemento="selectedComplemento"
                    :propiedad="propiedad"
                    :monedaSeleccionada="monedaSeleccionada">
                </modal-detalle-complemento-component>
            </div>
        </template>
    </section>
</template>
<script>
    import {SpringSpinner} from 'epic-spinners'
    import {carritoEvent, cambiarMonedaEvent, totalCarritoEvent,complementoEvent} from "../../app";

    export default {
        components: {
            SpringSpinner
        },
        props: {
            propiedad: Object,
            entrada: String,
            noches: Number,
            color_cargador: String,
        },
        data() {
            return {
                listaComplementos: [],
                complementosSeleccionados: [],
                loading: true,
                errored: false,
                cargadorAgregarComplemento: false,
                selectedComplemento: {id: 0, nombre: '', descripcion: ''},
                monedaSeleccionada: null,
            }
        },
        created() {
            this.getMonedaActual();
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
            complementoEvent.$on('deshabilitarBoton', (resp) => {
                this.cargadorAgregarComplemento = true;
            });
            complementoEvent.$on('habilitarBoton', (resp) => {
                this.cargadorAgregarComplemento = false;
            });

        },
        mounted() {
            carritoEvent.$on('removerComplementoCarrito', (datosComplemento) => {
                let complemento_encontrado = this.complementosSeleccionados.find(c => c.id == datosComplemento.complemento_id);
                if (complemento_encontrado) {
                    complemento_encontrado.cantidad -= 1;
                    // Volver a seleccionar por si hay algún cambio realizado por un evento
                    complemento_encontrado = this.complementosSeleccionados.find(c => c.id == datosComplemento.complemento_id);
                    if (complemento_encontrado.cantidad === 0) {
                        let idxc = this.indexOfComplementoSeleccionado(datosComplemento.complemento_id);
                        this.complementosSeleccionados.splice(idxc, 1);
                        this.colapsar(complemento_encontrado);
                    }
                }
            });
            // Agregar complemento
            carritoEvent.$on('agregarComplementoCarrito', (datosComplemento) => {
                let complemento_encontrado = this.complementosSeleccionados.find(c => c.id == datosComplemento.complemento_id);
                if (complemento_encontrado) {
                    complemento_encontrado.cantidad += 1;
                } else {
                    this.complementosSeleccionados.push({
                        id: datosComplemento.complemento_id,
                        cantidad: 1
                    });
                }
                this.enableRemoveButton(datosComplemento.complemento_id);
            });
        },
        methods: {
            getMonedaActual() {
                axios.get(window.url_get_moneda_actual)
                    .then(response => {
                        this.monedaSeleccionada = response.data;
                        this.getComplementos();
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => true)
            },
            colapsar(complemento) {
                $('#' + complemento.id).slideToggle();
                // $('#' + complemento.id).show(1000);
            },
            verDetalleComplemento: function (complemento) {
                this.selectedComplemento = complemento;
            },
            getComplementos() {
                this.loading = true;
                this.errored = false;
                axios.post(window.url_complemento)
                    .then(response => {
                        this.listaComplementos = response.data;
                        this.seleccionarComplementos()
                    })
                    .catch(error => {
                        console.log(error);
                        this.errored = true;
                    })
                    .finally(() => false);
            },
            indexOfComplementoSeleccionado(complemento_id) {
                return this.complementosSeleccionados.findIndex(c => c.id == complemento_id);
            },
            seleccionarComplementos() {
                this.listaComplementos.forEach(complemento => {
                    complemento.tipos_habitaciones.forEach(habitacion => {
                        let complemento_encontrado = this.complementosSeleccionados.find(c => c.id == complemento.id);
                        if (habitacion.seleccionado) {
                            if (complemento_encontrado) {
                                complemento_encontrado.cantidad += 1;
                            } else {
                                this.complementosSeleccionados.push({
                                    id: complemento.id,
                                    cantidad: 1
                                });
                            }
                        }
                        this.colapsar(complemento);
                    });
                });
                this.loading = false
            },
            removerComplementoSeleccionado(complemento) {
                this.cargadorAgregarComplemento = true;
                let data = {
                    complemento_id: complemento.id
                };
                axios.post(window.url_carrito_complemento_remover, data)
                    .then(response => {
                        this.disabled = false;
                        carritoEvent.$emit('removerComplementoCarrito', data);
                        complementoEvent.$emit('habilitarBoton');
                        complementoEvent.$emit('removerComplementosSeleccionados', data);
                        this.cargadorAgregarComplemento = false;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => true);
            },
            enableRemoveButton(complemento_id) {
                var elementos = $('#' + complemento_id).find('input[type="checkbox"]:disabled').length;
                var $this = this;

                // Si sólo queda un elemento deshabilitado
                if (elementos == 1) {
                    // Esperar un momento para verificar nuevamente
                    setTimeout(function () {
                        $this.enableRemoveButton(complemento_id);
                    }, 1500);
                }
                // Si ya no hay elementos deshabilitado, habilitamos el botón remover
                else if (elementos == 0) {
                    $('#btn-remove-' + complemento_id).prop('disabled', false);
                }
            },
            next() {
                window.location.href = this.next_url;
            },
            prev() {
                window.location.href = this.prev_url;
            },
            getLog(log) {
                console.log(log)
            }
        },


    }
</script>
<style scoped>
</style>
