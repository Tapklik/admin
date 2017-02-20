<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tapklik Admin</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/font-awesome.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/all.css" />

    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" />

    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};

        @yield('head_scripts')
    </script>
</head>
<body>
    @include('layouts.partials.header')
    @include('layouts.partials.breadcrumbs')

    <main id="app">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.footer')

    @yield('modals')

    <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>

    <script src="/js/app.js"></script>
    <script src="/js/all.js"></script>

    @yield('footer_scripts')
</body>
</html>
