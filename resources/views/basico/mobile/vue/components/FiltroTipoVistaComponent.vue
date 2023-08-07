<template>
    <div v-if="existe_disponibilidad">
        <ul class="list-group list-group-flush">
            <li class="list-group-item border-0 px-0">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="por_tarifa" value="0"
                           v-model="por_tarifa"
                           id="chkGroupByRooms"
                           v-on:click="setAgrupar(0)"
                    >
                    <label class="custom-control-label"
                           for="chkGroupByRooms">{{$t('disponibilidad.habitaciones')}}</label>
                </div>
            </li>
            <li class="list-group-item border-0 px-0">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="por_tarifa" value="1" id="chkGroupByRates"
                           v-model="por_tarifa"
                           v-on:click="setAgrupar(1)">
                    <label class="custom-control-label" for="chkGroupByRates">{{$t('disponibilidad.tarifas')}}</label>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import {agrupadorEvent, totalEvent} from '../app';

    export default {
        data() {
            return {
                por_tarifa: 0,
                disponibles: 0,
                existe_disponibilidad: false,
            }
        },
        mounted() {
        },
        methods: {
            setAgrupar(tipo) {
                this.disponibles = 0;
                $('#collapseFiltros').modal('hide');
                $("#tarifas").removeClass('active');
                $("#habitaciones").removeClass('active');
                this.por_tarifa = tipo;
                agrupadorEvent.$emit('agrupadorEvent', this.por_tarifa);
            }
        }, created() {
            totalEvent.$on('totalEvent', obj => {
                (obj) ? this.existe_disponibilidad = true : this.existe_disponibilidad = false;
                this.disponibles = obj;
            });
        }
    }
</script>
