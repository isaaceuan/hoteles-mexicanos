<template>
    <div class="rate-price">
        <h5 class="mb-0 font-16" v-if="moneda_seleccionada">
            <small class="linethrough"
                   v-if="cotizacion_resumen.con_descuento">
                {{ cotizacion_resumen.total_sin_des |
                convertirMoneda(moneda_seleccionada.tipo_cambiario) | currency(
                moneda_seleccionada.id , ',', 2,
                '.', 'front', true
                ) }}
            </small><br v-if="cotizacion_resumen.con_descuento">
            {{ cotizacion_resumen.total_con_des |
            convertirMoneda(moneda_seleccionada.tipo_cambiario) | currency(
            moneda_seleccionada.id , ',', 2,
            '.', 'front', true
            ) }}
        </h5>
        <template v-if="!solo_precio">
            <p class="mb-0 font-weight-bold font-12">
                <span class="font-12" v-if="formula===total_con_impuesto || formula===total_sin_impuesto">Total {{$t('disponibilidad.por')}}</span>
                <span class="font-12" v-else>{{$t('disponibilidad.promedio_noche')}}</span>
                {{cotizacion_resumen.noches}}
                {{$t('disponibilidad.noche')}}<span class="font-12"
                                                    v-if="cotizacion_resumen.noches>1">s</span>
            </p>
            <p class="mb-0 font-weight-bold font-12">
                {{cotizacion_resumen.adultos}} {{$t('disponibilidad.adulto')}}<span class="font-12"
                                                                                    v-if="cotizacion_resumen.adultos>1">s</span>
                <span class="font-12" v-if="cotizacion_resumen.ninos>0">
                                            , {{cotizacion_resumen.ninos}}
                                            {{$t('disponibilidad.ninos')}}<span class="font-12"
                                                                                v-if="cotizacion_resumen.ninos>1">s</span>
                                        </span>
            </p>
            <span class="font-12" v-if="formula===total_con_impuesto">{{$t('disponibilidad.impuestos_cargos_incluidos')}}</span>
            <span class="font-12" v-if="formula===promedio_con_impuesto">{{$t('disponibilidad.impuestos_cargos_incluidos')}}</span>
            <span class="font-12" v-if="formula===total_sin_impuesto">+ {{$t('disponibilidad.impuestos_cargos')}}</span>
            <span class="font-12"
                  v-if="formula===promedio_sin_impuesto">+ {{$t('disponibilidad.impuestos_cargos')}}</span>
        </template>
    </div>
</template>
<script>
    // 'prom-imp', 'prom+imp', 'total-imp', 'total+imp'
    export default {
        props: {
            cotizacion_resumen: Object,
            moneda_seleccionada: Object,
            solo_precio: false
        },
        data() {
            return {
                formula: this.cotizacion_resumen.formula,
                promedio_sin_impuesto: 'prom-imp',
                promedio_con_impuesto: 'prom+imp',
                total_sin_impuesto: 'total-imp',
                total_con_impuesto: 'total+imp',
            }

        },
        methods: {
        },
        watch: {
            moneda_seleccionada: function (val) {
                this.moneda_seleccionada = val;
            }
        }
    }
</script>
<style scoped>
</style>
