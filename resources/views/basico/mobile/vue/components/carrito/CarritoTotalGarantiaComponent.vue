<template>
    <div>
        <p id="popover-button-sync" class="mb-2">
            <b>{{$t('informacion.importe_deposito')}}:</b><br>
            <span class="text-danger">{{ total |
        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
        monedaSeleccionada.id , ',', 2,
        '.', 'front', true
        ) }}
        </span>
            <i class="fa fa-info-circle fa-lg text-acento"></i>
            <b-popover target="popover-button-sync"
                       triggers="click"
                       :show.sync="popoverShow"
                       placement="top">
                <template v-slot:title>
                    <b-button @click="onClose" class="close px-1 ml-1" aria-label="Close">
                        <span class="d-inline-block" aria-hidden="true">&times;</span>
                    </b-button>
                    {{$t('complemento.detalles')}}
                </template>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col" width="600">{{$t('carrito.habitacion')}}</th>
                        <th width="350">{{$t('informacion.deposito')}} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="detalle of detalle_anticipo">
                        <th scope="row">{{detalle.tipo_habitacion}}<br>
                            <small>{{detalle.tarifa}}</small>
                        </th>
                        <td>{{ detalle.total_anticipo |
                            convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
                            monedaSeleccionada.id, ',', 2,
                            '.', 'front', true
                            ) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </b-popover>
        </p>
        <p v-if="total_saldo>=0">
            <b>{{$t('informacion.importe_pendiente')}}:</b><br>
            <span class="text-danger">{{ total_saldo |
        convertirMoneda(monedaSeleccionada.tipo_cambiario) | currency(
        monedaSeleccionada.id , ',', 2,
        '.', 'front', true
        ) }}
        </span>
        </p>
    </div>
</template>

<script>

    import {cambiarMonedaEvent, totalEvent} from '../../app';

    export default {
        props: {
            moneda_seleccionada: Object,
            detalle_anticipo: Array,
            total_carrito: {
                type: Number,
                default: 0.00
            },
            total_saldo: {
                type: Number,
                default: 0.00
            }
        },
        data: function () {
            return {
                show: false,
                monedaSeleccionada: this.moneda_seleccionada,
                total: this.total_carrito,
                mostrarIcono: this.mostrar_icono,
                popoverShow: false
            };
        },
        mounted() {
            cambiarMonedaEvent.$on('cambiarMonedaEvent', obj => {
                this.monedaSeleccionada = obj;
            });
            totalEvent.$on('totalEvent', obj => {
                this.total = obj;
            });
        },
        methods:{
            onClose() {
                this.popoverShow = false
            },
        }
    }

</script>

<style scoped>

</style>
