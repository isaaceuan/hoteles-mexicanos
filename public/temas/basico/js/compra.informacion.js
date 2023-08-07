const Modal = {
    mostrar: function (mensaje, titulo = 'Aviso') {
        const elemento = $("#modal");
        elemento.find('.modal-title').html(titulo);
        elemento.find('.modal-body p').html(mensaje);
        elemento.modal('show');
    }
};

const FormaPago = function (serializado) {
    const _modelo = JSON.parse(atob(serializado));
    this.onSelect = () => true;
    this.onUnselect = () => true;
    this.onSubmit = () => true;
    this.getModelo = () => _modelo;
    this.getContenedor = () => $(`#formas-pago #${this.getModelo().codigo}`);
    this.getElemento = (selector) => $(`#formas-pago #${this.getModelo().codigo} ${selector}`);
    this.prepararCargo = function (parametros, success) {
        $.ajax({
            url: 'acciones/preparar.php',
            method: 'post',
            data: {
                forma_pago: Formulario.getFormaPago(),
                parametros: parametros,
                titular: {
                    nombres: Formulario.getNombres(),
                    apellidos: Formulario.getApellidos(),
                    correo: Formulario.getCorreo(),
                    telefono: Formulario.getTelefono()
                }
            },
            success: success,
            error: function (xhr) {
                const respuesta = JSON.parse(xhr.responseText);
                Modal.mostrar(respuesta.mensaje, 'Error de inicialización');
            }
        });
    };
    this.debug = function (mensaje) {
        console.info(`[${this.getModelo().pasarela_pago.codigo}.${this.getModelo().instrumento_pago.codigo}] ${mensaje}`);
    };
};

const Formulario = {
    getNombres: () => $("#nombres").val() || '',
    getApellidos: () => $("#apellidos").val() || '',
    getCorreo: () => $("#correo").val() || '',
    getTelefono: () => $("#telefono").val() || '',
    getFormaPago: () => $("#forma_pago").val() || null,
    estaVacio: function () {
        return this.getNombres() === '' && this.getApellidos() === '' && this.getCorreo() === '' && this.getTelefono() === '';
    },
    habilitarDatosPersonales: function (activo) {
        $("#form #datos-personales input, #form #datos-personales select, #form #datos-personales textarea").prop('readonly', !activo);
    },
    habilitarPagar: function (activo) {
        $("#form #pagar").prop('disabled', !activo);
    }
}


function iniciarProceso() {
    informacionPago.spinner().removeClass('d-none');
    informacionPago.boton_continuar().attr('disabled', true).hide()
    informacionPago.error().addClass('d-none').html('');
    formaPago.error().addClass('d-none').html('');
}

function cancelarProceso() {
    informacionPago.boton_continuar().attr('disabled', false).show()
    informacionPago.spinner().addClass('d-none');
    // informacionPago.error().removeClass('d-none').html('');
    // habilitarBotones();
}

$(document).ready(function () {
    informacionPago.metodo_pago().on('change', function (e) {
        let metodo = $(this).val();
        const indice = $(e.target).data('indice');
        const formaPago = FormasPago[indice];
        $("#forma_pago").val(indice);
        if (metodo == 'tarjeta') {
            informacionPago.pago_tarjeta().show();
            informacionPago.pago_efectivo().hide();
            informacionPago.pago_transferencia().hide();
            informacionPago.pago_paypal().hide();
        }
        if (metodo == 'efectivo') {
            informacionPago.pago_tarjeta().hide();
            informacionPago.pago_efectivo().show();
            informacionPago.pago_transferencia().hide();
            informacionPago.pago_paypal().hide();
        }
        if (metodo == 'transferencia') {
            informacionPago.pago_tarjeta().hide();
            informacionPago.pago_efectivo().hide();
            informacionPago.pago_transferencia().show();
            informacionPago.pago_paypal().hide();
        }
        if (metodo == 'paypal') {
            informacionPago.pago_tarjeta().hide();
            informacionPago.pago_efectivo().hide();
            informacionPago.pago_transferencia().hide();
            informacionPago.pago_paypal().show();
        }
    });

    const totalPagar = parseFloat($("#formas-pago").data('total')) || 0.00;

    if (totalPagar > 0) $('#formas-pago input, #formas-pago select, #formas-pago textarea').prop('disabled', true);

    $('#formas-pago a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        const selectorInputs = 'input, select, textarea';

        if (e.relatedTarget) {
            const indice = $(e.relatedTarget).data('indice');
            console.log(indice);
            const formaPago = FormasPago[indice];
            formaPago.onUnselect();
            $('#formas-pago ' + $(e.relatedTarget).attr('href')).find(selectorInputs).prop('disabled', true);
        }

        $('#formas-pago ' + $(e.target).attr('href')).find(selectorInputs).prop('disabled', false);

        const indice = $(e.target).data('indice');
        const formaPago = FormasPago[indice];
        $("#forma_pago").val(indice);
        formaPago.onSelect();
    })


    $("#form").validate({
        lang: '{{app()->getLocale()}}',
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            console.log('paso la validacion');
            iniciarProceso();
            var tipoPasarela = $('#tipo_pasarela').val();
            if (tipoPasarela === 'garantia') {
                let tarjetaValida = informacionPagoGarantia.getTarjeta($("#numero_tarjeta").val());
                if (tarjetaValida === false) {
                    formaPago.error().removeClass('d-none').html('');
                    informacionPago.informacion().find(".card-errors").text('El número de la tarjeta es inválido.');
                    cancelarProceso();
                } else {
                    enviarInformacionGarantia();
                }
            } else if (tipoPasarela === 'conekta') {
                tokenizarConekta()
            } else if (tipoPasarela === 'stripe') {
                tokenizarStripe()
                console.log('tokenizar stripe');
            } else {
                console.log('tokenizar default');
            }
        }
    });

    $("#form").submit(function () {
        iniciarProceso();
        const indice = Formulario.getFormaPago();

        const hayPasarela = indice !== null;
        // if (totalPagar > 0 && !hayPasarela) {
        //     console.log('Debe elegir una forma de pago.');
        //     Modal.mostrar('Debe elegir una forma de pago.');
        //     return false;
        // } else if (totalPagar > 0 && hayPasarela) {
        Formulario.habilitarPagar(false);
        return FormasPago[indice].onSubmit(this);
        // }

        return false;
    });
})
;
