<template>
    <div class="card" v-if="datos">
        <div class="card-body">
            <div class="alert alert-danger" role="alert"
                 v-if="fecha_entrada !== null && fecha_salida !== null && !valido">
                <p v-html="datos.mensaje_sin_disponibilidad"></p>
                <p v-html="datos.mensaje_sin_disponibilidad_personal"></p>
            </div>
            <div class="alert alert-danger" role="alert"
                 v-if="fecha_entrada === null && fecha_salida === null && !valido">
                <p v-html="datos.mensaje_sin_disponibilidad"></p>
                <p v-html="datos.mensaje_sin_disponibilidad_personal"></p>
            </div>
            <div class="alert alert-info" role="alert"
                 v-if="fecha_entrada !== null && fecha_salida === null && !valido">
                <p v-html="datos.mensaje_fecha_salida"></p>
            </div>
            <div class="alert alert-success" role="alert"
                 v-if="fecha_entrada !== null && fecha_salida !== null && valido">
                <p v-html="datos.mensaje_reservar"></p>
            </div>
            <div id="grid">
                <div class="tabla" v-if="datos.fechas">
                    <!--<div class="fila marcadores">
                        <div class="columna tipo-habitacion">
                            {{fechaEntrada}}
                            <br>
                            {{fechaSalida}}
                            <br>
                            {{noches_calculadas}}
                            <br>
                        </div>
                        <div class="columna ocupacion"></div>
                        <div class="columna dia" v-for="(vfecha, kFecha) in datos.fechas"
                             v-bind:class="estilosContenido(kFecha, false)">
                                <span v-if="estilosContenido(kFecha).esEntrada">
                                      {{$t('calendar.llegada')}}
                                      <br>
                                      <svg class="bi bi-chevron-compact-down" width="1em" height="1em"
                                           viewBox="0 0 16 16" fill="currentColor"
                                           xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M1.553 6.776a.5.5 0 01.67-.223L8 9.44l5.776-2.888a.5.5 0 11.448.894l-6 3a.5.5 0 01-.448 0l-6-3a.5.5 0 01-.223-.67z"
                                          clip-rule="evenodd"/>
                                  </svg>
                                </span>
                            <span v-else-if="estilosContenido(kFecha).esSalida">
                                       {{$t('calendar.salida')}}
                                      <br>
                                      <svg class="bi bi-chevron-compact-down" width="1em" height="1em"
                                           viewBox="0 0 16 16" fill="currentColor"
                                           xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M1.553 6.776a.5.5 0 01.67-.223L8 9.44l5.776-2.888a.5.5 0 11.448.894l-6 3a.5.5 0 01-.448 0l-6-3a.5.5 0 01-.223-.67z"
                                          clip-rule="evenodd"/>
                                  </svg>
                                </span>
                            <span v-else>
                                  &nbsp;
                                </span>
                        </div>
                    </div>-->
                    <div class="fila fechas border-top">
                        <div class="columna tipo-habitacion">
                        </div>
                        <div class="columna ocupacion">
                            <div>
                                <small>{{$t('disponibilidad.maxima')}}</small>
                                <br>
                                <small>{{$t('disponibilidad.ocupacion')}}</small>
                            </div>
                        </div>
                        <div class="columna dia" v-for="(vfecha, kFecha) in datos.fechas">
<!--                             v-on:click="seleccionarDia(kFecha)" v-bind:class="estilosContenido(kFecha)">-->
                            <small>{{vfecha.dia_semana}}</small>
                            <br>
                            {{vfecha.dia}}
                            <br>
                            <small>{{vfecha.mes}}</small>
                        </div>
                    </div>
                    <div class="fila contenido"
                         v-for="(vFechas, kTipoHabitacion) in datos.disponibilidades">
                        <div class="columna tipo-habitacion">
                            <small>{{datos.tipos_habitaciones[kTipoHabitacion].nombre}}</small>
                        </div>
                        <div class="columna ocupacion">
                            <small>
                                {{datos.tipos_habitaciones[kTipoHabitacion].maxima_ocupacion}}
                                <svg class="bi bi-people-fill" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 100-6 3 3 0 000 6zm-5.784 6A2.238 2.238 0 015 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 005 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </small>
                        </div>
                        <div class="columna dia" v-for="(vFecha, kFecha) in vFechas">
