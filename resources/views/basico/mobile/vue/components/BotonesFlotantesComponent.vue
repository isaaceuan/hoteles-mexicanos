<template>
    <div class="row bg-acento">
        <div class="col-6 pr-1">
            <button class="btn btn-outline-light rounded-0" @click="prev()">
                <span class="fa fa-chevron-left mr-2"></span>
                {{$t('carrito.atras')}}
            </button>
        </div>
        <div class="col-6 pl-1 text-right">
            <button class="btn btn-outline-light rounded-0" v-if="current_step != 'informacion' && total>0"
                    @click="next()">
                {{$t('carrito.continuar')}}
                <span class="ml-2 fa fa-chevron-right"></span>
            </button>
        </div>
    </div>
</template>

<script>
    import {totalCarritoEvent, botonesFlotantesEvent} from '../app';

    export default {
        props: {
            step: {
                type: String,
                default: 'disponibilidad'
            }
        },
        data() {
            return {
                current_step: this.step,
                total: 0,
            }
        },
        mounted() {
        },
        methods: {
            next() {
                botonesFlotantesEvent.$emit('siguiente', true);
                $('.loading').removeClass('d-none')
            },
            prev() {
                botonesFlotantesEvent.$emit('atras', true);
                $('.loading').removeClass('d-none')
            },
        },
        created() {
            totalCarritoEvent.$on('totalCarritoEvent', obj => {
                this.total = obj;
            });
        }
    }
</script>
