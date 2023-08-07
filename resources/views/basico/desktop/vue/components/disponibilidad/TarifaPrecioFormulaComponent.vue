<template>
    <div class="">
        <h5 class="mb-0" v-if="moneda_seleccionada">
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
        <p class="mb-0 font-weight-bold">
            <span
                v-if="formula===total_con_impuesto || formula===total_sin_impuesto">Total {{$t('disponibilidad.por')}} {{cotizacion_resumen.noches}}</span>
            <span v-else>{{$t('disponibilidad.promedio_noche')}}</span>
            {{$t('disponibilidad.noche')}}<span v-if="cotizacion_resumen.noches>1 && formula===total_con_impuesto || formula===total_sin_impuesto">s</span>
        </p>
        <p class="mb-0 font-weight-bold">
            {{cotizacion_resumen.adultos}} {{$t('disponibilidad.adulto')}}<span
            v-if="cotizacion_resumen.adultos>1">s</span>
            <span v-if="cotizacion_resumen.ninos>0">
                                            , {{cotizacion_resumen.ninos}}
                                            {{$t('disponibilidad.ninos')}}<span
                v-if="cotizacion_resumen.ninos>1">s</span>
                                        </span>
        </p>
        <span v-if="formula===total_con_impuesto">{{$t('disponibilidad.impuestos_cargos_incluidos')}}</span>
        <span v-if="formula===promedio_con_impuesto">{{$t('disponibilidad.impuestos_cargos_incluidos')}}</span>
        <span v-if="formula===total_sin_impuesto">+ {{$t('disponibilidad.impuestos_cargos')}}</span>
        <span v-if="formula===promedio_sin_impuesto">+ {{$t('disponibilidad.impuestos_cargos')}}</span>
    </div>
</template>
<script>
    // 'prom-imp', 'prom+imp', 'total-imp', 'total+imp'
    export default {
        props: {
            cotizacion_resumen: Object,
            moneda_seleccionada: Object
        },
        data() {
            return {
                formula: this.cotizacion_resumen.formula,
                promedio_sin_impuesto: 'prom-imp',
                promedio_con_impuesto: 'prom+imp',
                total_sin_impuesto: 'total-imp',
                total_con_impuesto: 'total+imp'
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
