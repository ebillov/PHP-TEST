<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <!-- Scripts -->
    <script src="{{ app_url('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ app_url('App/Assets/custom.js') }}" defer></script>
    <script src="{{ app_url('node_modules/bootstrap/dist/js/bootstrap.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ app_url('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ app_url('App/Assets/custom.css') }}" rel="stylesheet">
</head>
<body>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