<!--                             v-on:click="seleccionarDia(kFecha)" v-bind:class="estilosContenido(kFecha)">-->
                            <div v-if="!vFecha.disponible">
                                <svg class="bi bi-x text-danger" width="1em" height="1em"
                                     viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z"
                                          clip-rule="evenodd"/>
                                    <path fill-rule="evenodd"
                                          d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    // import JQuery from 'jquery';
    //
    // let $ = JQuery;
    export default {
        props: {
            mostrar: false,
            fecha_entrada_set: String,
            fecha_salida_set: String,
            datos: Object,
        },
        data() {
            return {
                noches: 0,
                fecha_entrada: null,
                fecha_salida: null,
                valido: false,
                birthday: ''
            }
        },
        methods: {
            seleccionarDia: function (fecha) {

                this.noches = 0;
                if (this.fecha_entrada !== null && this.fecha_salida !== null) {
                    this.fecha_entrada = null;
                    this.fecha_salida = null;
                }
                if (this.fecha_entrada === null) {
                    this.fecha_entrada = this.convertirStringAFecha(fecha);
                } else {
                    var fechaDate = this.convertirStringAFecha(fecha);
                    if (this.convertirFechaAString(this.fecha_entrada) === fecha) return;
                    if (fechaDate < this.fecha_entrada) {
                        this.fecha_salida = this.fecha_entrada;
                        this.fecha_entrada = fechaDate;
                    } else {
                        this.fecha_salida = fechaDate;
                    }
                }
                // console.log(this.fecha_entrada);
                // console.log(mobiscroll);
                // $('#nights').val(this.noches_calculadas);
                // $('#checkout').mobiscroll("setVal", this.fecha_entrada, true);
                // $('#checkin').mobiscroll("setVal", this.fecha_salida, true);
                this.validarSeleccion();
            },
            estilosContenido: function (fecha, estancia = true) {
                var estilos = {
                    esEntrada: false,
                    esEstancia: false,
                    esSalida: false
                };
                var fechaDate = this.convertirStringAFecha(fecha);

                if (this.fecha_entrada !== null)
                    estilos.esEntrada = fecha === this.convertirFechaAString(this.fecha_entrada);

                if (this.fecha_salida !== null)
                    estilos.esSalida = fecha === this.convertirFechaAString(this.fecha_salida)

                if (estancia && this.fecha_entrada !== null && this.fecha_salida !== null)
                    estilos.esEstancia = fechaDate > this.fecha_entrada && fechaDate < this.fecha_salida

                return estilos;
            },
            aumentarDiasFecha(fecha, dias = 0) {
                var fechaAux = new Date();
                fechaAux.setDate(fecha.getDate() + dias);
                return fechaAux;
            },
            convertirStringAFecha(fecha) {
                var fechaArray = fecha.split("-");
                return new Date(Date.UTC(fechaArray[0], fechaArray[1] - 1, fechaArray[2], 12, 0));
            },
            convertirFechaAString(fecha) {
                return fecha.toISOString().slice(0, 10);
            },
            validarSeleccion: function () {
                this.valido = false;
                if (this.fecha_entrada === null || this.fecha_salida === null) return;
                var finString = this.convertirFechaAString(this.fecha_salida);
                var inicio = this.aumentarDiasFecha(this.fecha_entrada);
                var auxValido = true;
                var fechaCursor = finString;
                do {
                    fechaCursor = this.convertirFechaAString(inicio);
                    var existeDisponibilidad = this.datos.fechas.disponibilidades[fechaCursor];
                    if (existeDisponibilidad === false) {
                        auxValido = false;
                        fechaCursor = finString;
                    }
                    inicio = this.aumentarDiasFecha(inicio, 1);
                } while (finString !== fechaCursor);
                this.valido = auxValido;
            }
        },
        computed: {

            fechaEntrada: function () {
                if (this.fecha_entrada === null) return '';
                return this.convertirFechaAString(this.fecha_entrada);
            },
            fechaSalida: function () {
                if (this.fecha_salida === null) return '';
                return this.convertirFechaAString(this.fecha_salida);
            },
            noches_calculadas: function () {
                // get() {
                //     return this.noches
                // },
                // set() {
                if (this.fecha_salida === null) return 0;
                var diff = this.fecha_salida - this.fecha_entrada;
                return diff / (1000 * 60 * 60 * 24);
                // }
            }
        },
        watch: {
            datos: function (val) {
                this.datos = val;
                // setTimeout(() => {
                //     this.seleccionarDia(this.fecha_entrada_set);
                //     this.seleccionarDia(this.fecha_salida_set);
                // }, 100)

            },
        },
    }
</script>
<style scoped>
    #grid {
        overflow-x: auto;
    }

    .tabla {
        display: grid;
        flex-direction: column;
        min-height: 200px;
    }

    .fila {
        display: flex;
        flex-direction: row;
    }

    .fila.marcadores .ocupacion,
    .fila.marcadores .dia {
        border-top: 1px rgba(0, 0, 0, 0.125) solid;
    }

    .fila.marcadores .tipo-habitacion {
        border-bottom: 1px transparent solid;
        border-right: 1px transparent solid;
    }

    .fila.marcadores .ocupacion {
        border-top: 1px transparent solid;
    }

    .fila.marcadores,
    .fila.fechas {
        justify-content: center;
        text-align: center;
    }

    .fila.fechas .columna:first-child {
        border-left: 1px rgba(0, 0, 0, 0.125) solid;
    }

    .fila.fechas .ocupacion {
        padding-top: 14px;
    }

    .fila.fechas .columna.ocupacion,
    .fila.fechas .columna.dia {
        background: #f8f9fa;
    }

    .fila.contenido {
        justify-content: center;
        text-align: center;
    }

    .fila.contenido .columna:first-child {
        border-left: 1px rgba(0, 0, 0, 0.125) solid;
    }


    .fila.contenido .columna.tipo-habitacion,
    .fila.contenido .columna.ocupacion {
        background: #f8f9fa;
    }

    .columna {
        padding: 6px 4px;
        border-right: 1px rgba(0, 0, 0, 0.125) solid;
        border-bottom: 1px rgba(0, 0, 0, 0.125) solid;
    }

    .columna.tipo-habitacion {
        line-height: 18px;
        text-align: left;
        flex-grow: 1;
        min-width: 160px;
    }

    .columna.ocupacion {
        line-height: 18px;
        min-width: 110px;
    }

    .columna.dia:last-child{
        border-right: 2px rgba(0, 0, 0, 0.125) solid;
    }

    .columna.dia {
        line-height: 18px;
        min-width: 90px;
        background: #fff;
    }

    .columna.dia.esEntrada {
        /*background: rgba(52, 58, 64, 1) !important;*/
        color: #fff;
    }

    .columna.dia.esEstancia {
        /*background: rgba(52, 58, 64, 0.7) !important;*/
        color: #fff;
    }

    .columna.dia.esSalida {
        /*background: rgba(52, 58, 64, 1) !important;*/
        color: #fff;
    }
</style>
