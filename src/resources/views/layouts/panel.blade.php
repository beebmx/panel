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
        <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
        <script defer src="{{ asset('js/fontawesome.js') }}"></script>
		@yield('css')
		@yield('style')
	</head>
<body class="beebmx-panel @yield('module')">
    <nav id="navbar" class="navbar ">
        <div class="navbar-brand">
            <div class="navbar-burger burger" @click="slidebarToggle" :class="{'is-active':isOpen}">
                <span></span><span></span><span></span>
            </div>
            <div class="navbar-title is-hidden-desktop">{{ config('panel.name') }}</div>
            <figure class="navbar-image">
                <img src="{{ asset(config('panel.logo')) }}" alt="{{ config('panel.name') }}" />
            </figure>
            <div class="navbar-title is-hidden-touch">{{ config('panel.name') }}</div>
        </div>
        
        <div class="navbar-menu">
            <div class="navbar-end">
                @foreach (config('panel.social') as $social)
                <a href="{{ $social['url'] }}" class="navbar-item" target="_blank">
                    <span class="icon"><i class="fab fa-{{ $social['icon'] }} fa-lg"></i></span>
                </a>
                @endforeach
            </div>
        </div>
    </nav>
    <div id="root" class="section">
        <div class="container panel-top-container">
            <div class="columns">
                <panel-sidebar class='column is-2-desktop' dashboard='{{ route("panel.dashboard") }}' :options='{{ $models->toJson() }}'>
                </panel-sidebar>
                <div class="column panel-pusher">
                @yield('content')
                </div>
            </div>
        </div>
    </div>

{{-- <div id="sidebar" class="panel-main-container {{ config('panel.sidebarEffect') }}" :class="{'sidebar-open':isOpen}">

        <nav class="panel-menu">
            <h2 class="subtitle">Sidebar</h2>
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
                            <div class="icon is-small"><i class="fal fa-{!! $model->icon !!}"></i></div>
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
                                <div class="icon is-small"><i class="fal fa-chevron-right"></i></div>
                                <div class="link-text">@lang('panel::panel.logout')</div>
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
</div>        
        <div class="panel-pusher">
            <header>
                <nav class="nav">
                    <div class="nav-left is-hidden-mobile">
                        <a class="logo nav-item">
                            
                        </a>
                    </div>
                    <a href="#" class="nav-toggle" @click.prevent="slideBarToggle">
                        <span></span><span></span><span></span>
                    </a>
                    <div class="nav-right is-hidden-tablet">
                        <div class="title is-spaced">{{ config('panel.name') }}</div>
                    </div>
                    <div class="nav-center is-hidden-mobile">
                        <div class="title">{{ config('panel.name') }}</div>
                    </div>
                    <div class="nav-right nav-menu">
                        @foreach (config('panel.social') as $social)
                        <a href="{{ $social['url'] }}" class="nav-item" target="_blank">
                            <span class="icon is-small"><i class="fab fa-{{ $social['icon'] }}"></i></span>
                        </a>
                        @endforeach
                  </div>
                </nav>
            </header>
            <div class="panel-main-content">
                <div class="panel-general-content">
                    @yield('content')
                </div>
            </div>
        </div> --}}

@yield('jsrequired')
<script src="{{ asset('js/app.js') }}"></script>
<script>
/*
$(document).ready(function(){
//Panel.init();
});
*/
</script>
@yield('js')
</body>
</html>
