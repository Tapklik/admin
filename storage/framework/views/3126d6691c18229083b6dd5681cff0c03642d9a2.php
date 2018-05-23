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
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;

        <?php echo $__env->yieldContent('head_scripts'); ?>
    </script>
</head>
<body>
    <header class="clearfix">
    <div class="col-md-2">
        <h1>
            <img src="//tapklik.com/assets/images/logo.png" alt="Logo" />
        </h1>
    </div>
    <div class="col-md-10">
        <nav>
            <ul>
                <li class="">

                </li>
            </ul>
        </nav>
    </div>
</header>

    <main id="app">
        <div class="container-fluid">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <?php echo $__env->make('layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('modals'); ?>

    <script type='text/javascript' src='https://www.amcharts.com/lib/3/amcharts.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/serial.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/themes/light.js?ver=20170519-02'></script>

    <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>

    <script src="/js/app.js"></script>
    <script src="/js/all.js"></script>

    <?php echo $__env->yieldContent('footer_scripts'); ?>
</body>
</html>
