<template>
    <div>
        <div class="modal fade" id="modalDetalleHabitacion" role="dialog">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            v-html="habitacion.nombre">
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div id="carouselHabitacion" class="carousel carousel-thumbnails slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <div class="carousel-item"
                                             v-for="(imagen, idx) in habitacion.imagenes"
                                             :class="{active: idx == 0}">
                                            <img class="d-block w-100"
                                                 :src="imagen.src"
                                                 :alt="imagen.alt">
                                        </div>
                                    </div>
                                    <!-- Controls -->
                                    <a class="carousel-control-prev" href="#carouselHabitacion" role="button"
                                       data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselHabitacion" role="button"
                                       data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselHabitacion"
                                            v-for="(imagen, idx) in habitacion.imagenes"
                                            :class="{active: idx == 0}"
                                            :data-slide-to="idx">
                                            <img class="w-100"
                                                 :src="imagen.src">
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <span class="badge p-0 font-12">
                                    <i class="fa fa-user mr-1"></i>
                                    <span class="font-weight-normal">{{$t('disponibilidad.max_ocupantes')}}:</span>
                                    <b>{{habitacion.ocupacion}}</b>
                                </span>
                                </div>
                                <p class="font-14"
                                   :inner-html.prop="habitacion.descripcion">
                                </p>
                            </div>
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
    </div>
</template>
<script>
    export default {
        props: {
            habitacion: '',
        },
        methods: {}
    }
</script>
