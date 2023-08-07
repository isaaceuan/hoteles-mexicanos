<template>
	<div class="modal fade" id="modalDetalleComplemento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title ml-auto" id="exampleModalLabel">{{complemento.nombre}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body row">
					<div class="col-md-5">
						<img class="d-block w-100 shadow"
                             v-if="complemento.imagen_crop"
                             v-bind:src="complemento.imagen_crop">
                        <img class="d-block w-100 shadow"
                             v-else
                             src="/imagenes/no-image-complement.jpg">
					</div>
					 <div class="col-md-7 mt-3">
                        <p class="font-14 mb-0">
                                                <span
                                                    v-if="complemento.modo_cobro == 'estancia' || complemento.modo_cobro == 'noche' && monedaSeleccionada">
                                                     {{$t('complemento.precio')}}:
                                                    <span class="text-danger">
                                                        {{ complemento.precio_unitario |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </span>
                                                </span>
                            <span
                                v-if="complemento.modo_cobro == 'persona' || complemento.modo_cobro == 'persona_noche' && monedaSeleccionada">
                                                    <template v-if="complemento.aplica_adultos">
                                                        {{$t('complemento.adultos')}}:
                                                        <span class="text-danger">
                                                            {{ complemento.precio_adultos |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                    <template v-if="complemento.aplica_ninos1 && monedaSeleccionada">
                                                        <br>
                                                        {{$t('complemento.ninos')}} ({{propiedad.ninos_min_1}}-{{propiedad.ninos_max_1}} {{$t('complemento.anios')}}):
                                                        <span class="text-danger">
                                                            {{ complemento.precio_ninos1 |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                    <template v-if="complemento.aplica_ninos2 && monedaSeleccionada">
                                                        <br>
                                                        {{$t('complemento.ninos')}} ({{propiedad.ninos_min_2}}-{{propiedad.ninos_max_2}} {{$t('complemento.anios')}}):
                                                        <span class="text-danger">
                                                            {{ complemento.precio_ninos2 |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                    <template v-if="complemento.aplica_ninos3 && monedaSeleccionada">
                                                        <br>
                                                        {{$t('complemento.ninos')}} ({{propiedad.ninos_min_3}}-{{propiedad.ninos_max_3}} {{$t('complemento.anios')}}):
                                                        <span class="text-danger">
                                                            {{ complemento.precio_ninos3 |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                                                            monedaSeleccionada.id, ',', 2,
                                                            '.', 'front', true
                                                            ) }}
                                                        </span>
                                                    </template>
                                                </span>
                        </p>
                        <p class="mb-0">
                            <span v-if="complemento.modo_cobro == 'persona_noche'">({{$t('complemento.persona_noche')}})</span>
                            <span
                                v-if="complemento.modo_cobro == 'persona'">({{$t('complemento.persona')}})</span>
                            <span
                                v-if="complemento.modo_cobro == 'estancia' || complemento.modo_cobro == 'noche'">({{$t('complemento.por_'+complemento.modo_cobro)}}) </span><br>
                        </p>
                        <p class="mt-2" :inner-html.prop="complemento.descripcion"></p>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary bg-acento" data-dismiss="modal">
						{{$t('disponibilidad.cerrar')}}
					</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props:{
			complemento: Object ,
            monedaSeleccionada: Object,
            propiedad: Object,
		}
	}
</script>
<style scoped>
</style>
