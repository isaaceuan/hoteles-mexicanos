import Vue from "vue"

Vue.filter('truncar', function (value, limit) {
    let regex = '';
    let otro = value.replace(regex, "");
    if (otro.length > limit) {
        otro = otro.substring(0, (limit - 3)) + '...';
    }
    return otro
});


Vue.filter('convertirMoneda', function (value, tipo_cambiario) {
    return value * tipo_cambiario;
});



Vue.filter('fechaDia', function (value) {
    return Vue.moment(value).format('ddd D MMM YYYY');
});

Vue.filter('fechaDiaSemana', function (value) {
    return Vue.moment(value).format('ddd D MMM YYYY');
});


