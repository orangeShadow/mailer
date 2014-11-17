@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('SubscriberController@store')))}}
            <?$emailError = $errors->first('email');?>
            <div class="form-group @if(!empty($emailError)) {{'has-error'}} @endif">
                {{Form::label(trans('subscriber.email'),'',array('class'=>'control-label'))}}
                {{Form::text('email','',array('class'=>'form-control'))}}
            </div>
           <div class="form-group">
               {{Form::label(trans('mailing.groups'),'',array('class'=>'control-label'))}}
               {{Form::select('group_id[]',Group::lists('title','id'),array(),array('class'=>'form-control','multiple'))}}
           </div>
            <div class="form-group">
            {{ Form::hidden('place','mailer')}}
            {{ Form::submit(trans('subscriber.create'),array('class'=>'btn btn-default'))}}
            </div>
        {{ Form::close()}}
    </div>
</div>
@stop