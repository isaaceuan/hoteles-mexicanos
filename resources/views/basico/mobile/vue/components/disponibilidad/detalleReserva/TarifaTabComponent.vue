<template>
	<div v-if="tarifa" class="m-3">
        <h5 class="font-weight-bold">
           {{tarifa.tarifa.nombre}}
        </h5>
        <p v-if="tarifa.tarifa.con_plan_alimento">
            <i class="fa fa-coffee mr-2"></i><strong>{{$t('carrito.plan_alimentos')}}:</strong>
            {{tarifa.tarifa.plan_alimento.nombre}}
        </p>
        <div v-html="tarifa.tarifa.descripcion"></div>
        <div class="my-2" v-if="tarifa.regla_cancelacion">
            <i class="fa fa-check mr-2"></i><strong>{{$t('carrito.reglas_cancel')}}</strong>
            <template
                v-if="tarifa.regla_cancelacion.es_reembolsable && tarifa.regla_cancelacion.restricciones.length>0">
                <p class="mb-0 ml-3 pl-1"
                   v-for="cancelacion in tarifa.regla_cancelacion.restricciones">
                    {{$t('disponibilidad.reembolso_del',{tasa: cancelacion.tasa})}} <span
                    class="text-capitalize">{{cancelacion.fecha_limite |
                            fechaDia}}</span>
                </p>
            </template>
            <template v-else>
                <p class="mb-0 ml-3 pl-1">
                    {{$t('disponibilidad.no_reembolsable')}}
                </p>
            </template>
        </div>
        <div v-if="tarifa.regla_modificacion" class="my-2">
            <i class="fa fa-pen mr-2"></i><strong>{{$t('carrito.reglas_modif')}}</strong>
            <template
                v-if="tarifa.regla_modificacion.dias_anticipacion > 0
                        || tarifa.regla_modificacion.modo === 'libre'
                        || tarifa.regla_modificacion.modo === 'limitado'">
                <p class="mb-0 ml-3 pl-1">{{$t('disponibilidad.modificar_reserva')}}
                    <span class="text-capitalize">{{tarifa.regla_modificacion.fecha_limite | fechaDia}}</span>
                </p>
            </template>
            <template v-else>
                <p class="mb-0 ml-3 pl-1">{{$t('disponibilidad.no_modificar_reserva')}}</p>
            </template>
        </div>
        <template
            v-if="tarifa.complementos && tarifa.complementos.length > 0">
            <i class="fa fa-shopping-bag mr-2"></i><strong>{{$t('carrito.complementos_incluidos')}}</strong>
            <ul class="mt-2">
                <li v-for="c in tarifa.complementos">
                    {{c.nombre}}
                </li>
            </ul>
        </template>
        <template
            v-if="tarifa.promociones && tarifa.promociones.length > 0">
            <i class="fa fa-tag mr-2"></i><strong>{{$t('disponibilidad.promociones')}}</strong>
            <ul class="mt-2">
                <li v-for="p in tarifa.promociones">
                  <b>{{p.nombre}}</b>
                    <p class="mb-1">{{p.descripcion}}</p> 
                </li>
            </ul>
        </template>
	</div>
</template>
<script>
	export default {
		props:{
			tarifa: Object,
		}
	}
</script>
<style scoped>
</style>
