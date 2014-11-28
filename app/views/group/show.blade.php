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
    @if(!empty($subscribers))
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr><th>ID</th><th>EMAIL</th></tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->email}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$subscribers->links();}}
        </div>
    </div>
    @endif
@stop
