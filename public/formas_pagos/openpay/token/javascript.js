(function (formaPago) {
    formaPago.debug('Componente cargado.');
    const pasarelaPago = formaPago.getModelo().pasarela_pago;
    const configuraciones = pasarelaPago.configuraciones;
    const tokenInput = formaPago.getElemento('#token');
    const contenedorId = formaPago.getContenedor().attr("id");

    OpenPay.setId(configuraciones.merchant_id);
    OpenPay.setApiKey(configuraciones.public_key);
    OpenPay.setSandboxMode(!pasarelaPago.en_produccion);
    OpenPay.deviceData.setup(contenedorId, 'parametros[dispositivo]');

    formaPago.onSubmit = function (form) {
        // if (tokenInput.val() !== '') {
        //     procesarReserva();
        //     return;
        // }

        OpenPay.token.extractFormAndCreate(
            'form',
            function (respuesta) {
                tokenInput.val(respuesta.data.id);
                procesarReserva()
            },
            function (error) {
                cancelarProceso();
                console.error(error);
                const mensaje = error.data.description ? error.data.description : error.message;
                Modal.mostrar(mensaje, 'Error');
            }
        );

        return false;
    };
})(FormasPago[document.currentScript.getAttribute('data-forma-pago-indice')]);
