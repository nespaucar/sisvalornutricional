<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <style>
        .widescreen, .smallscreen {
            /* la vieja sintaxis, obsoleta, pero todavía necesaria, prefijada, para Opera y Navegadores basados en Webkit */
            background: -prefix-linear-gradient(right top, #8BD0FA, white) !important;

            /* La nueva sintaxis necesaria para navegadores apegados al estandar (IE 10 y Firefox 10 en adelante), sin prefijo */
            background: linear-gradient(to bottom left, #8BD0FA, white) !important;
            background-image: url("{{ asset('assets/images/logo.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            height: auto;
            margin: auto;
        }
    </style>

    <link rel="shortcut icon" href="{{ asset('assets/images/icono.ico') }}">
    <title>Calculadora Nutricional</title>

    {!! Html::style('assets/css/bootstrap.min.css') !!}
    {!! Html::style('assets/css/core.css') !!}
    {!! Html::style('assets/css/icons.css') !!}
    {!! Html::style('assets/css/components.css') !!}
    {!! Html::style('assets/css/pages.css') !!}
    {!! Html::style('assets/css/menu.css') !!}
    {!! Html::style('assets/css/responsive.css') !!}
    {!! Html::script('assets/js/modernizr.min.js') !!}
</head>
<body>


