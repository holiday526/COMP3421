<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME').' Admin Page' }}</title>

    <meta name="_token" content="{!! csrf_token() !!}"/>

    @include('inc.stylesheets')

</head>

<body class="h-100">
    <div id="app" class="wrapper">
        @include('admin.inc.navbar')
        @yield('content')
    </div>

    <b-footer class="py-4 bg-dark sticky-footer">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Burger Queen<sup>Reborn</sup> 2021</p>
        </div>
    </b-footer>

    @include('inc.script')
</body>

</html>
