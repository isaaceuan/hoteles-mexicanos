(function (formaPago) {
    const pagoIdInput = formaPago.getElemento("#pago_id");
    const pagadorIdInput = formaPago.getElemento("#pagador_id");
    const payButton = $('#pagar');
    const mensaje = formaPago.getElemento('.cardPPLS');
    let ppp = null;

    formaPago.onSelect = function () {
        formaPago.getElemento('iframe').css('width', '100%');
        if (pagoIdInput.val() !== '') return;

        // if (Formulario.estaVacio()) {
        //     mensaje.show();
        //     return;
        // }
        mensaje.find('p.lead').html('Cargando...');

        formaPago.prepararCargo(
            {
                accion: 'crear-pago'
            },
            function (respuesta) {
                mensaje.hide();
                Formulario.habilitarDatosPersonales(true);
                Formulario.habilitarFormasPagos(true);
                pagoIdInput.val(respuesta.referencia);
                ppp = PAYPAL.apps.PPP({
                        approvalUrl: respuesta.metadatos.pago_url,
                        buttonLocation: 'outside',
                        preselection: 'none',
                        surcharging: false,
                        hideAmount: false,
                        placeholder: 'paypal_plus',
                        disableContinue: 'pagar',
                        enableContinue: 'pagar',
                        language: respuesta.metadatos.idioma,
                        //country: 'MX',
                        disallowRememberedCards: true,
                        rememberedCards: '',
                        mode: respuesta.metadatos.modo,
                        useraction: 'continue',
                        payerFirstName: Formulario.getNombres(),
                        payerLastName: Formulario.getApellidos(),
                        payerEmail: Formulario.getCorreo(),
                        payerPhone: Formulario.getTelefono(),
                        payerTaxId: '',
                        //payerTaxIdType: '',
                        merchantInstallmentSelection: 0,
                        merchantInstallmentSelectionOptional: false,
                        //iframeHeight: 'auto',
                        onContinue: function (rememberedCards, payerId, token, term) {
                            onApprovalSuccess(payerId);
                        },
                        onError: onIframeError
                    }
                );
            });
    };

    formaPago.onUnselect = function () {
        console.log('selected');
        // Formulario.habilitarPagar(false);
    };

    const onApprovalSuccess = function (pagadorId) {
        pagadorIdInput.val(pagadorId);
        procesarReserva();
    };

    const onApprovalError = function (error) {
        Modal.mostrar(error);
    };

    const onIframeEvent = function (event) {
        if (event.data != '' && event.data.constructor.name === "String") {
            const data = JSON.parse(event.data);
            console.info('onIframeEvent ->', data);
            switch (data.action) {
                case 'enableContinueButton':
                    console.log('habilitar boton');
                    Formulario.habilitarDatosPersonales(true);
                    Formulario.habilitarFormasPagos(true);
                    // payButton.prop('disabled', false);
                    if (data.result === 'error') onIframeError('Error de validación.');
                    break;

                case 'disableContinueButton':
                    console.log('deshabilitar boton');
                    payButton.prop('disabled', true);
                    break;

                case 'onError':
                    onIframeError(data.cause);
                    Formulario.habilitarDatosPersonales(true);
                    Formulario.habilitarFormasPagos(true);
                    break;
            }
        }
    };

    const onIframeError = function (error) {
        informacionPago.spinner().addClass('d-none');
        console.info('Cerrar cargador.');
    };

    formaPago.onSubmit = function () {
        Formulario.habilitarDatosPersonales(false);
        Formulario.habilitarFormasPagos(false);
        console.info('Mostrar cargador.');
        if (pagadorIdInput.val() !== '') return true;
        ppp.doContinue();
        return false;
    };
    if (window.addEventListener) {
        window.addEventListener('message', onIframeEvent, false);
        console.log('window.addEventListener successful');
    } else if (window.attachEvent) {
        window.attachEvent("onmessage", onIframeEvent);
        console.log('window.attachEvent successful');
    } else {
        console.warn('Could not attach message listener!');
        throw new Error("Can't attach message listener");
    }
})(FormasPago[document.currentScript.getAttribute('data-forma-pago-indice')]);
