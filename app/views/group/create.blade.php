@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('GroupController@store')))}}
            <div class="form-group @if(!empty($errors->first('title'))) {{'has-error'}} @endif">
                {{Form::label(trans('group.title'),'',array('class'=>'control-label'))}}
                {{Form::text('title','',array('class'=>'form-control'))}}
            </div>
            <div class="form-group @if(!empty($errors->first('desc'))) {{'has-error'}} @endif">
                {{Form::label(trans('group.desc'),'',array('class'=>'control-label'))}}
                {{Form::textarea('desc','',array('class'=>'form-control'))}}
            </div>
            {{ Form::submit(trans('group.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
    </div>
</div>
@stop