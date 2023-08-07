<template>
    <div v-bind:class="{'row': mostrar_selector}">
        <div class="mr-2" v-if="mostrar_selector">
            <input-spinner
                ref="spinnerCantidadComplemento"
                :integerOnly="true"
                :min="1"
                :value="total_complementos"
                :max="99"
                :step="1"
                :is_disabled="disabled"
                :size="'sm'"
                :buttonClass="'btn-light'"
                :inputClass="'text-center'"
                v-model="cantidad"
            ></input-spinner>
        </div>
        <b-button variant="primary" ref="button"
                  v-show="!checked"
                  :disabled="disabled"
                  v-on:click="agregarComplementoBtn()"
                  :class="'reservar-complemento-'+complemento.id">
            {{$t('complemento.agregar')}}
        </b-button>

        <b-button variant="outline-danger" ref="button"
                  v-show="checked"
                  :class="'btn-outline-danger'"
                  :disabled="disabled"
                  v-on:click="eliminarComplemento()"
                  :id="'btn-remove-'+complemento.id">
            {{$t('complemento.remover')}}
        </b-button>

<!--        <b-form-checkbox-->
<!--            v-if="!disabled"-->
<!--            :id="'chkcomplemento'+complemento_id+'-'+habitacion_id+'-'+habitacion.indice"-->
<!--            :class="'chkcomplemento-'+complemento_id"-->
<!--            v-model="checked"-->
<!--            :disabled="disabled"-->
<!--        >-->
<!--        </b-form-checkbox>-->
        <!--        <div v-if="disabled">-->
        <!--            <i class="fas fa-circle-notch fa-spin fa-lg"></i>-->
        <!--        </div>-->
    </div>
</template>
<script>
    import {carritoEvent, complementoEvent} from "../../app";

    export default {
        props: {
            mostrar_selector: {
                type: Boolean,
                default: false
            },
            is_checked: {
                type: Boolean,
                default: false
            },
            is_disabled: {
                type: Boolean,
                default: false
            },
            total_complementos: {
                type: Number,
                default: 1
            },
            complemento: Object,
            habitacion: Object,
            tarifa: Object,
            entrada: String,
        },
        data() {
            return {
                checked: this.is_checked,
                eliminado_carrito: false,
                disabled: this.is_disabled,
                cantidad: this.habitacion.unidades,
                indice: this.habitacion.indice,
                complemento_id: this.complemento.id,
                habitacion_id: this.habitacion.tipo_habitacion_id,
                tarifa_id: 0,
                mostrar_checkbox: true
            }
        },
        mounted() {
            carritoEvent.$on('removerComplementoCarrito', (datosComplemento) => {
                if (datosComplemento) {
                    if (this.complemento_id === datosComplemento.complemento_id && this.habitacion.indice === datosComplemento.indice) {
                        this.habitacion.seleccionado = false;
                        this.checked = false;
                        this.eliminado_carrito = true;
                    }
                }
            });

            complementoEvent.$on('removerComplementosSeleccionados', (complemento) => {
                if (this.complemento_id === complemento.complemento_id) {
                    this.habitacion.seleccionado = false;
                    this.checked = false;
                }
            });
        },
        methods: {
            cotizarComplemento(cantidad, reducir_cantidad) {
                $('#btn-remove-' + this.complemento.id).prop('disabled', true);
                const data = {
                    complemento_id: this.complemento.id,
                    indice: this.indice,
                    adultos: this.habitacion.adultos,
                    ninos1: this.habitacion.ninos1,
                    ninos2: this.habitacion.ninos2,
                    ninos3: this.habitacion.ninos3,
                    unidades: this.cantidad
                };
                axios.post(window.url_carrito_complemento_agregar, data)
                    .then(response => {
                        this.disabled = false;
                        this.checked = true;
                        complementoEvent.$emit('habilitarBoton');
                        carritoEvent.$emit('agregarComplementoCarrito', data);
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => true);
            },
            agregarComplementoBtn() {
                this.disabled = true;
                if (this.mostrar_selector) {
                    this.cotizarComplemento(this.cantidad, false);
                } else {
                    this.cotizarComplemento(1, false);
                }
            },
            agregarComplemento(cotizacion) {
                const data = {
                    complemento_id: this.complemento.id,
                    adultos: this.habitacion.adultos,
                    ninos1: this.habitacion.ninos1,
                    ninos2: this.habitacion.ninos2,
                    ninos3: this.habitacion.ninos3,
                    unidades: this.cantidad
                };
                axios.post(window.url_carrito_complemento_agregar, data)
                    .then(response => {
                        this.disabled = false;
                        complementoEvent.$emit('habilitarBoton');
                        carritoEvent.$emit('agregarComplementoCarrito', data);
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => true);
            },
            eliminarComplemento() {
                let data = {
                    indice: this.habitacion.indice,
                    complemento_id: this.complemento_id
                };
                axios.post(window.url_carrito_complemento_remover, data)
                    .then(response => {
                        this.disabled = false;
                        complementoEvent.$emit('habilitarBoton');
                        if (!this.eliminado_carrito) {
                            carritoEvent.$emit('removerComplementoCarrito', data);
                        } else {
                            this.eliminado_carrito = false;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => true);
            }
        },
        watch: {
            cantidad(newVal, oldVal) {
                if (this.checked) {
                    complementoEvent.$emit('deshabilitarBoton');
                    if (newVal > oldVal) {
                        let cantidad = newVal - oldVal;
                        // aumentar complemento
                        // for(let n = 1; n <= cantidad; n++){
                        this.cotizarComplemento(cantidad, false);
                        //  }
                    } else {
                        // if (this.showSpinner) {
                        this.cotizarComplemento(this.cantidad, true);
                        // } else {
                        //     // reducir complemento
                        //     this.eliminarComplemento(1);
                        // }
                    }
                }
            },
            checked(newVal, oldVal) {
                complementoEvent.$emit('deshabilitarBoton');
                if (newVal) {
                    this.disabled = true;
                    if (this.mostrar_selector) {
                        this.cotizarComplemento(this.cantidad, false);
                    } else {
                        this.cotizarComplemento(1, false);
                    }
                } else {
                    if (this.mostrar_selector) {
                        // Eliminar el complemento y resetear el control de cantidad
                        this.eliminarComplemento();
                        this.cantidad = 1;
                    } else {
                        this.eliminarComplemento();
                    }
                }
            }
        },
    }
</script>
<style scoped>
</style>
