<template>
    <div v-if="existe_disponibilidad" class="sticky-top">
        <div class="card rounded-0 border-0 shadow-sm">
            <div class="card-header bg-white py-2">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">
                            <span v-if="por_tarifa">{{$t('disponibilidad.tarifas_dispo')}}</span>
                            <span v-else>{{$t('disponibilidad.habitacion_dispo')}}</span>:
                            <span class="badge text-white bg-acento">{{disponibles}}</span>
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown float-right">
                            <button class="btn btn-default form-control dropdown-toggle text-capitalize" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <!-- <i class="fa color-acento"
                                   v-bind:class="{'fa-dollar-sign': por_tarifa,  'fa-home': !por_tarifa}"
                                >
                                </i>-->
                                <span v-if="por_tarifa">{{$t('disponibilidad.tarifas')}}</span>
                                <span v-else>{{$t('disponibilidad.habitaciones')}}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow" id="opcionesAgrupar" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item cursor-pointer active" id="habitaciones"
                                   v-on:click="setAgrupar(0)">
<!--                                    <i class="fa fa-home"></i>-->
                                    {{$t('disponibilidad.habitaciones')}}
                                </a>
                                <a class="dropdown-item cursor-pointer" id="tarifas" v-on:click="setAgrupar(1)">
<!--                                    <i class="fa fa-dollar-sign"></i>-->
                                    {{$t('disponibilidad.tarifas')}}
                                </a>
                            </div>
                        </div>
                        <h5 class="float-right mt-1 mb-0">{{$t('disponibilidad.ver_resultados')}}:&nbsp;</h5>
                    </div>
                </div>
            </div>
        </div>
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
                $("#tarifas").removeClass('active');
                $("#habitaciones").removeClass('active');
                this.por_tarifa = tipo;
                if (tipo) {
                    $("#tarifas").addClass('active');
                } else {
                    $("#habitaciones").addClass('active');
                }
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
