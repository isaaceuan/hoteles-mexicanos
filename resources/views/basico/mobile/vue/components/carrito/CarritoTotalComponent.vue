<template>
    <div v-if="loading_add" class="text-center">
        <i class="fas fa-circle-notch fa-spin fa-2x"></i>
    </div>
    <span v-else>
        {{ total |
        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
        monedaSeleccionada.id , ',', 2,
        '.', 'front', true
        ) }}
        <span class="ml-1 fa fa-caret-down" v-if="mostrarIcono"></span>
    </span>
</template>

<script>

    import {cambiarMonedaEvent, totalCarritoEvent} from '../../app';

    export default {
        props: {
            moneda_seleccionada: Object,
            total_carrito: {
                type: Number,
                default: 0.00
            },
            mostrar_icono: {
                type: Number,
                default: 1
            },
        },
        data: function () {
            return {
                monedaSeleccionada: this.moneda_seleccionada,
                total: this.total_carrito,
                mostrarIcono: this.mostrar_icono,
                loading_add: false,
            };
        },
        mounted() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
            totalCarritoEvent.$on('totalCarritoEvent', obj => {
                this.total = obj;
            });
            totalCarritoEvent.$on('cargadorCarritoEvent', obj => {
                this.loading_add = !!obj;
            });
        }
    }

</script>

<style scoped>

</style>
