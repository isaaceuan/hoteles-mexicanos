<template>
    <div v-if="existe_disponibilidad">
        <div class="card rounded-0 border-0 shadow-sm">
            <div class="card-header bg-white py-0">
                <div class="row align-items-center">
                    <div class="col-10">
                        <h6 class="mb-0">
                            <span v-if="por_tarifa">{{$t('disponibilidad.tarifas_dispo')}}</span>
                            <span v-else>{{$t('disponibilidad.habitacion_dispo')}}</span>:
                            <span class="badge text-white bg-acento">{{disponibles}}</span>
                        </h6>
                    </div>
                    <div class="col-2">
                        <a class="btn" role="button"
                           data-toggle="modal"
                           data-target="#collapseFiltros"
                           aria-expanded="false">
                            <i class="fas fa-filter text-acento"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {agrupadorEvent, carritoEvent, totalEvent} from '../app';

    export default {
        data() {
            return {
                por_tarifa: 0,
                disponibles: 0,
                existe_disponibilidad: false,
            }
        },
        mounted() {
            agrupadorEvent.$on('agrupadorEvent', (value) => {
                this.por_tarifa = value;
            });
        },
        methods: {}, created() {
            totalEvent.$on('totalEvent', obj => {
                (obj) ? this.existe_disponibilidad = true : this.existe_disponibilidad = false;
                this.disponibles = obj;
            });
        }
    }
</script>
