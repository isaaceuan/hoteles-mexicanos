<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modificar / Cancelar reserva
    |--------------------------------------------------------------------------
    |
    | Traducciones para el flujo de modificar reserva.
    |
    */
    'login' => [
        'especifique' => 'Especifíque los datos siguientes',
        'correo' => 'Correo',
        'clave_reservacion' => 'Folio',
        'buscar' => 'Buscar',
        'regresar' => 'Regresar',
        'sin_registros' => 'No existe ninguna reservación con los datos especificados en nuestros registros.',
        'aceptar' => 'Aceptar',
    ],
    'menu' => [
        'bienvenido' => 'Bienvenido',
        'hacer' => '¿Qué deseas hacer?',
        'resumen' => 'Resumen de mi reserva',
        'editar' => 'Editar mis datos personales',
        'modificar' => 'Modificar reservación',
        'cancelar' => 'Cancelar reservación',
        'estas_seguro' => '¿Está seguro que desea salir?',
        'salir' => 'Salir',
        'cerrar' => 'Cerrar',
        'para_modificacion' => 'Para modificación',
        'para_cancelacion' => 'Para cancelación',
        'modificacion_hasta' => 'Usted tiene hasta el :fecha_limite para poder realizar cambios en esta reservación.',
        'modificacion_intentos' => 'Disponible de :numero_intentos intento(s) de cambio para esta reservación antes que sea permanente.',
        'modificacion_vencido' => 'El tiempo del que disponía para realizar modificaciones en esta reservación a vencido.',
        'cancelacion_hasta' => 'Usted tiene hasta el :fecha_limite para poder cancelar esta reservación con un reembolso del :tasa%',
        'cancelacion_vencido' => 'El tiempo del que disponía para cancelar esta reservación con reembolso ha vencido.',
        'cancelar_titulo' => 'Una vez cancelada su reservación no es posible restaurarla.',
        'cancelar_texto' => 'Su reservación será cancelada. El hotel será notificado y procederá a realizar el reembolso correspondiente.',
        'cancelar_texto_noreembolsable' => 'Su reservación será cancelada. El hotel será notificado.',
        'cancelar_seguro' => '¿Está seguro que desea cancelar su reservación?',
    ],
    'resumen' => [
        'titulo_reserva' => 'Resumen de mi reserva',
        'titulo_enviar' => 'Enviar reservación',
        'bienvenido' => 'Bienvenido',
        'enviar' => 'Enviar',
        'enviado' => ' Reenviado correctamente.',
        'no_enviado' => ' Hubo un problema al enviar el correo, inténtelo más tarde.'
    ],
    'datos_personales' => [
        'guardar' => 'Guardar datos personales',
        'error_titulo' => 'Error al intentar guardar su información',
        'completado' => 'Sus datos personales fueron guardados exitosamente.',
    ],
    'cancelar' => [
        'titulo'=>'Notificación',
        'mensaje'=>'Su reservación ha sido cancelada satisfactoriamente.',
    ],
    'finalizada' => [
        'titulo'=>'Reservación finalizada',
        'mensaje'=>'Los cambios en su reservación han sido guardados satisfactoriamente.',
    ]


];
