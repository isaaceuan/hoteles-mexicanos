{{--<style>--}}
@import url("https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");

{{--div{--}}
{{--border: 1px solid purple;--}}
{{--}--}}

.ez-wdt-cursor-pointer{
cursor:pointer;
}

#content<?=$id?>{
background-color: <?=$color_fondo?>;
color: <?=$color_secundario?>;
padding: 15px 0;
font-weight: 700;
/*text-align: center;*/
}

#content<?=$id?> #booknow,
#<?=$id?> .availability:focus {
outline: none !important;
}

#content<?=$id?> #booknow, #content<?=$id?> .booking-form .form .availability {
cursor: pointer;
border: 0px !important;
width: 100%;
padding: 5px 0;
text-transform: uppercase;
color: #fff !important;
font-size: 16px;
text-align: center;
margin-bottom:10px;
}

#content<?=$id?> #booknow,
#content<?=$id?> .booking-form .form .availability {
background: <?=$color_primario?> !important;
}


#child<?=$id?> .checkin,
#child<?=$id?> .checkout{
background-color: #E9ECEF !important;
border: 1px solid #ced4da;
}

.ez-wdt-form-control:focus{
border-color:<?=$color_secundario?> !important;
box-shadow: 0 0 10px <?=$color_secundario?> !important;
}

.ez-wdt-icon-calendar{
    padding: 6px 12px;
}

.ez-wdt-icon-calendar:focus{
border-color:<?=$color_secundario?> !important;
box-shadow: 0 0 10px <?=$color_secundario?> !important;
}

#child<?=$id?> .Cpromocion a {
color: <?=$color_primario?> !important;
}

#child<?=$id?> #btnBuscar {
margin-top: 1em;
}

#child<?=$id?> .btn-primary {
background-color: <?=$color_primario?> !important;
border-color: <?=$color_primario?> !important;
color: #fff !important;
}



.ez-wdt-input-group-append{
display:flex;
}



.mbsc-mobiscroll .mbsc-cal-btn-txt, .mbsc-mobiscroll .mbsc-cal-days th, .mbsc-mobiscroll .mbsc-cal-days, .mbsc-mobiscroll .mbsc-cal-hl-now .mbsc-cal-today, .mbsc-mobiscroll .mbsc-fr-btn {
color: <?=$color_primario?> !important
}
.mbsc-mobiscroll .mbsc-fr-btn-a {
background-color: <?=$color_primario?> !important
}

.mbsc-mobiscroll .mbsc-cal-days th {
border-bottom-color: <?=$color_primario?> !important
}

.mbsc-mobiscroll .mbsc-cal .mbsc-cal-day-sel .mbsc-cal-day-i {
background-color: <?=$color_primario?> !important
}

.mbsc-mobiscroll .mbsc-cal .mbsc-cal-sc-sel .mbsc-cal-sc-cell-i, .mbsc-mobiscroll .mbsc-cal .mbsc-cal-day-sel .mbsc-cal-day-i {
background-color: <?=$color_primario?> !important;
color: #fff !important;
}

.mbsc-mobiscroll .mbsc-range-btn-sel .mbsc-range-btn{
background-color: <?=$color_primario?> !important;
}

.mbsc-mobiscroll .mbsc-range-btn{
border-color: <?=$color_primario?> !important;
}


.mbsc-mobiscroll .mbsc-cal-day-closed:after, .mbsc-mobiscroll .mbsc-cal-day-closed:before {
background-color: torgb(<?=$color_primario?>, .6);
}

.mbsc-mobiscroll .mbsc-fr-hdr, .mbsc-mobiscroll .mbsc-sc-btn {
color: <?=$color_primario?> !important
}

.mbsc-mobiscroll .mbsc-sc-whl-l {
border-color: <?=$color_primario?> !important
}

/*MINIFRAMEWORK CSS EZ WIDGET*/
/*#GRID*/



.ez-wdt-row {
display: -ms-flexbox;
display: flex;
-ms-flex-wrap: wrap;
flex-wrap: wrap;
margin-right: -15px;
margin-left: -15px;
}

.ez-wdt-col-md-12 {
position: relative;
width: 100%;
min-height: 1px;
padding-right: 15px;
padding-left: 15px;
}

.ez-wdt-text-center {
text-align: center !important;
}

