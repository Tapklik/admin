@extends('layouts.default')

@section('head_scripts')
    var obj = {id: '{!! $creatives['id'] !!}'}
@stop

@section('breadcrumbs')
    Manage Campaign Creatives
@stop

@section('content')
    <creatives></creatives>
@stop