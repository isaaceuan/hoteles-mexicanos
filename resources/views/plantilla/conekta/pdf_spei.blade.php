<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"
      style="width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
<head>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Referencia Oxxo</title>
    <!--[if (mso 16)]>
    <style type="text/css">
        a {
            text-decoration: none;
        }
    </style>
    <![endif]-->
    <!--[if gte mso 9]>
    <style>sup {
        font-size: 100% !important;
    }</style><![endif]-->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG></o:AllowPNG>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
    <!--<![endif]-->
    <style type="text/css">

        /* PS ----------------------------------------------------------------------- */

        h3 {
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .ps {
            width: 596px;
            border-radius: 4px;
            box-sizing: border-box;
            padding: 0 45px;
            margin: 40px auto;
            overflow: hidden;
            border: 1px solid #b0afb5;
            font-family: 'Open Sans', sans-serif;
            color: #4f5365;
        }

        .ps-reminder {
            position: relative;
            top: -1px;
            padding: 9px 0 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            color: #ffffff;
            background: #000000;
        }

        .ps-info {
            margin-top: 26px;
            position: relative;
        }

        .ps-info:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        .ps-brand {
            width: 45%;
            float: left;
        }

        .ps-brand img {
            max-width: 150px;
            margin-top: 2px;
        }

        .ps-amount {
            width: 55%;
            float: right;
        }

        .ps-amount h2 {
            font-size: 36px;
            color: #000000;
            line-height: 24px;
            margin-bottom: 15px;
        }

        .ps-amount h2 sup {
            font-size: 16px;
            position: relative;
            top: -2px
        }

        .ps-amount p {
            font-size: 10px;
            line-height: 14px;
        }

        .ps-reference {
            margin-top: 14px;
        }

        h1 {
            font-size: 27px;
            color: #000000;
            text-align: center;
            margin-top: -1px;
            padding: 6px 0 7px;
            border: 1px solid #b0afb5;
            border-radius: 4px;
            background: #f8f9fa;
        }

        .ps-instructions {
            margin: 32px -45px 0;
            padding: 32px 45px 45px;
            border-top: 1px solid #b0afb5;
            background: #f8f9fa;
        }

        ol {
            text-align: left;
            margin: 17px 0 0 16px;
        }

        li + li {
            margin-top: 10px;
            color: #000000;
        }

        a {
            color: #1475ce;
        }

        .ps-footnote {
            margin-top: 22px;
            padding: 22px 20 24px;
            color: #108f30;
            text-align: center;
            border: 1px solid #108f30;
            border-radius: 4px;
            background: #ffffff;
        }

    </style>
</head>
<body
    style="width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
<div class="ps">
    <div class="ps-header">
        <div class="ps-reminder">@lang('formaspagos.ficha_digital')</div>
        <div class="ps-info">
            <div class="ps-brand"><img src="https://cdn2.downdetector.com/static/uploads/logo/spei.png" width="200" alt="SPEI"></div>
            <div class="ps-ammount">
                <h3>@lang('formaspagos.monto')</h3>
                <h2>{{ number_format($formapago->metadatos->importe, 2)}}<sup>{{$formapago->moneda}}</sup></h2>
                <p>@lang('formaspagos.cantidad_exacta')</p>
            </div>
        </div>
        <div class="ps-reference">
            <h3>@lang('formaspagos.clabe')</h3>
            <h1>{{$formapago->metadatos->clabe}}</h1>
        </div>
    </div>
    <div class="ps-instructions">
        <h3>@lang('formaspagos.instrucciones')</h3>
        <ol>
            <li>@lang('formaspagos.spei_1')</li>
            <li>@lang('formaspagos.spei_1',['banco'=> $formapago->metadatos->banco])</strong>.
            </li>
            <li>@lang('formaspagos.spei_3')</strong>.</li>
            <li>@lang('formaspagos.spei_4')</li>
        </ol>
        <div class="ps-footnote">@lang('formaspagos.confirmar_pago',['propiedad'=>$propiedad->nombre])</div>
    </div>
</div>
</body>
</html>
