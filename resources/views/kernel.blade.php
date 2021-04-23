<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME', 'Burger Queen') }}</title>

    @include('inc.stylesheets')

</head>

<body class="h-100">
    <div id="app" class="wrapper">

        @include('inc.navbar')
        @yield('content')
        @auth
{{--            for notification --}}
            <order-update
                :user-uid="'{{ \Illuminate\Support\Facades\Auth::user()->uid }}'"
            ></order-update>
        @endauth
    </div>
    @include('inc.footer')

    @include('inc.script')
</body>

</html>
