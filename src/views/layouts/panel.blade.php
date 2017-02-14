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
        
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('panel_assets/css/panel.min.css') }}">
	</head>
	<body class="beebmx-panel @yield('module')">
	<nav class="pushy pushy-left">
    	<header></header>
    	<div class="brand">
        	@if (config('panel.logo') !== null)
            <a class="logo" href="{{ url(config('panel.prefix')) }}"><img src="{{ asset(config('panel.logo')) }}" alt="{{ config('panel.name') }}" /></a>
            @endif
            <div class="title">{{ config('panel.name') }}</div>
    	</div>
        <ul class="sidebar-links">
            @foreach($models as $model)
                @if (!$model->isChildren())
        	<li class="pushy-link">
        	    @if ($model->type === 'external')
        	    <a href="{{ $model->url }}">
                @else
                <a href="{{ url(config('panel.prefix').'/page/'.$model->url) }}">
                @endif
                	<div class="link">
                    	<div class="link-icon">{!! $model->icon !!}</div>
                	    <div class="link-text">{{ $model->name }}</div>
                	</div>
                </a>
            </li>
                @endif
        	@endforeach
        	<li>
        	    <form action="{{ url(config('panel.prefix').'/logout') }}" method="post">
            	    {{ csrf_field() }}
            	    <button type="submit">
                    	<div class="link">
                        	<div class="link-icon"><i class="material-icons">chevron_right</i></div>
                    	    <div class="link-text">Cerrar sesión</div>
                    	</div>
            	    </button>
        	    </form>
            </li>
        </ul>
    </nav>
	<div class="site-overlay"></div>
	<div id="container">
    	<header>
        	<div class="container-fluid">
            	<div class="row">
                	<div class="hidden-md hidden-lg col-xs-2">
                    	<a class="menu-btn" href="#"><i class="material-icons">view_headline</i></a>
                	</div>
                	<div class="hidden-xs hidden-sm col-xs-2">
                    	<a class="menu-bar" href="#"><i class="material-icons">view_headline</i></a>
                	</div>
                	<div class="col-xs-8">
                    	<div class="title">{{ config('panel.name') }}</div>
                	</div>
            	</div>
        	</div>
    	</header>
    	<nav class="sidebar">
        	<div class="brand">
            	@if (config('panel.logo') !== null)
                <a class="logo" href="{{ url(config('panel.prefix')) }}"><img src="{{ asset(config('panel.logo')) }}" alt="{{ config('panel.name') }}" /></a>
                @endif
                <div class="title">{{ config('panel.name') }}</div>
        	</div>
        	<ul class="sidebar-links">
            	@foreach($models as $model)
            	    @if (!$model->isChildren())
            	<li>
            	    @if ($model->type === 'external')
            	    <a href="{{ $model->url }}">
                    @else
                    <a href="{{ url(config('panel.prefix').'/page/'.$model->url) }}">
                    @endif
                    	<div class="link">
                        	<div class="link-icon">{!! $model->icon !!}</div>
                    	    <div class="link-text">{{ $model->name }}</div>
                    	</div>
                    </a>
                </li>
                    @endif
            	@endforeach
            	<li>
            	    <form action="{{ url(config('panel.prefix').'/logout') }}" method="post">
                	    {{ csrf_field() }}
                	    <button type="submit">
                        	<div class="link">
                            	<div class="link-icon"><i class="material-icons">chevron_right</i></div>
                        	    <div class="link-text">Cerrar sesión</div>
                        	</div>
                	    </button>
            	    </form>
                </li>
        	</ul>
    	</nav>
    	<div class="panel-content">
            @yield('content')
            <br />
    	</div>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="{{ asset('panel_assets/js/panel.min.js') }}"></script>
    <script language="javascript">
    $(document).ready(function() {
    	Panel.init();
    });
    </script>
	@yield('js')
	
	</body>
</html>
