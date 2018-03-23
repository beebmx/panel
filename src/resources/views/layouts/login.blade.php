<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
	<head>
		<title>CMS - @yield('title')</title>
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="description" content="CMS for @yield('title') made by Beeb.mx" />
		<meta name="author" content="Beeb.mx" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/panel-login.css') }}">
		<script defer src="{{ asset('js/fontawesome.js') }}"></script>
	</head>
<body class="@yield('module')">
	
	@yield('content')
	
	<script src="{{ asset('js/panel-login.js') }}"></script>
	@yield('js')
	
</body>
</html>
