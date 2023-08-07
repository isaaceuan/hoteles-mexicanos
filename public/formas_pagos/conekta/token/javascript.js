(function(formaPago) { 
    formaPago.debug("Componente cargado.");
    Conekta.setPublicKey(
        formaPago.getModelo().pasarela_pago.configuraciones.public_key
    );
    formaPago.onSubmit = function(form) {
        // console.log(tokenInput.val());
        // if (tokenInput.val() !== '') {
        //     procesarReserva();
        //     return;
        // }
        Conekta.token.create(
            {
                card: {
                    number: formaPago.getElemento("#numero").val() || "",
                    name: formaPago.getElemento("#propietario").val() || "",
                    cvc: formaPago.getElemento("#codigo").val() || "",
                    exp_year:
                        formaPago.getElemento("#expiracion-anio").val() || "",
                    exp_month:
                        formaPago.getElemento("#expiracion-mes").val() || ""
                }
            },
            function(token) {
                const tokenInput = formaPago.getElemento("#token");
                tokenInput.val(token.id); 
                procesarReserva();
                // form.submit();
            },
            function(response) {
                cancelarProceso();
                Formulario.habilitarPagar(true);
                Modal.mostrar(response.message_to_purchaser);
            }
        );
        return false;
    };
})(FormasPago[document.currentScript.getAttribute("data-forma-pago-indice")]);
