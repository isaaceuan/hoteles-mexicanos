<template>
    <div>
        <div class="modal fade" id="modalCarritoDetalleComplemento" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title ml-auto" id="modalCarritoDetalleComplementoLabel" v-if="complemento">
                            {{complemento.nombre}}
                        </h6>
                        <button type="button" class="close" v-on:click="cerrar()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0 mt-3" v-if="complemento">
                        <ul class="nav nav-tabs text-center menuDetalle nav-fill" id="v-pills-tab-complemento">
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="tab" href="#v-pills-desglose-complemento"
                                   id="v-pills-desglosecomplemento-tab">
                                    <i class="fa fa-dollar-sign fa-2x mb-2"></i>
                                    <p class="mb-0">{{$t('carrito.desglose')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#v-pills-detalle-complemento"
                                   id="v-pills-complemento-tab">
                                    <i class="fa fa-tag fa-2x mb-2"></i>
                                    <p class="mb-0">{{$t('carrito.complemento')}}</p>
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content px-md-0" id="v-pills-tabContentCom">
                            <div class="tab-pane fade show active" id="v-pills-desglose-complemento" role="tabpanel"
                                 aria-labelledby="v-pills-desglose-complemento-tab">
                                <div class="mt-3">
                                    <div class="table-responsive">
                                        <div class="text-center">
                                            <div class="badge badge-primary text-uppercase mb-3">
                                                     <span
                                                         v-if="complemento.modo_cobro == 'persona_noche'">{{$t('complemento.persona_noche')}}</span>
                                                <span v-if="complemento.modo_cobro == 'persona'">{{$t('complemento.persona')}}</span>
                                                <span
                                                    v-if="complemento.modo_cobro == 'estancia' || complemento.modo_cobro == 'noche'">{{$t('carrito.por_'+complemento.modo_cobro)}} </span>

                                            </div>
                                        </div>
                                        <table class="table" id="estancia"
                                               v-if="complemento.modo_cobro == 'estancia'">
                                            <thead>
                                            <tr>
                                                <th class="text-center">{{$t('carrito.noche')}}</th>
                                                <th class="text-center">{{$t('carrito.cantidad')}}</th>
                                                <th class="text-center">{{$t('carrito.precio')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody class="font-12">
                                            <tr class="" v-for="item in complemento.desgloce">
                                                <td class="text-capitalize text-center">
                                                    {{item.fecha | fechaDia}}
                                                </td>
                                                    <td class="text-center" v-for="detalle in item.detalle">
                                                        (x{{detalle.cantidad}})
                                                        {{ detalle.precio |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                        currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ item.total_sin_imp |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                        currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true

                                                        ) }}
                                                    </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th :colspan="2">
                                                </th>
                                                <th class="text-right bg-light border-bottom font-12 px-1">
                                                    Subtotal:<br>
                                                    <span class="font-weight-bold">
                                                                     {{ complemento.total_sin_imp |
                                                                convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                                currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                                </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th :colspan="2" class="border-0">
                                                </th>
                                                <th class="text-right bg-light border-bottom font-12 px-1">
                                                    {{$t('carrito.impuestos')}}:<br>
                                                    <span class="font-weight-bold">
                                                                     {{ complemento.total_imp_pro |
                                                                convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                                currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                                </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th :colspan="2" class="border-0">
                                                </th>
                                                <th class="text-right text-light border-bottom bg-acento font-12 px-1">
                                                    Total:<br>
                                                    <span>
                                                                     {{ complemento.total |
                                                                convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                                currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                            </span>
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                        <table class="table" id="persona_noche"
                                               v-if="complemento.modo_cobro == 'persona_noche' ||
                                                       complemento.modo_cobro == 'persona' ||
                                                       complemento.modo_cobro == 'noche'">
                                            <thead>
                                            <tr>
                                                <th class="text-center">{{$t('carrito.noche')}}</th>
                                                <th class="text-center"
                                                    v-for="titulo in complemento.encabezado">
                                                    <span v-if="titulo==='adulto'" class="text-capitalize">{{$t('carrito.adulto')}}</span>
                                                    <span
                                                        v-else-if="titulo==='unidad'">{{$t('carrito.cantidad')}}</span>
                                                    <span v-else>{{$t('carrito.ninos')}}</span>
                                                </th>
                                                <th class="text-center">{{$t('carrito.precio')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody class="font-12">
                                            <tr class="" v-for="item in complemento.desgloce">
                                                <td class="text-capitalize text-center">
                                                    {{item.fecha | fechaDia}}
                                                </td>
                                                <td v-for="detalle in item.detalle">
                                                    <div class="text-center">
                                                        (x{{detalle.cantidad}})
                                                        {{ detalle.precio |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                        currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-right">
                                                        {{ item.total_sin_imp |
                                                        convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                        currency(
                                                        monedaSeleccionada.id, ',', 2,
                                                        '.', 'front', true
                                                        ) }}
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th :colspan="1 + complemento.encabezado.length">
                                                </th>
                                                <th class="text-right bg-light border-bottom font-12 px-1">
                                                    Subtotal:<br>
                                                    <span class="font-weight-bold">
                                                                     {{ complemento.total_sin_imp |
                                                                convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                                currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                                </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th :colspan="1 + complemento.encabezado.length"
                                                    class="border-0">
                                                </th>
                                                <th class="text-right bg-light border-bottom font-12 px-1">
                                                    {{$t('carrito.impuestos')}}:<br>
                                                    <span class="font-weight-bold">
                                                                     {{ complemento.total_imp_pro |
                                                                convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                                currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                                </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th :colspan="1 + complemento.encabezado.length"
                                                    class="border-0">
                                                </th>
                                                <th class="text-right text-light border-bottom bg-acento font-12 px-1">
                                                    Total:<br>
                                                    <span>
                                                                     {{ complemento.total |
                                                                convertirMoneda(monedaSeleccionada.tipo_cambiario) |
                                                                currency(
                                                                monedaSeleccionada.id, ',', 2,
                                                                '.', 'front', true
                                                                ) }}
                                                                </span>
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-detalle-complemento" role="tabpanel"
                                 aria-labelledby="v-pills-detalle-complemento">
                                <div class="container-fluid mt-3">
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <img :src="complemento.imagen_crop" class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <h5 class="mt-2">{{complemento.nombre}}</h5>
                                            <div class="text-justify mt-2 ">
                                                <p class="text-justify"
                                                   :inner-html.prop="complemento.descripcion">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="">
                            <div class="btn-details text-center font-12">
                                {{fecha_entrada}}<br>
                                <b>{{$t('carrito.llegada')}}</b>
                            </div>
                        </div>
                        <div class="pl-2 border-left">
                            <div class="btn-details text-center font-12">
                                {{fecha_salida}}<br>
                                <b>{{$t('carrito.salida')}}</b>
                            </div>
                        </div>
                        <div class="pl-2 border-left">
                            <div class="btn-details text-center font-12">
                                <i class="fa fa-bed color-acento"></i>
                                <span class="numb">
                           {{noches}}<br>{{$t('carrito.noche')}}<span v-if="noches>1">s</span>
                        </span>
                            </div>
                        </div>
                        <div class=" text-md-right">
                            <button type="button" class="btn btn-secondary bg-acento" v-on:click="cerrar()">
                                {{$t('carrito.cerrar')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {carritoEvent, cambiarMonedaEvent} from "../../app";

    export default {
        props: {
            step: String,
            fecha_entrada: String,
            fecha_salida: String,
            noches: Number,
            moneda_seleccionada: Object,
        },
        data() {
            return {
                complemento: null,
                current_step: this.step,
                monedaSeleccionada: this.moneda_seleccionada,
            }
        },
        created() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
        },
        mounted() {
            $('#v-pills-tab-complemento #v-pills-desglosecomplemento-tab').addClass('active');
            $('#v-pills-tabContentCom #v-pills-desglose-complemento').addClass('show active');
            carritoEvent.$on('carritoDetalleComplemento', (obj) => {
                this.complemento = obj.complemento;
                $('#modalCarritoDetalleComplemento').modal('show');
            });
        },
        methods: {
            cerrar() {
                $('#modalCarritoDetalleComplemento').modal('hide');
            }
        },
        watch: {
            complemento: function (val, oldVal) {
                $('#v-pills-tab-complemento .nav-link').removeClass('active');
                $('#v-pills-tabContentCom .tab-pane').removeClass('active');
                $('#v-pills-tab-complemento #v-pills-desglosecomplemento-tab').addClass('active');
                $('#v-pills-tabContentCom #v-pills-desglose-complemento').addClass('show active');
            },
        }
    }
</script>
<style scoped>
</style>
