(function(formaPago) {
    formaPago.debug("Componente cargado.");
    const stripe = Stripe(
        formaPago.getModelo().pasarela_pago.configuraciones.public_key
    );

    const elementos = stripe.elements();
    setTimeout(() => {
        elementos.create("cardNumber").mount("#numero");
        elementos.create("cardCvc").mount("#codigo");
        elementos.create("cardExpiry").mount("#expiracion");
    }, 5000);

    formaPago.onSubmit = function(form) { 
        stripe
            .createToken(elementos.getElement("cardNumber"))
            .then(respuesta => {
                if (respuesta.hasOwnProperty("token")) {
                    formaPago.getElemento("#token").val(respuesta.token.id);
                    procesarReserva();
                } else {
                    cancelarProceso();
                    Modal.mostrar(respuesta.error.message);
                }
            }); 

        return;
    };
})(FormasPago[document.currentScript.getAttribute("data-forma-pago-indice")]);
