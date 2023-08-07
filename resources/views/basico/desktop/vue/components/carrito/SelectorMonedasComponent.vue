<template>
    <div>
        <select class="form-control m-0 my-1 px-1" id="exampleFormControlSelect1"
                v-model="modelMoneda"
                v-on:change="setMoneda()"
        >
            <option :value="`${ key }-${ value.tipo_cambio }`"
                    v-for="(value,key) in monedas">
                {{key}}
            </option>
        </select>

        <div class="d-none">{{this.monedaDefault}}</div>
    </div>
    <!--    <li class="nav-item dropdown">-->
    <!--        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"-->
    <!--           data-toggle="dropdown"-->
    <!--           aria-haspopup="true" aria-expanded="false">-->
    <!--            {{monedaSeleccionada.id}} - Moneda-->
    <!--        </a>-->
    <!--        <div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
    <!--            <a class="dropdown-item"-->
    <!--               v-bind:class="{ active: monedaSeleccionada.id==key }"-->
    <!--               v-for="(value, key) in monedas"-->
    <!--               v-on:click="setMoneda(key, value.tipo_cambio)">{{key}}-->
    <!--                {{value.nombre}}</a>-->
    <!--        </div>-->
    <!--    </li>-->
</template>

<script>

    import {cambiarMonedaEvent} from '../../app';

    export default {
        props: {
            monedas: Object,
            moneda_seleccionada: Object
        },
        data: function () {
            return {
                modelMoneda: null,
                monedaSeleccionada: this.moneda_seleccionada
            };
        },
        methods: {
            setMoneda() {
                var moneda = this.modelMoneda.split('-');
                const monedaObj = {
                    id: moneda[0],
                    tipo_cambiario: moneda[1]
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
        },
        computed: {
            monedaDefault() {
                this.modelMoneda = String(`${this.monedaSeleccionada.id}-${this.monedaSeleccionada.tipo_cambiario}`)
            }
        }

    }

</script>

<style scoped>

</style>
