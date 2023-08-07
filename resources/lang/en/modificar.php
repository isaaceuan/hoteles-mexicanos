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
        'especifique' => 'Please fill in the following information',
        'correo' => 'Email',
        'clave_reservacion' => 'Folio',
        'buscar' => 'Search',
        'regresar' => 'Return',
        'sin_registros' => 'Sorry, There is no reservation with that information in our records.',
        'aceptar' => 'Ok',
    ],
    'menu' => [
        'bienvenido' => 'Welcome',
        'hacer' => 'What do you want to do?',
        'resumen' => 'Summary of my reservation',
        'editar' => 'Edit my personal data',
        'modificar' => 'Modify reservation',
        'cancelar' => 'Cancel reservation',
        'estas_seguro' => 'Are you sure you want to quit?',
        'salir' => 'Exit',
        'cerrar' => 'Close',
        'para_modificacion' => 'To modify',
        'para_cancelacion' => 'To cancel',
        'modificacion_hasta' => 'You still have :fecha_limite to modify this reservation.',
        'modificacion_intentos' => 'You still have :numero_intentos time(s) to modify this reservation, once used you will not be able to modify this reservation again.',
        'modificacion_vencido' => 'The time available to make modifications to this reservation has expired.',
        'cancelacion_hasta' => 'You still have :fecha_limite to cancel this reservation with a refund of the :tasa%',
        'cancelacion_vencido' => 'The time you had to cancel this reservation with a refund has expired.',
        'cancelar_titulo' => 'Once cancelled, it is not possible to restore your reservation.',
        'cancelar_texto' => 'Your reservation will be canceled. The hotel will be notified and will proceed to make the corresponding refund.',
        'cancelar_texto_noreembolsable' => 'Your reservation will be canceled. The hotel will be notified.',
        'cancelar_seguro' => ' Are you sure you want to cancel this reservation?',
    ],
    'resumen' => [
        'titulo_reserva' => 'Summary of my reservation',
        'titulo_enviar' => 'Send reservation',
        'bienvenido' => 'Welcome',
        'enviar' => 'Send',
        'enviado' => ' Successfully forwarded.',
        'no_enviado' => ' There was a problem sending the mail, please try again later.'
    ],
    'datos_personales' => [
        'guardar' => 'Save personal information',
        'error_titulo' => 'Error trying to save your information',
        'completado' => 'Your personal data was successfully saved.',
    ],
    'cancelar' => [
        'titulo'=>'Notification',
        'mensaje'=>'Your reservation has been successfully canceled.',
    ],
    'finalizada' => [
        'titulo'=>'Reservation completed',
        'mensaje'=>'The changes to your reservation have been saved successfully.',
    ]

];
