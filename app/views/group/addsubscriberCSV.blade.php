@extends('layouts.default')

@section('title')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::to('/addSubscriberCSV'),'method'=>"POST",'files'=>true))}}
            {{Form::select('group_id',Group::lists('title','id'))}}
            {{Form::file('csv')}}
        {{ Form::token()}}
        {{ Form::submit(trans('templates.create'),array('class'=>'btn btn-default'))}}
        {{ Form::close()}}
        <br>
    </div>
</div>
@stop
