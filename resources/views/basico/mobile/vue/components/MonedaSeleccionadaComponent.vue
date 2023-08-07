<template>
    <div>
        {{this.monedaSeleccionada.id}} - {{$t('header.moneda')}}
    </div>
</template>

<script>

    import {cambiarMonedaEvent} from '../app';

    export default {
        props: {
            moneda_seleccionada: Object
        },
        data: function () {
            return {
                monedaSeleccionada: this.moneda_seleccionada
            };
        },
        mounted() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
                $('#collapseMonedas').modal('hide');
            });
        }
    }

</script>

<style scoped>

</style>
