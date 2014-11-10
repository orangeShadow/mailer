@extends('layouts.default')

@section('title')
{{trans('mailing.createMailing')}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('MailingController@store')))}}
            <div class="form-group @if(!empty($errors->first('title'))) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.title'),'',array('class'=>'control-label'))}}
                {{Form::text('title','',array('class'=>'form-control'))}}

            </div>
            <div class="form-group @if(!empty($errors->first('template_id'))) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.template'),'',array('class'=>'control-label'))}}
                {{Form::select('template_id',Template::lists('title','id'),false,array('class'=>'form-control'))}}
            </div>
            <div class="form-group @if(!empty($errors->first('group_id'))) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.groups'),'',array('class'=>'control-label'))}}
                {{Form::select('group_id[]',Group::lists('title','id'),false,array('class'=>'form-control','multiple'))}}
            </div>
            <div class="form-group @if(!empty($errors->first('content'))) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.content'),'',array('class'=>'control-label'))}}
                {{Form::textarea('content','',array('class'=>'form-control redactor'))}}
            </div>
            <div class="form-group @if(!empty($errors->first('template_id'))) {{'has-error'}} @endif">
        {{Form::token()}}
        {{ Form::submit(trans('mailing.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
    </div>
</div>
@stop