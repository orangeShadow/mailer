@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('GroupController@store')))}}
            <?$titleError = $errors->first('title')?>
            <div class="form-group @if(!empty($titleError)) {{'has-error'}} @endif">
                {{Form::label(trans('group.title'),'',array('class'=>'control-label'))}}
                {{Form::text('title','',array('class'=>'form-control'))}}
            </div>
            <?$desc = $errors->first('desc')?>
            <div class="form-group @if(!empty($desc)) {{'has-error'}} @endif">
                {{Form::label(trans('group.desc'),'',array('class'=>'control-label'))}}
                {{Form::textarea('desc','',array('class'=>'form-control'))}}
            </div>
            {{ Form::submit(trans('group.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
    </div>
</div>
@stop