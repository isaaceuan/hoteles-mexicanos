<template>
    <b-modal v-model="mostrarModal" size="lg" hide-header>
        <div class="modal-body row">
            <div class="col-2">
                <i class="fa fa-4x fa-info color-acento"></i>
            </div>
            <div class="col-10" v-if="datos">
                <p v-html="datos.mensaje_sin_disponibilidad"></p>
                <p v-html="datos.mensaje_sin_disponibilidad_personal"></p>
            </div>
            <div class="clearfix"></div>
        </div>
        <template v-slot:modal-footer>
            <b-button
                    variant="primary"
                    class="float-right"
                    @click="close"
            >
                {{$t('disponibilidad.cerrar')}}
            </b-button>
        </template>
    </b-modal>
</template>
<script>
    export default {
        props: {
            datos: Object,
            mostrar: false,
        },
        methods: {
            close() {
                this.$emit('closemodal', false)
            }
        },
        computed: {
            mostrarModal: {
                get() {
                    return this.mostrar
                }
            }
        }
    }
</script>