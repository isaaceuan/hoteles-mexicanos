<template>
    <div v-if="popoverId">
        <div>
            <div class="form-group mb-2">
                <label class="col-7 p-0">{{$t('disponibilidad.adulto')}}s</label>
                <input-spinner
                    ref="spinnerAdultos"
                    :integerOnly="true"
                    :min="1"
                    :max="tipo_habitacion.adultos"
                    :step="1"
                    :size="'sm'"
                    :buttonClass="'btn-light border'"
                    :inputClass="'text-center'"
                    v-model="ocupantes.adultos"
                ></input-spinner>
            </div>
            <div class="form-group mb-2" v-if="tipo_habitacion.ninos && configuracion_hospedaje.tiene_ninos_1">
                <label class="col-7 p-0">{{$t('disponibilidad.ninos')}} ({{configuracion_hospedaje.ninos_min_1}} -
                    {{configuracion_hospedaje.ninos_max_1}})</label>
                <input-spinner
                    ref="spinnerNinos1"
                    :integerOnly="true"
                    :min="0"
                    :max="(tipo_habitacion.adultos - 1)"
                    :step="1"
                    :size="'sm'"
                    :buttonClass="'btn-light border'"
                    :inputClass="'text-center'"
                    v-model="ocupantes.ninos1"
                ></input-spinner>
            </div>
            <div class="form-group mb-2" v-if="tipo_habitacion.ninos && configuracion_hospedaje.tiene_ninos_2">
                <label class="col-7 p-0">{{$t('disponibilidad.ninos')}} ({{configuracion_hospedaje.ninos_min_2}} -
                    {{configuracion_hospedaje.ninos_max_2}})</label>
                <input-spinner
                    ref="spinnerNinos2"
                    :integerOnly="true"
                    :min="0"
                    :max="(tipo_habitacion.adultos - 1)"
                    :step="1"
                    :size="'sm'"
                    :buttonClass="'btn-light border'"
                    :inputClass="'text-center'"
                    v-model="ocupantes.ninos2"
                ></input-spinner>
            </div>
            <div class="form-group mb-2" v-if="tipo_habitacion.ninos && configuracion_hospedaje.tiene_ninos_3">
                <label class="col-7 p-0">{{$t('disponibilidad.ninos')}} ({{configuracion_hospedaje.ninos_min_3}} -
                    {{configuracion_hospedaje.ninos_max_3}})</label>
                <input-spinner
                    ref="spinnerNinos3"
                    :integerOnly="true"
                    :min="0"
                    :max="(tipo_habitacion.adultos - 1)"
                    :step="1"
                    :size="'sm'"
                    :buttonClass="'btn-light border'"
                    :inputClass="'text-center'"
                    v-model="ocupantes.ninos3"
                ></input-spinner>
            </div>
            <section v-if="errored">
                <b-alert show variant="danger">
                    <p class="  mt-1 p-3">
                        {{$t('validation.error_500')}}
                    </p>
                </b-alert>
            </section>
            <section v-else>
                <div class="alert mb-2 border-top border-bottom rounded-0 px-0"
                     v-if="tarifa">
                    <div v-if="loading" class="text-center">
                        <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                    </div>
                    <div v-else>
                        <div class="row">
                            <div class="col-3 font-weight-bold font-18">
                                Total:
                            </div>
                            <div class="col pl-0 text-right">
                                <tarifa-precio-formula-component
                                    :cotizacion_resumen="total"
                                    :moneda_seleccionada="moneda_seleccionada">
                                </tarifa-precio-formula-component>
                            </div>
                        </div>

                    </div>
                </div>
                <b-button @click="agregarCarrito()" block size="sm" variant="primary"
                          :disabled="loading">{{$t('disponibilidad.aniadir')}}
                </b-button>
            </section>
        </div>
    </div>

</template>

