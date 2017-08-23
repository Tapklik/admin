@extends('layouts.default')

@section('breadcrumbs')
    Manage creatives
@stop

@section('head_scripts')
    var obj = {id: '{!! $id !!}'}
@stop

@section('content')
    <creative-show></creative-show>
@stop
