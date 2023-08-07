<template>
    <div v-if="popoverId">
        <b-popover
            :target="popoverId"
            triggers="click"
            :show.sync="popoverShow"
            placement="bottom"
            container="body"
            ref="popover"
        >
            <template v-slot:title>
                <b-button @click="onClose" class="close px-1 ml-1" aria-label="Close">
                    <span class="d-inline-block" aria-hidden="true">&times;</span>
                </b-button>
                {{$t('disponibilidad.reservar_habitacion')}}
            </template>

            <div>
                <div class="form-group mb-2">
                    <label class="col-7 p-0">{{$t('disponibilidad.adulto')}}s</label>
                    <input-spinner
                        ref="spinnerAdultos"
                        :integerOnly="true"
                        :min="1"
                        :max="hospedaje.adultos"
                        :step="1"
                        :size="'sm'"
                        :buttonClass="'btn-light border'"
                        :inputClass="'text-center'"
                        v-model="ocupantes.adultos"
                    ></input-spinner>
                </div>
                <div class="form-group mb-2" v-if="hospedaje.ninos && hospedaje.tiene_ninos_1">
                    <label class="col-7 p-0">{{$t('disponibilidad.ninos')}} ({{hospedaje.ninos_min_1}} -
                        {{hospedaje.ninos_max_1}})</label>
                    <input-spinner
                        ref="spinnerNinos1"
                        :integerOnly="true"
                        :min="0"
                        :max="(hospedaje.adultos - 1)"
                        :step="1"
                        :size="'sm'"
                        :buttonClass="'btn-light border'"
                        :inputClass="'text-center'"
                        v-model="ocupantes.ninos1"
                    ></input-spinner>
                </div>
                <div class="form-group mb-2" v-if="hospedaje.ninos && hospedaje.tiene_ninos_2">
                    <label class="col-7 p-0">{{$t('disponibilidad.ninos')}} ({{hospedaje.ninos_min_2}} -
                        {{hospedaje.ninos_max_2}})</label>
                    <input-spinner
                        ref="spinnerNinos2"
                        :integerOnly="true"
                        :min="0"
                        :max="(hospedaje.adultos - 1)"
                        :step="1"
                        :size="'sm'"
                        :buttonClass="'btn-light border'"
                        :inputClass="'text-center'"
                        v-model="ocupantes.ninos2"
                    ></input-spinner>
                </div>
                <div class="form-group mb-2" v-if="hospedaje.ninos && hospedaje.tiene_ninos_3">
                    <label class="col-7 p-0">{{$t('disponibilidad.ninos')}} ({{hospedaje.ninos_min_3}} -
                        {{hospedaje.ninos_max_3}})</label>
                    <input-spinner
                        ref="spinnerNinos3"
                        :integerOnly="true"
                        :min="0"
                        :max="(hospedaje.adultos - 1)"
                        :step="1"
                        :size="'sm'"
                        :buttonClass="'btn-light border'"
                        :inputClass="'text-center'"
                        v-model="ocupantes.ninos3"
                    ></input-spinner>
                </div>
                <div class="form-group mb-2 font-weight-bold">
                    <label class="col-7 p-0">{{$t('disponibilidad.habitaciones')}}</label>
                    <input-spinner
                        ref="spinnerHabitaciones"
                        :integerOnly="true"
                        :min="0"
                        :max="hospedaje.disponibles"
                        :step="1"
                        :size="'sm'"
                        :buttonClass="'btn-primary'"
                        :inputClass="'text-center'"
                        v-model="habitaciones"
                    ></input-spinner>
                </div>
                <section v-if="errored">
                    <b-alert show variant="danger">
                        <p class="  mt-1 p-3 text-center ">
                            {{$t('validation.error_500')}}
                        </p>
                    </b-alert>
                </section>
                <section v-else>
                    <b-alert show class="alert mb-2 border-top border-bottom rounded-0 px-0" variant="light"
                             v-if="cotizacion">
                        <div v-if="loading" class="text-center">
                            <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                        </div>
                        <div v-else>
                            <p class="text-right m-0" v-if="moneda_seleccionada">
                                <strong>{{$t('disponibilidad.total')}}: {{ total_cotizado |
                                    convertirMoneda(moneda_seleccionada.tipo_cambiario) | currency(
                                    moneda_seleccionada.id, ',', 2,
                                    '.', 'front', true
                                    ) }} {{cotizacion.moneda}}</strong> <br>
                                <!--<small class="text-right">Más impuestos</small>-->
                            </p>
                        </div>
                    </b-alert>
                    <b-button @click="onOk" block size="sm" variant="primary"
                              :disabled="loading || (habitaciones == 0)">{{$t('disponibilidad.reservar')}}
                    </b-button>
                </section>
            </div>
        </b-popover>
    </div>
