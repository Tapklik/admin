@extends('layouts.default')

@section('head_scripts')
    var obj = {id: {!! $account['id'] !!}}
@stop

@section('breadcrumbs')
    Manage campaigns
@stop

@section('content')
<campaigns></campaigns>
@stop