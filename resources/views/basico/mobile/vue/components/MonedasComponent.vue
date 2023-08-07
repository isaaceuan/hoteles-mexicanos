<template>
    <ul class="list-group list-group-flush">
        <li v-for="(value, key) in monedas">
            <a class="list-group-item list-group-item-action border-bottom"
               v-bind:class="{ active: monedaSeleccionada.id==key }"
               v-on:click="setMoneda(key, value.tipo_cambio)">{{key}}
                {{value.nombre}}</a>
        </li>
    </ul>
</template>

<script>

    import {cambiarMonedaEvent} from '../app';

    export default {
        props: {
            monedas: Object,
            moneda_seleccionada: Object
        },
        data: function () {
            return {
                monedaSeleccionada: this.moneda_seleccionada
            };
        },
        methods: {
            setMoneda(moneda, valor) {
                const monedaObj = {
                    id: moneda,
                    tipo_cambiario: valor
                };
                axios.post(window.url_set_moneda_actual, monedaObj)
                    .then(response => {
                        cambiarMonedaEvent.$emit('cambiarMonedaEvent', monedaObj);
                        this.monedaSeleccionada = monedaObj;
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally();
            }
        }
    }

</script>

<style scoped>

</style>
