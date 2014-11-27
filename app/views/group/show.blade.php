@extends('layouts.default')

@section('title')
{{$group->title}}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-2">
            <b>{{trans('group.desc')}}:</b>
        </div>
        <div class="col-lg-10">
            {{$group->desc}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <b>{{trans('group.countSubs')}}</b>
        </div>
        <div class="col-lg-10">
            {{$count}}
        </div>
    </div>
@stop
