@extends('layouts.default')

@section('breadcrumbs')
    Manage reports
@stop

@section('content')
<reports></reports>
@stop

@section('footer-js-header')
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/amcharts.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/serial.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/themes/light.js?ver=20170519-02'></script>
@stop
