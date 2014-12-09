@extends('layouts.default')

@section('title')
{{trans('mailing.createMailing')}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('MailingController@store'),"files"=>"true"))}}
            <?$titleError = $errors->first('title')?>
            <div class="form-group @if(!empty($titleError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.title'),'',array('class'=>'control-label'))}}
                {{Form::text('title',Input::get('title'),array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label(trans('mailing.comment'),'',array('class'=>'control-label'))}}
                {{Form::textarea('comment',Input::get('comment'),array('class'=>'form-control'))}}
            </div>
            <?$templateError = $errors->first('template_id')?>
            <div class="form-group @if(!empty($templateError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.template'),'',array('class'=>'control-label'))}}
                {{Form::select('template_id',Template::lists('title','id'),false,array('class'=>'form-control'))}}
            </div>
            <?$groupTemplate = $errors->first('group_id')?>
            <div class="form-group @if(!empty($groupTemplate)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.groups'),'',array('class'=>'control-label'))}}
                {{Form::select('group_id[]',Group::lists('title','id'),false,array('class'=>'form-control','multiple'))}}
            </div>
            <?$contentError = $errors->first('content');?>
            <div class="form-group @if(!empty($contentError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.content'),'',array('class'=>'control-label'))}}
                {{Form::textarea('content','',array('class'=>'form-control redactor'))}}
            </div>
            <?$contentFile = $errors->first('file_path');?>
            <div class="form-group @if(!empty($contentFile)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.file_path'),'',array('class'=>'control-label'))}}
                {{Form::file('file_path','',array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
            {{Form::token()}}
            {{ Form::submit(trans('mailing.create'),array('class'=>'btn btn-default'))}}
            </div>
        {{ Form::close()}}
    </div>
</div>
@stop