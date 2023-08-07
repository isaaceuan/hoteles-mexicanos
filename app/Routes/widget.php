<?php
header('Access-Control-Allow-Origin: *');

Route::get(
    '/{widget}',
    'Widgets\WidgetsController@boot'
)->name('app.widget');

Route::get(
    '/{widget}/template',
    'Widgets\WidgetsController@template'
)->name('app.widget.template');


Route::get(
    '/{widget}/style',
    'Widgets\WidgetsController@style'
)->name('app.widget.style');

Route::get(
    '/{widget}/script',
    'Widgets\WidgetsController@script'
)->name('app.widget.script');
