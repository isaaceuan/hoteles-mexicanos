<template>
    <div>
        <div class="modal fade" id="modalAvisoAjusteDisponibilidad"  role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title ml-auto" id="modalCarritoDetalleComplementoLabel">
                            {{$t('disponibilidad.aviso_disponibilidad')}}
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-if="habitaciones_ajustadas">
                            <div class="col-md-12">
                                <P class="font-14" v-if="habitaciones_ajustadas.length == 0">
                                    {{$t('disponibilidad.aviso_ajuste_cero_disponibilidad')}}
                                </P>
                                <P class="font-14" v-else>

                                    {{$t('disponibilidad.aviso_ajuste_parte1')}} <b>{{habitaciones_ajustadas.join(', ')}}</b>, {{$t('disponibilidad.aviso_ajuste_parte2')}}
                                </P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none" data-toggle="modal" data-target="#modalAvisoAjusteDisponibilidad" id="showModalAvisoAjusteDisponibilidad"></div>
    </div>
</template>
<script>
    import {carritoEvent} from "../../app";
    // import $ from 'jquery'
    export default {
        data() {
            return{
                habitaciones_ajustadas: []
            }
        },
        mounted() {
            carritoEvent.$on('showAvisoAjusteEvent', (obj) => {
                this.habitaciones_ajustadas = obj.habitacionesAjustadas;
                $('#showModalAvisoAjusteDisponibilidad').click();
            });
        },
        methods:{

        },
    }
</script>
<style scoped>
</style>
