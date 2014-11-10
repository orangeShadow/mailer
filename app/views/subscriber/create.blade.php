@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('SubscriberController@store')))}}
        <div class="form-group @if(!empty($errors->first('email'))) {{'has-error'}} @endif">
            {{Form::label(trans('subscriber.email'),'',array('class'=>'control-label'))}}
            {{Form::text('email','',array('class'=>'form-control'))}}
        </div>
        {{ Form::hidden('place','mailer')}}
        {{ Form::submit(trans('subscriber.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
    </div>
</div>
@stop