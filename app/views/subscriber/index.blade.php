@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('subscriber.create'))
        <div class="alert alert-info">{{Session::get('subscriber.create')}}</div>
        @endif
        @if(Session::has('subscriber.destroy'))
        <div class="alert alert-info">{{Session::get('subscriber.destroy')}}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>{{trans('email')}}</th>
                    <th style="width:150px;">{{trans('subscriber.createAt')}}</th>
                    <th style="width:50px;"></th>
                </tr>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>
                        {{Form::open(array('method'=>"get"))}}
                            {{Form::input('text','email',Input::get('email',null))}}
                        {{Form::close()}}
                    </th>
                    <th style="width:150px;"></th>
                    <th style="width:50px;"></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($subscribers))
                @foreach($subscribers as $subscriber)
                <tr>
                    <td>{{$subscriber->id}}</td>
                    <td>{{$subscriber->email}}</td>
                    <td>{{$subscriber->created_at}}</td>
                    <td>
                        <?/*<a href="{{URL::action('SubscriberController@edit',array('id'=>$subscriber->id))}}" class="btn btn-default btn-mini"><i class="fa fa-edit"></i></a>*/   ?>
                        {{Form::open(array('url' => URL::action('SubscriberController@destroy',array('id'=>$subscriber->id)), 'method' => 'delete','style'=>'display:inline-block')) }}
                        <button onClick="if(!confirm('{{trans('subscriber.messageDelete')}}')) return false;" type="submit" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></button>
                        {{Form::close();}}
                    </td>
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
        {{$subscribers->links()}}
    </div>
</div>
@stop