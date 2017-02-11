<!DOCTYPE html>
<html lang="es">
	<head>
		<title>CMS - @yield('title')</title>
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="description" content="" />
		<meta name="author" content="Beeb.mx" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		
		{{--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">--}}
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('panel_assets/css/login.min.css') }}">
	</head>
	<body class="@yield('module')">
	
	@yield('content')
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="{{ asset('panel_assets/js/login.min.js') }}"></script>
	@yield('js')
	
	</body>
</html>
