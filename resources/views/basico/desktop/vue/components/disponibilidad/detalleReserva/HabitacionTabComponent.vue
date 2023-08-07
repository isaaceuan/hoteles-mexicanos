<template>
    <div v-if="habitacion">
        <div class="row">
            <div class="col-md-6" v-if="habitacion.imagenes.length>0">
                <div id="carouselHabitacionR" class="carousel carousel-thumbnails slide" data-ride="carousel">
                    <div class="carousel-inner shadow">
                        <div class="carousel-item"
                             v-for="(imagen, idx) in habitacion.imagenes"
                             :class="{active: idx == 0}">
                            <img class="d-block w-100"
                                 :src="imagen.src"
                                 :alt="imagen.alt">
                        </div>
                        <a class="carousel-control-prev" href="#carouselHabitacionR" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselHabitacionR" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <ol class="carousel-indicators">
                        <li data-target="#carouselHabitacionR"
                            v-for="(imagen, idx) in habitacion.imagenes"
                            :class="{active: idx == 0}"
                            :data-slide-to="idx">
                            <img class="w-100"
                                 :src="imagen.src">
                        </li>

                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="color-acento mb-1">
                        {{habitacion.nombre}}
                    </h5>
                    <span class="badge p-0 font-12">
                                    <i class="fa fa-user mr-1"></i>
                                    <span class="font-weight-normal">{{$t('disponibilidad.max_ocupantes')}}:</span>
                                    <b>{{habitacion.ocupacion}}</b>
                                </span>
                </div>
                <P class="font-14"
                   :inner-html.prop="habitacion.descripcion">
                </P>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            habitacion: Object,
        }
    }
</script>
<style scoped>
</style>
