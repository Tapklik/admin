@extends('layouts.default')

@section('breadcrumbs')
    Manage creatives
@stop

@section('head_scripts')
    var obj = {id: '{!! $id !!}'}
@stop

@section('content')
    <div id="uploader" class="well">
        Drop files or click here
    </div>
@stop

@section('footer_scripts')
<script>
    $(function () {
        var myDropzone = $("#uploader").dropzone({
            url: '/campaigns/' + obj.id  + '/creatives/upload',
            paramName: 'creative',
            sending(file, xhr, formData) {
                formData.append("_token", window.Laravel.csrfToken);
            },
            success(xhr, response) {
                console.log(xhr);
                console.log(response);
            },
            complete(d) {
                console.log(d);
            }
        });

    });
</script>
@stop
