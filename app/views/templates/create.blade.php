@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('TemplatesController@store')))}}
        <div class="form-group @if(!empty($errors->first('title'))) {{'has-error'}} @endif">
            {{Form::label(trans('templates.Title'),'',array('class'=>'control-label'))}}
            {{Form::text('title','',array('class'=>'form-control'))}}
        </div>
        <div class="form-group">
            {{Form::label(trans('templates.MetaInfo'),'',array('class'=>'control-label'))}}
            {{Form::textarea('meta','',array('class'=>'form-control'))}}
        </div>
        <div class="form-group">
            {{Form::label(trans('templates.Stylesheet'),'',array('class'=>'control-label'))}}
            {{Form::textarea('css','',array('class'=>'form-control'))}}
            <div style="height:300px; margin: 10px;" id="css"/>
        </div>
        <div class="form-group">
            {{Form::label(trans('templates.Header'),'',array('class'=>'control-label'))}}
            {{Form::textarea('header','',array('class'=>'form-control'))}}
            <div style="height:300px; margin: 10px;" id="header"/>
        </div>
        <div class="form-group">
            {{Form::label(trans('templates.Footer'),'',array('class'=>'control-label'))}}
            {{Form::textarea('footer','',array('class'=>'form-control'))}}
            <div style="height:300px; margin: 10px;" id="footer"/>
        </div>

        <hr>
        {{ Form::token()}}
        {{ Form::submit(trans('templates.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
        <br>
    </div>
</div>
@stop
