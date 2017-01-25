@extends('layouts.default')

@section('breadcrumbs')
    Edit campaign
@stop

@section('head_scripts')
    var obj = {id: '{!! $id !!}'}
@stop

@section('content')
    <campaigns-show></campaigns-show>
@stop