<script>
    import {agrupadorEvent, carritoEvent} from "../../app";
    import InputSpinner from '../fom-components/InputSpinnerComponent.vue'

    export default {
        components: {
            InputSpinner
        },
        props: {
            popoverId: 0,
            color_cargador: String,
            moneda_seleccionada: Object,
            tipo: Object,
            tarifa: Object,
            formula: Object,
            busqueda: Object,
            configuracion_hospedaje: Object,
        },
        data() {
            return {
                habitaciones: 1,
                popoverShow: false,
                ocupantes: {
                    adultos: this.busqueda.adultos,
                    ninos1: this.busqueda.ninos1,
                    ninos2: this.busqueda.ninos2,
                    ninos3: this.busqueda.ninos3
                },
                total: this.formula,
                tipo_habitacion: this.tipo,
                tarifa_seleccionada: this.tarifa,
                loading: false,
                errored: false,
            }
        },
        mounted() {

        },
        watch: {
            'ocupantes.adultos'(newVal, oldVal) {
                if (this.validarOcupacion() == false) {
                    this.ocupantes.adultos = oldVal;
                    this.$refs.spinnerAdultos.decreaseNumber();
                }
                this.cotizar();
            },
            'ocupantes.ninos1'(newVal, oldVal) {
                if (this.validarOcupacion() == false) {
                    this.ocupantes.ninos1 = oldVal;
                    this.$refs.spinnerNinos1.decreaseNumber();
                }
                this.cotizar();
            },
            'ocupantes.ninos2'(newVal, oldVal) {
                if (this.validarOcupacion() == false) {
                    this.ocupantes.ninos2 = oldVal;
                    this.$refs.spinnerNinos2.decreaseNumber();
                }
                this.cotizar();
            },
            'ocupantes.ninos3'(newVal, oldVal) {
                if (this.validarOcupacion() == false) {
                    this.ocupantes.ninos3 = oldVal;
                    this.$refs.spinnerNinos3.decreaseNumber();
                }
                this.cotizar();
            },
            moneda_seleccionada: function (val) {
                this.moneda_seleccionada = val;
            }
        },
        methods: {
            agregarCarrito() {
                this.loading = true;
                this.errored = false;
                const params = {
                    adultos: this.ocupantes.adultos,
                    ninos1: this.ocupantes.ninos1,
                    ninos2: this.ocupantes.ninos2,
                    ninos3: this.ocupantes.ninos3,
                    promocode: this.busqueda.promo_code,
                    tipo_habitacion_id: this.tipo_habitacion.id,
                    tarifa_id: this.tarifa_seleccionada.id
                };
                axios.post(window.url_carrito_agregar, params)
                    .then(response => {
                        carritoEvent.$emit('agregarElementoCarrito', response.data.elemento);
                        this.reset();
                        this.cerrarPopover();
                        this.errored = false;
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false);
            },
            cerrarPopover() {
                this.$emit('closemodal', false)
            },
            onShow() {
                // This is called just before the popover is shown
                // Reset our popover form variables
                //this.reset();
            },
            onShown() {
                // Called just after the popover has been shown
                // Transfer focus to the first input
            },
            onHidden() {
                // Called just after the popover has finished hiding
                // Bring focus back to the button
                this.focusRef(this.$refs.button);
            },
            validarOcupacion() {
                let totalOcupantes = this.ocupantes.adultos + this.ocupantes.ninos1 + this.ocupantes.ninos2 + this.ocupantes.ninos3;
                if (totalOcupantes > this.tipo_habitacion.ocupacion) {
                    this.loading = false;
                    this.mostrarMensaje('Ocupación', 'Ya se ha alcanzado la ocupación máxima', 'danger');
                    return false;
                }
                return true;
            },

            cotizar(emitEvent = false) {
                this.loading = true;
                this.errored = false;
               const params = {
                    adultos: this.ocupantes.adultos,
                    ninos1: this.ocupantes.ninos1,
                    ninos2: this.ocupantes.ninos2,
                    ninos3: this.ocupantes.ninos3,
                    promocode: this.busqueda.promo_code,
                    tipo_habitacion_id: this.tipo_habitacion.id,
                    tarifa_id: this.tarifa_seleccionada.id
                };
                axios.post(window.url_cotizacion_simple, params)
                    .then(response => {
                        this.total = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                        this.errored = true
                    })
                    .finally(() => this.loading = false);
            },
            mostrarMensaje(title, message, variant = null) {
                this.$toasted.show(message)
                // this.$bvToast.toast(message, {
                //     title: title,
                //     variant: variant,
                //     solid: true
                // })
            },
            reset() {
                this.ocupantes = {
                    adultos: this.busqueda.adultos,
                    ninos1: this.busqueda.ninos1,
                    ninos2: this.busqueda.ninos2,
                    ninos3: this.busqueda.ninos3
                }
                this.habitaciones = 1;
                this.habitacion = null;
                this.loading = false;
                this.errored = false;
                this.$emit('closemodal', false)
            }
        },
        computed: {
        }
    }
</script>
<style scoped>
    .form-group {
        display: flex;
        align-items: center;
    }

    .form-group label {
        margin-bottom: 0;
    }
</style>
