<!DOCTYPE html>
<html>
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
	            background-attachment: fixed !important;
			  	background-repeat: no-repeat !important;
			  	background-position: center !important;
	        }
	        .notifyjs-corner {
	        	z-index: 10000 !important;
	        }
	        .page-title {
	        	color: #32408F;
	        }
	        .side-menu {
	        	z-index: 500 !important;
	        }
	        .pagination {
	        	z-index: -1000 !important;
	        }
	        .flotante {
			    display:scroll;
			    position:fixed;
			    bottom:50px;
			    right:50px;
			    z-index: -10;
			    opacity: 0.6;
			}
			.content-page {
				min-height:100vh !important;
			}
			.pagination li {
				cursor: pointer !important;
			}
	    </style>

        <link rel="shortcut icon" href="{{ asset('assets/images/icono.ico') }}">

        <title>Sistema de Gestión de Pagos</title>

        {!! Html::style('plugins/switchery/switchery.min.css') !!}

    

