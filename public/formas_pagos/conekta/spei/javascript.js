(function (formaPago) {
    formaPago.debug('Componente cargado.');
    formaPago.onSubmit = function (form) {
        procesarReserva();
    };
})(FormasPago[document.currentScript.getAttribute('data-forma-pago-indice')]);
