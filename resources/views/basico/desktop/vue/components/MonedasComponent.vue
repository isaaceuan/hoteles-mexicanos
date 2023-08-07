<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            {{monedaSeleccionada.id}} - {{$t('header.moneda')}}
        </a>
        <div class="dropdown-menu dropdown-menu-right z-index1021 shadow" aria-labelledby="navbarDropdown">
            <a class="dropdown-item cursor-pointer"
               v-bind:class="{ active: monedaSeleccionada.id==key }"
               v-for="(value, key) in monedas"
               v-on:click="setMoneda(key, value.tipo_cambio)">{{key}}
                {{value.nombre}}</a>
        </div>
    </li>
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
