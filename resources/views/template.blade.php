<!DOCTYPE html>
<!--
Template Name: Compassuite - All in one
Version: 1.0
Author: Bloonde
Website: http://www.bloonde.com/
-->
<!--[if IE 8]>
<html lang="es" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="es" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>

    <!-- start: Meta -->
    <meta charset="utf-8">
    <title>Scrum Bloonde - @yield('title')</title>
    <meta name="description" content="Bootstrap Metro Dashboard">
    <meta name="author" content="Dennis Ji">
    <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <!-- end: Meta -->

    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end: Mobile Specific -->

    <!-- start: CSS -->
    <link id="bootstrap-style" href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/bootstrap-responsive.min.css')}}" rel="stylesheet">
    <link id="base-style" href="{{URL::asset('css/style.css')}}" rel="stylesheet">
    <link id="base-style-responsive" href="{{URL::asset('css/style-responsive.css')}}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
    <!-- end: CSS -->


    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link id="ie-style" href="css/ie.css" rel="stylesheet">
    <![endif]-->

    <!--[if IE 9]>
    <link id="ie9style" href="css/ie9.css" rel="stylesheet">
    <![endif]-->

    <!-- start: Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- end: Favicon -->

    <script src="{!! asset('js/jquery.js') !!}"></script>

    <script src="{!! asset('js/jquery-scrolltofixed.js') !!}"></script>
    <script src="{!! asset('js/noty/packaged/jquery.noty.packaged.js') !!}"></script>
    <script src="{!! asset('js/noty/layouts/top.js') !!}"></script>
    <script src="{!! asset('js/noty/layouts/topLeft.js') !!}"></script>
    <script src="{!! asset('js/noty/layouts/topRight.js') !!}"></script>


    <script src="{!! asset('js/contextMenu/src/jquery.ui.position.js') !!}"></script>
    <script src="{!! asset('js/contextMenu/src/jquery.contextMenu.js') !!}"></script>
    <script src="{!! asset('js/contextMenu/prettify/prettify.js') !!}"></script>
    <link href="{!! asset('js/contextMenu/src/jquery.contextMenu.css') !!}" rel="stylesheet">
    <link href="{{URL::asset('css/style-responsive.css')}}" >


    <script type="text/javascript">
        function notificar(texto) {
            var n = noty({
                text: texto,
                theme: 'relax',
                type: 'information',
                layout: 'topCenter',
                timeout: 6000
            });
        }
        function notificarError(texto) {
            var n = noty({
                text: texto,
                type: 'error',
                theme: 'relax',
                layout: 'topCenter',
                timeout: 6000
            });
        }
    </script>



</head>
<body class="page-header-fixed page-container-bg-solid page-md page-sidebar-fixed">

@include('header')

<div class="container-fluid-full">
    <div class="row-fluid">
        @include("sidebar")
        <div id="content" class="span10">
            @yield('content')
        </div>
    </div>
</div>

@include('footer')
@include('validaciones')

<script src="{!! asset('js/bootstrap.min.js') !!}"></script>


</body>
</html>
