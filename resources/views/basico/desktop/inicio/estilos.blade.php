.sticky > div {
    min-height:400px;
}
.sticky{
    position: -webkit-sticky;
    position: sticky;
    top: 0;
}

.border-acento {
    border-color: <?=$marca->color_acento?> !important;
}

.custom-radio .custom-control-input:checked ~ .custom-control-label::before{
    background-color: <?=$marca->color_acento?> !important;
    border-color: <?=$marca->color_acento?> !important;
}

.custom-control-input:focus ~ .custom-control-label::before{
box-shadow: 0 0 10px <?=$marca->color_acento_hover?> !important;
}

.btn-primary {
background-color: <?=$marca->color_acento?> !important;
border-color: <?=$marca->color_acento?> !important;
color: #fff !important;
}

.badge-primary {
background-color: <?=$marca->color_acento?> !important;
color: #fff !important;
}


.btn-primary:hover,
.btn-primary:focus{
background-color: <?=$marca->color_acento_hover?> !important;
border-color: <?=$marca->color_acento_hover?> !important;
}


.btn-return a:hover, .btn-return a:focus, .btn-return i:hover {
color: <?=$marca->color_acento_hover?> !important;
}

.dropdown-item.active{
color:#fff !important;
background-color: <?=$marca->color_acento?> !important;
}

.bg-acento{
background-color: <?=$marca->color_acento?> !important;
}

.bg-acento-hover{
    background-color: <?=$marca->color_acento_hover?> !important;
}

.color-acento{
color: <?=$marca->color_acento?> !important;
}

.Cpromocion a {
color: <?=$marca->color_acento?> !important;
}

footer .list-unstyled a {
color: <?=$marca->color_acento?> !important;
}

footer .by a {
color: <?=$marca->color_acento?>;
}

footer .btn-default {
color: <?=$marca->color_acento?> !important;
}

footer .btn-default:hover {
color: <?=$marca->color_acento_hover?>;
}

.form-control:focus{
border-color:<?=$marca->color_acento_hover?> !important;
box-shadow: 0 0 10px <?=$marca->color_acento_hover?> !important;
}

.mbsc-mobiscroll .mbsc-cal-btn-txt, .mbsc-mobiscroll .mbsc-cal-days th, .mbsc-mobiscroll .mbsc-cal-days, .mbsc-mobiscroll .mbsc-cal-hl-now .mbsc-cal-today, .mbsc-mobiscroll .mbsc-fr-btn {
color: <?=$marca->color_acento?> !important
}
.mbsc-mobiscroll .mbsc-fr-btn-a {
background-color: <?=$marca->mobilscroll_acento_hover?> !important
}

.mbsc-mobiscroll .mbsc-cal-days th {
border-bottom-color: <?=$marca->color_acento?> !important
}

.mbsc-mobiscroll .mbsc-cal .mbsc-cal-day-sel .mbsc-cal-day-i {
background-color: <?=$marca->color_acento?> !important
}

.mbsc-mobiscroll .mbsc-cal .mbsc-cal-sc-sel .mbsc-cal-sc-cell-i, .mbsc-mobiscroll .mbsc-cal .mbsc-cal-day-sel .mbsc-cal-day-i {
background-color: <?=$marca->color_acento?> !important;
color: #fff !important;
}

.mbsc-mobiscroll .mbsc-range-btn-sel .mbsc-range-btn{
background-color: <?=$marca->color_acento?> !important;
}

.mbsc-mobiscroll .mbsc-range-btn{
border-color: <?=$marca->color_acento?> !important;
}


.mbsc-mobiscroll .mbsc-cal-day-closed:after, .mbsc-mobiscroll .mbsc-cal-day-closed:before {
background-color: torgb(<?=$marca->color_acento?>, .6);
}

.mbsc-mobiscroll .mbsc-fr-hdr, .mbsc-mobiscroll .mbsc-sc-btn {
color: <?=$marca->color_acento?> !important
}

.mbsc-mobiscroll .mbsc-sc-whl-l {
border-color: <?=$marca->color_acento?> !important
}

#steps li a {
text-decoration: none;
color: <?=$marca->color_acento?> !important;
}

#steps li.complete {
background-color: <?=$marca->color_acento?>;
border-right: 1px solid <?=$marca->color_acento?>;
}

#steps li.complete div:after {
border-left-color: <?=$marca->color_acento?> !important;
}

.dropdown-item:hover, .dropdown-item:focus {
background-color: <?=$marca->color_acento?> !important;
}

#opcionesAgrupar > .dropdown-item.active,
#opcionesAgrupar > .dropdown-item:active{
color:#fff !important;
background-color: <?=$marca->color_acento?> !important;
}

.menuDetalle .nav-link.active:first-child {
color: <?=$marca->color_acento?> !important;
}

.menuDetalle .nav-link.active {
color: <?=$marca->color_acento?> !important;
}

.menuDetalle .nav-link:hover {
color: <?=$marca->color_acento?> !important;
}

.columna.dia.esEntrada{
background: <?=$marca->color_acento_restriccion_entrada?> !important;
}

.columna.dia.esEstancia{
background: <?=$marca->color_acento_restriccion_entrada?> !important;
}

.columna.dia.esSalida{
background: <?=$marca->color_acento_restriccion_salida?> !important;
}

.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before{
background-color: <?=$marca->color_acento?> !important;
border-color: <?=$marca->color_acento_hover?> !important;
}

.text-acento {
color: <?=$marca->color_acento?> !important;
}

.text-danger {
color: #e04040 !important;
}

.contentMenu #menu .btn-default{
color: <?=$marca->color_acento?> !important;
}

.contentMenu #menu .btn-default:hover{
color: <?=$marca->color_acento?> !important;
}


{{--
.sidebar .btn:focus,
input[type="text"]:focus, textarea:focus, select:focus, .bootstrap-select .dropdown-toggle:focus {
    border: 1px solid <?=$marca->color_acento_hover?> !important;
    outline: 0 !important;
    -webkit-box-shadow: inset 0 1px 1px <?=$marca->color_acento_hover?>;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
    -moz-box-shadow:   inset 0 1px 1px <?=$marca->color_acento_hover?>;  /* Firefox 3.5 - 3.6 */
    box-shadow:       inset 0 1px 1px <?=$marca->color_acento_hover?>;  /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
}
--}}