.ez-wdt-container {
width: 100%;
padding-right: 15px;
padding-left: 15px;
margin-right: auto;
margin-left: auto;
}

.ez-wdt-d-none {
display: none !important;
}

.ez-wdt-d-block {
display: block !important;
}

#child<?=$id?> .Cpromocion{
margin-top: 10px;
}

@media only screen and (max-width: 480px){
#child<?=$id?>  form  .field {
margin-bottom: 10px;
}
#child<?=$id?> .Cpromocion{
margin-top: 5px;
margin-bottom: 10px;
}
}


@media (min-width: 576px) {
.ez-wdt-container {
max-width: 540px;
}
}

@media (min-width: 768px) {
.ez-wdt-d-md-none {
display: none !important;
}

.ez-wdt-d-md-block {
display: block !important;
}


.ez-wdt-pr-md-1,
.ez-wdt-px-md-1 {
padding-right: 0.25rem !important;
}
.ez-wdt-pb-md-1,
.ez-wdt- py-md-1 {
padding-bottom: 0.25rem !important;
}
.ez-wdt-pl-md-1,
.ez-wdt-px-md-1 {
padding-left: 0.25rem !important;
}

.ez-wdt-col-md {
-ms-flex-preferred-size: 0;
flex-basis: 0;
-ms-flex-positive: 1;
flex-grow: 1;
max-width: 100%;
}

.ez-wdt-col-md-auto {
-ms-flex: 0 0 auto;
flex: 0 0 auto;
width: auto;
max-width: none;
}

.ez-wdt-col-md-1 {
-ms-flex: 0 0 8.333333%;
flex: 0 0 8.333333%;
max-width: 8.333333%;
}

.ez-wdt-col-md-2 {
-ms-flex: 0 0 16.666667%;
flex: 0 0 16.666667%;
max-width: 16.666667%;
}



.ez-wdt-col-md-4 {
-ms-flex: 0 0 33.333333%;
flex: 0 0 33.333333%;
max-width: 33.333333%;
}

.ez-wdt-col-md-12 {
max-width: 100%;
}

.ez-wdt-container {
max-width: 720px;
}
}

@media (min-width: 992px) {
.ez-wdt-container {
max-width: 960px;
}
}

@media (min-width: 1200px) {
.ez-wdt-container {
max-width: 1140px;
}
}

.ez-wdt-form-control {
display: block;
width: 100%;
height: calc(2.25rem + 2px);
padding: 0.375rem 0.75rem;
font-size: 1rem;
line-height: 1.5;
color: #495057;
background-color: #fff;
background-clip: padding-box;
border: 1px solid #ced4da;
border-radius: 0.25rem;
transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
height:37px
}
.ez-wdt-btn {
display: inline-block;
font-weight: 400;
text-align: center;
white-space: nowrap;
vertical-align: middle;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
border: 1px solid transparent;
padding: 0.375rem 0.75rem;
font-size: 1rem;
line-height: 1.5;
border-radius: 0.25rem;
transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}


.ez-wdt-btn-block {
display: block;
width: 100%;
}

.ez-wdt-btn-block + .ez-wdt-btn-block {
margin-top: 0.5rem;
}

.ez-wdt-pr-1,
.ez-wdt-px-1 {
padding-right: 0.25rem !important;
}

.ez-wdt-align-items-end {
-webkit-box-align: end !important;
align-items: flex-end !important;
}

.ez-wdt-input-group {
position: relative;
display: -ms-flexbox;
display: flex;
-ms-flex-wrap: wrap;
flex-wrap: wrap;
-ms-flex-align: stretch;
align-items: stretch;
width: 100%;
}
.ez-wdt-input-group > .ez-wdt-form-control{
position: relative;
-webkit-box-flex: 1;
flex: 1 1 0%;
min-width: 0;
margin-bottom: 0;
}


input[type="submit"].ez-wdt-btn-block,
input[type="reset"].ez-wdt-btn-block,
input[type="button"].ez-wdt-btn-block {
width: 100%;
}

.ez-wdt-form-control:focus-visible {
outline: 0 !important;
}
.ez-wdt-col-12
{
position: relative;
width: 100%;
min-height: 1px;
padding-right: 15px;
padding-left: 15px;
}
{{--</style>--}}
