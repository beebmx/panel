<!DOCTYPE html>
<html>
    <head>
        <title>CMS :: {{ config('panel.name') }} </title>

        <meta name="description" content="CMS for {{ config('panel.name') }} made by Beeb.mx" />
        <meta name="author" content="Beeb.mx" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('css/panel-app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
        <script defer src="{{ asset('js/fontawesome.js') }}"></script>
<script>
    window.panel = {"token":"{{ csrf_token() }}","base":"{{ config('panel.prefix') }}","baseURL":"{{ url(config('panel.prefix')) }}"};
</script>
    </head>

    <body class="beebmx-panel">
        <div id="root" api="{{ url(config('panel.prefix') . '/api') }}"></div>
        <script src="{{ asset('js/panel-app.js') }}"></script>
    </body>
</html>
