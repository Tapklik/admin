@extends('layouts.default')

@section('head_scripts')
    var obj = {id: '{!! $cid !!}'};
@stop

@section('breadcrumbs')
    See creatives
@stop

@section('content')
    <campaign-creatives></campaign-creatives>
@stop