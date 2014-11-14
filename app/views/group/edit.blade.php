@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
@if(Session::has('group.edit'))
<div class="alert alert-success">
    {{Session::get('group.edit')}}
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('GroupController@update',array('id'=>$group->id)),'method'=>"PUT"))}}
        <?$titleError = $errors->first('title')?>
        <div class="form-group @if(!empty($titleError)) {{'has-error'}} @endif">
            {{Form::label(trans('group.title'),'',array('class'=>'control-label'))}}
            {{Form::text('title',$group->title,array('class'=>'form-control'))}}
        </div>
        <?$desc = $errors->first('desc')?>
        <div class="form-group @if(!empty($desc)) {{'has-error'}} @endif">
            {{Form::label(trans('group.desc'),'',array('class'=>'control-label'))}}
            {{Form::textarea('desc',$group->desc,array('class'=>'form-control'))}}
        </div>

        <hr>
        {{Form::submit(trans('group.save'),array('class'=>'btn btn-success'))}}
        <a class="btn btn-default" href="{{URL::action('GroupController@edit',array('id'=>$group->id))}}">{{trans('group.cancel')}}</a>
        {{ Form::close()}}
        <br>
    </div>
</div>
@stop
