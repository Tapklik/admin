@extends('layouts.default')

@section('head_scripts')
    var obj = {id: '{!! $cid !!}'};
@stop

@section('breadcrumbs')
    Edit campaign
@stop

@section('content')
    <campaign></campaign>
@stop