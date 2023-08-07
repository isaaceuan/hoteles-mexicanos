<template>
    <section v-if="errored">
        <p class="card mt-4 p-3 text-center card rounded-0 border-0 shadow-sm">
            {{$t('validation.error_500')}}
        </p>
    </section>
    <section v-else>
        <div v-if="loading" class="justify-content-center d-flex mt-5">
            <spring-spinner
                :animation-duration="3000"
                :size="60"
                :color="color_cargador"
            />
        </div>
        <div v-else class="mt-3 rounded-0 border-0 shadow-sm">
            <div v-if="existe_disponibilidad">
                <tarifa-habitacion-component
                    v-if="por_tarifa"
                    :datos="datos"
                    :propiedad="propiedad"
                    :color="color_cargador">
                </tarifa-habitacion-component>
                <habitacion-tarifa-component
                    v-else
                    :datos="datos"
                    :color="color_cargador"
                    :propiedad="propiedad">
                </habitacion-tarifa-component>
            </div>
            <div v-else>
                <grid-sin-disponibilidad-component
                    :datos="restricciones"
                    :fecha_entrada_set="fecha_entrada"
                    :fecha_salida_set="fecha_salida"
                >
                </grid-sin-disponibilidad-component>
                <modal-sin-disponibilidad-component
                    @closemodal="abrir_modal_disponibilidad=false"
                    :datos="restricciones"
                    :mostrar="abrir_modal_disponibilidad"
                >
                </modal-sin-disponibilidad-component>
            </div>
        </div>
    </section>

</template>

<script>
    import {SpringSpinner} from 'epic-spinners'
    import {agrupadorEvent, totalEvent} from '../app';
    import GridSinDisponibilidadComponent from "./disponibilidad/sinDisponibilidad/GridSinDisponibilidadComponent.vue";

    export default {
        props: {
            propiedad: Object,
            fecha_entrada: String,
            fecha_salida: String,
            noches: Number,
            adultos: Number,
            ninos_1: Number,
            ninos_2: Number,
            ninos_3: Number,
            codigo_promocion: String,
            color_cargador: String
        },
        components: {
            GridSinDisponibilidadComponent,
            SpringSpinner
        },
        data() {
            return {
                por_tarifa: 0,
                abrir_modal_disponibilidad: false,
                existe_disponibilidad: false,
                datos: null,
                restricciones: null,
                loading: true,
                errored: false
            }
        },
        mounted() {
        },
        methods: {
            getElementos() {
                this.loading = true;
                this.errored = false;
                const params = {
                    por_tarifa: this.por_tarifa
                };
                axios.post(window.url_cotizacion_multipe, params)
                    .then(response => {
                        this.datos = response.data;
                        if (this.datos.length > 0) {
                            this.existe_disponibilidad = true;
                        } else {
                            this.getRestricciones();
                            this.existe_disponibilidad = false;
                        }
                        if (this.datos) {
                            totalEvent.$emit('totalEvent', this.datos.length);
                        }
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            },
            getRestricciones() {
                this.loading = true;
                this.errored = false;
                const params = {
                    fecha_entrada: this.fecha_entrada,
                    noches: this.noches,
                    idioma_id: window.lang
                };
                axios.post(window.url_get_restricciones, params)
                    .then(response => {
                        this.abrir_modal_disponibilidad = true;
                        this.restricciones = response.data;
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            }
        },
        created() {
            this.getElementos();
            agrupadorEvent.$on('agrupadorEvent', obj => {
                this.por_tarifa = obj;
                this.getElementos();
            });
        }
    }
</script>

<style scoped>

</style>
