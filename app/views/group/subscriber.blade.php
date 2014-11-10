@extends('layouts.default')

@section('title')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::to('/groupToSubscribe'),'method'=>"POST"))}}
           {{Form::select('group_id',Group::lists('title','id'))}}
           {{Form::select('subscriber_id[]',Subscriber::lists('email','id'),false,array('multiple'))}}
        {{ Form::token()}}
        {{ Form::submit(trans('templates.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
        <br>
    </div>
</div>
@stop
