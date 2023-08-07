<template>
    <div v-if="tarifa">
        <div class="modal fade" id="modalDetalleTarifa" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"
                            v-html="tarifa.tarifa.nombre">
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="tarifa.tarifa.con_plan_alimento">
                            <i class="fa fa-coffee mr-2"></i><strong>{{$t('carrito.plan_alimentos')}}:</strong>
                            {{tarifa.tarifa.plan_alimento.nombre}}}
                        </p>
                        <div v-html="tarifa.tarifa.descripcion"></div>
                       <template
                            v-if="tarifa.tipo_habitacion_economica.complementos && tarifa.tipo_habitacion_economica.complementos.length > 0">
                            <i class="fa fa-shopping-bag mr-2"></i><strong>{{$t('carrito.complementos_incluidos')}}</strong>
                            <ul class="mt-2">
                                <li v-for="c in tarifa.tipo_habitacion_economica.complementos">
                                    {{c.nombre}}
                                </li>
                            </ul>
                        </template>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary bg-acento" data-dismiss="modal">
                            {{$t('disponibilidad.cerrar')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            tarifa: Object,
        },
        methods: {}
    }
</script>
<style scoped>
</style>