</template>

<script>
    import {carritoEvent} from "../../app";
    import InputSpinner from '../fom-components/InputSpinnerComponent.vue'

    export default {
        components: {
            InputSpinner
        },
        props: {
            popoverId: 0,
            cotizacion: Object,
            hospedaje: Object,
            color_cargador: String,
            moneda_seleccionada: Object,
        },
        data() {
            return {
                habitaciones: 1,
                popoverShow: false,
                ocupantes: {
                    adultos: 2,
                    ninos1: 0,
                    ninos2: 0,
                    ninos3: 0
                },
                total: this.cotizacion.total,
                habitacion: null,
                loading: false,
                errored: false,
            }
        },
        mounted() {
            carritoEvent.$on('closePopover', () => {
                this.popoverShow = false;
            });
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
            onClose() {
                this.popoverShow = false;
            },
            onOk() {
                //Mandar a cotizar la habitación
                if (this.habitacion != null) {
                    carritoEvent.$emit('addRoomEvent', {
                        habitacion: this.habitacion,
                        total_habitaciones: this.habitaciones,
                        ocupantes: this.ocupantes,
                        total_cotizacion: this.total_cotizado,
                        moneda: this.cotizacion.moneda
                    });
                    this.reset();
                } else {
                    this.cotizar(true);
                }

                this.onClose();
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
                if (totalOcupantes > this.hospedaje.ocupacion) {
                    this.mostrarMensaje('Ocupación', 'Ya se ha alcanzado la ocupación máxima', 'danger');
                    return false;
                }
                return true;
            },

            cotizar(emitEvent = false) {
                this.loading = true;
                this.errored = false;
                const params = {
                    fecha_entrada: this.hospedaje.fecha_entrada,
                    noches: this.hospedaje.noches,
                    adultos: this.ocupantes.adultos,
                    ninos1: this.ocupantes.ninos1,
                    ninos2: this.ocupantes.ninos2,
                    ninos3: this.ocupantes.ninos3,
                    promocode: this.hospedaje.codigo_promocion,
                    tipo_habitacion_id: this.hospedaje.habitacion_tipo_id,
                    tarifa_id: this.hospedaje.tarifa_id
                };
                this.loading = true;
                axios.post(window.url_get_disponibilidad, params)
                    .then(response => {
                        let data = response.data;
                        this.habitacion = data[0];
                        this.total = this.habitacion.tarifas[0].cotizacion.total;

                        if (emitEvent) {
                            carritoEvent.$emit('addRoomEvent', {
                                habitacion: this.habitacion,
                                total_habitaciones: this.habitaciones,
                                ocupantes: this.ocupantes,
                                total_cotizacion: this.total_cotizado,
                                moneda: this.cotizacion.moneda
                            });
                            this.reset();
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        this.errored = true
                    })
                    .finally(() => this.loading = false);
            },
            mostrarMensaje(title, message, variant = null) {
                this.$bvToast.toast(message, {
                    title: title,
                    variant: variant,
                    solid: true
                })
            },
            reset() {
                this.ocupantes = {
                    adultos: 1,
                    ninos1: 0,
                    ninos2: 0,
                    ninos3: 0
                };
                this.habitaciones = 0;
                this.habitacion = null;
                this.loading = false;
                this.errored = false;
            }

        },
        computed: {
            total_cotizado() {
                return this.total * this.habitaciones;
            }
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
