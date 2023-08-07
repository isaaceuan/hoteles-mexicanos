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
        .page-break {
            page-break-after: always;
        }

        .opps {
            width: 496px;
            border-radius: 4px;
            box-sizing: border-box;
            padding: 0 45px;
            margin: 40px auto;
            overflow: hidden;
            border: 1px solid #b0afb5;
            font-family: 'Open Sans', sans-serif;
            color: #4f5365;
        }

        .opps-reminder {
            position: relative;
            top: -1px;
            padding: 9px 0 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            color: #ffffff;
            background: #000000;
        }

        .opps-info {
            margin-top: 26px;
            position: relative;
        }

        .opps-info:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;

        }

        .opps-brand {
            width: 45%;
            float: left;
        }

        .opps-brand img {
            max-width: 150px;
            margin-top: 2px;
        }

        .opps-ammount {
            width: 55%;
            float: right;
        }

        .opps-ammount h2 {
            font-size: 36px;
            color: #000000;
            line-height: 24px;
            margin-bottom: 15px;
        }

        .opps-ammount h2 sup {
            font-size: 16px;
            position: relative;
            top: -2px
        }

        .opps-ammount p {
            font-size: 10px;
            line-height: 14px;
        }

        .opps-reference {
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

        .opps-instructions {
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
            color: #1155cc;
        }

        .opps-footnote {
            margin-top: 22px;
            padding: 22px 20px 24px;
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
<div class="opps">
    <div class="opps-header">
        <div class="opps-reminder">@lang('formaspagos.ficha_digital')
        </div>
        <div class="opps-info">
            <div class="opps-brand"><img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Oxxo_Logo.svg/1200px-Oxxo_Logo.svg.png"
                    width="200" alt="OXXOPay"></div>
            <div class="opps-ammount">
                <h3>@lang('formaspagos.monto')</h3>
                <h2> {{ number_format($formapago->metadatos->importe, 2)}}
                    <sup>{{$formapago->moneda}}</sup>
                </h2>
                <p>@lang('formaspagos.oxxo_comision')</p>
            </div>
        </div>
        <div class="opps-reference">
            <h3>@lang('formaspagos.referencia')</h3>
            <h1>{{$formapago->metadatos->referencia}}</h1>
        </div>
        <div class="opps-reference">
            <img
                src="{{$formapago->metadatos->codigo_barras}}"
                alt="QR" width="100%" height="75">
        </div>
    </div>
    <div class="opps-instructions">
        <h3>@lang('formaspagos.referencia')</h3>
        <ol>
            <li>@lang('formaspagos.oxxo_acude') <a
                    href="https://www.google.com.mx/maps/search/oxxo/"
                    target="_blank">@lang('formaspagos.aqui')</a>.
            </li>
            <li>@lang('formaspagos.oxxo_1')</li>
            <li>@lang('formaspagos.oxxo_2')</li>
            <li>@lang('formaspagos.oxxo_3')</li>
            <li>@lang('formaspagos.oxxo_4')</li>
        </ol>
        <div class="opps-footnote">@lang('formaspagos.confirmar_pago',['propiedad'=>$propiedad->nombre])</div>
    </div>
</div>
</body>
</html>
