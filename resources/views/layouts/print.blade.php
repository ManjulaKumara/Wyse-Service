<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wyse Service</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('print/assets/media/image/favicon.png') }}"/>

    <!-- Plugin styles -->
    <link rel="stylesheet" href="{{ url('print/vendors/bundle.css') }}" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ url('print/assets/css/app.min.css') }}" type="text/css">
</head>
<body class="bg-white">

    @yield('content')


    <!-- Plugin scripts -->
<script src="{{ url('print/vendors/bundle.js') }}"></script>

<!-- App scripts -->
<script src="{{ url('print/assets/js/app.min.js') }}"></script>
@yield('after_scripts')
</body>
</html>
