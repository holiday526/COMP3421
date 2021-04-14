<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME') }}</title>

    @include('inc.stylesheets')

</head>

<body>
    <div id="app">

        @include('inc.navbar')

        @yield('content')

        @include('inc.footer')
    </div>

    @include('inc.script')
</body>

</html>
