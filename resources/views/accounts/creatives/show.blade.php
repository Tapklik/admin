@extends('layouts.default')

@section('breadcrumbs')
    Show Creative {{ $creativeUuId }}
@stop

@section('content')
    <creative-show></creative-show>
@stop
