@extends('layouts.default')

@section('title')
{{trans('mailing.createMailing')}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('mailing.create'))
        <div class="alert alert-info">{{Session::get('mailing.edit')}}</div>
        @endif
        {{ Form::open(array('url' => URL::action('MailingController@update',array("id"=>$mailing->id)),'method'=>"PUT","files"=>"true"))}}
            <?$titleError = $errors->first('title')?>
            <div class="form-group @if(!empty($titleError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.title'),'',array('class'=>'control-label'))}}
                {{Form::text('title',$mailing->title,array('class'=>'form-control'))}}
            </div>
            <?$fromEmailError = $errors->first('from_email')?>
            <div class="form-group @if(!empty($fromEmailError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.from_email'),'',array('class'=>'control-label'))}}
                <?$defaultFrom = Config::get('mail.from')["address"];?>
                {{Form::text('from_email',Input::get('from_email',!empty($mailing->from_email)?$mailing->from_email:$defaultFrom),array('class'=>'form-control'))}}
            </div>
            <?$commentError = $errors->first('comment')?>
            <div class="form-group @if(!empty($commentError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.comment'),'',array('class'=>'control-label'))}}
                {{Form::textarea('comment',$mailing->comment,array('class'=>'form-control'))}}
            </div>

            <?$templateError = $errors->first('template_id')?>
            <div class="form-group @if(!empty($templateError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.template'),'',array('class'=>'control-label'))}}
                {{Form::select('template_id',Template::lists('title','id'),Input::get('template_id',$mailing->template_id),array('class'=>'form-control'))}}
            </div>
            <?$groupTemplate = $errors->first('group_id')?>
            <div class="form-group @if(!empty($groupTemplate)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.groups'),'',array('class'=>'control-label'))}}
                {{Form::select('group_id[]',Group::lists('title','id'),explode(',',$mailing->groups),array('class'=>'form-control','multiple'))}}
            </div>
            <?$contentError = $errors->first('content');?>
            <div class="form-group @if(!empty($contentError)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.content'),'',array('class'=>'control-label'))}}
                {{Form::textarea('content',$mailing->content,array('class'=>'form-control redactor'))}}
            </div>
            <?$contentFile = $errors->first('file_path');?>
            <div class="form-group @if(!empty($contentFile)) {{'has-error'}} @endif">
                {{Form::label(trans('mailing.file'),'',array('class'=>'control-label'))}}
                {{Form::file('file_path','',array('class'=>'form-control'))}}
                @if(!empty($mailing->file_path))
                {{$mailing->file_path}}
                    <a id="removeFile" data-id="{{$mailing->id}}" href="#!"><i  class="glyphicon glyphicon-remove"></i> Удалить файл</a>
                @endif
            </div>
            <div class="form-group">
                {{Form::token()}}
                {{ Form::submit(trans('mailing.save'),array('class'=>'btn btn-default'))}}
                <a target="_blank" class="btn btn-primary" href="{{URL::action('MailingController@show',array('id'=>$mailing->id))}}">{{trans('templates.preview')}}</a>
            </div>
        {{ Form::close()}}
    </div>
</div>
@stop