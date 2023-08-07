require('./../../js/bootstrap');
import Vue from 'vue';
import axios from 'axios';
import VueCurrencyFilter from 'vue-currency-filter'
import $ from 'jquery'
import {BootstrapVue} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'




window.Vue = require('vue');
window.axios = axios;

import VueInternationalization from 'vue-i18n';
import Locale from '../../js/vue-i18n-locales.generated';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.use(Loading);
Vue.use(VueInternationalization);

const i18n = new VueInternationalization({
    locale: window.lang,
    messages: Locale,
});


export const agrupadorEvent = new Vue();
export const totalEvent = new Vue();
export const carritoEvent = new Vue();
export const cambiarMonedaEvent = new Vue();
export const complementoEvent = new Vue();
//CREAR RESERVA NUEVA
Vue.component('monedas-component', require('./components/MonedasComponent.vue').default);
Vue.component('disponibilidad-component', require('./components/DisponibilidadComponent.vue').default);
Vue.component('filtro-tipo-vista-component', require('./components/FiltroTipoVistaComponent.vue').default);
Vue.component('habitacion-tarifa-component', require('./components/disponibilidad/habitacion/HabitacionTarifaComponent.vue').default);
Vue.component('tarifa-habitacion-component', require('./components/disponibilidad/tarifa/TarifaHabitacionComponent.vue').default);
Vue.component('tarifa-precio-formula-component', require('./components/disponibilidad/TarifaPrecioFormulaComponent.vue').default);
Vue.component('modal-sin-disponibilidad-component', require('./components/disponibilidad/sinDisponibilidad/ModalSinDisponibilidadComponent.vue').default);
Vue.component('modal-detalle-habitacion-component', require('./components/disponibilidad/habitacion/ModalDetalleHabitacionComponent.vue').default);
Vue.component('modal-detalle-tarifa-component', require('./components/disponibilidad/tarifa/ModalDetalleTarifaComponent.vue').default);
Vue.component('modal-detalle-reserva-component', require('./components/disponibilidad/ModalDetalleReservaComponent.vue').default);
Vue.component('modal-detalle-reserva-desglose-tab-component', require('./components/disponibilidad/detalleReserva/DesgloseTabComponent.vue').default);
Vue.component('modal-detalle-reserva-habitacion-tab-component', require('./components/disponibilidad/detalleReserva/HabitacionTabComponent.vue').default);
Vue.component('popover-reserva-component', require('./components/disponibilidad/PopoverReservaComponent.vue').default);
Vue.component('carrito-reservas-component', require('./components/carrito/CarritoReservasComponent.vue').default);
Vue.component('selector-monedas-component', require('./components/carrito/SelectorMonedasComponent').default);
Vue.component('carrito-total-component', require('./components/carrito/CarritoTotalComponent.vue').default);
Vue.component('modal-carrito-detalle-noches-component', require('./components/carrito/ModalCarritoDetalleNochesComponent.vue').default);
Vue.component('modal-carrito-detalle-complemento-component', require('./components/carrito/ModalCarritoDetalleComplementoComponent.vue').default);
Vue.component('complemento-component', require('./components/complementos/ComplementoComponent.vue').default);
Vue.component('modal-detalle-complemento-component', require('./components/complementos/ModalDetalleComplementoComponent.vue').default);
Vue.component('complemento-selector-component', require('./components/complementos/ComplementoSelectorComponent.vue').default);


//MODIFICAR RESERVA
Vue.component('modificar-disponibilidad-component', require('./components/modificar/DisponibilidadComponent.vue').default);
Vue.component('modificar-habitacion-tarifa-component', require('./components/modificar/habitacion/HabitacionTarifaComponent.vue').default);
Vue.component('modificar-tarifa-habitacion-component', require('./components/modificar/tarifa/TarifaHabitacionComponent.vue').default);
Vue.component('modificar-carrito-reservas-component', require('./components/modificar/carrito/CarritoReservasComponent.vue').default);


Vue.component('modal-aviso-ajuste-component', require('./components/disponibilidad/ModalAvisoAjusteDisponibilidadComponent.vue').default);

Vue.component('input-spinner', require('./components/fom-components/InputSpinnerComponent.vue').default);
// Vue.component('cargador', require('./components/LoadingComponent.vue').default);

Vue.use(VueCurrencyFilter);
Vue.use(BootstrapVue);

const moment = require('moment');
require('moment/locale/es');
Vue.use(require('vue-moment'), {
    moment
});
moment.locale(window.lang)

const app = new Vue({
    el: '#app',
    i18n
});



