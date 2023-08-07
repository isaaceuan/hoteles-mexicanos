import './../../js/bootstrap';
import Vue from 'vue';
import axios from 'axios';
import VueCurrencyFilter from 'vue-currency-filter'
import $ from 'jquery'
import {BootstrapVue} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Toasted from 'vue-toasted';

import Vue from 'vue';
window.Vue = Vue;
window.axios = axios;

if (import.meta.env.VITE_ENV_MODE === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}

import VueInternationalization from 'vue-i18n';
import Locale from '../../js/vue-i18n-locales.generated';

Vue.use(VueInternationalization);
const i18n = new VueInternationalization({
    locale: window.lang,
    messages: Locale
});


export const agrupadorEvent = new Vue();
export const totalEvent = new Vue();
export const totalCarritoEvent = new Vue();
export const carritoEvent = new Vue();
export const cambiarMonedaEvent = new Vue();
export const botonesFlotantesEvent = new Vue();
export const complementoEvent = new Vue();

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('botones-flotantes-component', require('./components/BotonesFlotantesComponent.vue').default);
Vue.component('monedas-component', require('./components/MonedasComponent.vue').default);
Vue.component('moneda-seleccionada-component', require('./components/MonedaSeleccionadaComponent.vue').default);
Vue.component('input-spinner', require('./components/fom-components/InputSpinnerComponent.vue').default);
//DISPONIBILIDAD
Vue.component('disponibilidad-component', require('./components/DisponibilidadComponent.vue').default);
Vue.component('filtro-tipo-vista-component', require('./components/FiltroTipoVistaComponent.vue').default);
Vue.component('total-tipo-vista-component', require('./components/TotalTipoVistaComponent.vue').default);
Vue.component('habitacion-tarifa-component', require('./components/disponibilidad/habitacion/HabitacionTarifaComponent.vue').default);
Vue.component('tarifa-habitacion-component', require('./components/disponibilidad/tarifa/TarifaHabitacionComponent.vue').default);
Vue.component('tarifa-precio-formula-component', require('./components/disponibilidad/TarifaPrecioFormulaComponent.vue').default);
Vue.component('modal-sin-disponibilidad-component', require('./components/disponibilidad/sinDisponibilidad/ModalSinDisponibilidadComponent.vue').default);
Vue.component('modal-detalle-habitacion-component', require('./components/disponibilidad/habitacion/ModalDetalleHabitacionComponent.vue').default);
Vue.component('modal-detalle-tarifa-component', require('./components/disponibilidad/tarifa/ModalDetalleTarifaComponent.vue').default);
Vue.component('modal-detalle-reserva-component', require('./components/disponibilidad/ModalDetalleReservaComponent.vue').default);
Vue.component('modal-detalle-reserva-desglose-tab-component', require('./components/disponibilidad/detalleReserva/DesgloseTabComponent.vue').default);
Vue.component('modal-detalle-reserva-habitacion-tab-component', require('./components/disponibilidad/detalleReserva/HabitacionTabComponent.vue').default);
Vue.component('modal-detalle-reserva-tarifa-tab-component', require('./components/disponibilidad/detalleReserva/TarifaTabComponent.vue').default);
Vue.component('modal-aviso-ajuste-component', require('./components/disponibilidad/ModalAvisoAjusteDisponibilidadComponent.vue').default);
// Vue.component('popover-reserva-component', require('./components/disponibilidad/PopoverReservaComponent.vue').default);
Vue.component('modal-cotizar-component', require('./components/disponibilidad/ModalCotizarComponent.vue').default);
//COMPLEMENTOS
Vue.component('complemento-component', require('./components/complementos/ComplementoComponent.vue').default);
Vue.component('modal-detalle-complemento-component', require('./components/complementos/ModalDetalleComplementoComponent.vue').default);
Vue.component('complemento-selector-component', require('./components/complementos/ComplementoSelectorComponent.vue').default);

//CARRITO
Vue.component('carrito-reservas-component', require('./components/carrito/CarritoReservasComponent.vue').default);
Vue.component('carrito-total-component', require('./components/carrito/CarritoTotalComponent.vue').default);
Vue.component('carrito-total-garantia-component', require('./components/carrito/CarritoTotalGarantiaComponent.vue').default);
Vue.component('modal-carrito-detalle-noches-component', require('./components/carrito/ModalCarritoDetalleNochesComponent.vue').default);
Vue.component('modal-carrito-detalle-complemento-component', require('./components/carrito/ModalCarritoDetalleComplementoComponent.vue').default);
Vue.component('selector-monedas-component', require('./components/carrito/SelectorMonedasComponent').default);


//MODIFICAR
Vue.component('modificar-disponibilidad-component', require('./components/modificar/DisponibilidadComponent.vue').default);
Vue.component('modificar-habitacion-tarifa-component', require('./components/modificar/habitacion/HabitacionTarifaComponent.vue').default);
Vue.component('modificar-tarifa-habitacion-component', require('./components/modificar/tarifa/TarifaHabitacionComponent.vue').default);
Vue.component('modificar-carrito-reservas-component', require('./components/modificar/carrito/CarritoReservasComponent.vue').default);

let opciones = {
    theme: "toasted-primary",
    position: "bottom-center",
    duration: 5000,
    fullWidth: true,
    // type:'error',
    action: {
        text: 'X',
        onClick: (e, toastObject) => {
            toastObject.goAway(0);
        }
    },
}

Vue.use(VueCurrencyFilter);
Vue.use(BootstrapVue);
Vue.use(Toasted, opciones)

const moment = require('moment');
import 'moment/locale/es';
Vue.use(require('vue-moment'), {
    moment
});
moment.locale(window.lang)

Vue.component("v-select", vSelect);

const app = new Vue({
    el: '#appMobile',
    i18n
});

