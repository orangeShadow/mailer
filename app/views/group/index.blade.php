@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('group.create'))
        <div class="alert alert-info">{{Session::get('group.create')}}</div>
        @endif
        @if(Session::has('group.destroy'))
        <div class="alert alert-info">{{Session::get('group.destroy')}}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>{{trans('title')}}</th>
                    <th style="width:150px;">{{trans('group.desc')}}</th>
                    <th style="width:150px;">Кол-во</th>
                    <th style="width:150px;"></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($groups))
                @foreach($groups as $group)
                <tr>
                    <td>{{$group->id}}</td>
                    <td>{{$group->title}}</td>
                    <td>{{$group->updated_at}}</td>
                    <td><?$res = DB::select(DB::raw("SELECT count(*) as c FROM subscriber_group as sg LEFT JOIN subscribers as s  on s.id = sg.subscriber_id and deleted_at is null WHERE group_id=".$group->id));echo $res[0]->c;?></td>
                    <td>
                        <a href="{{URL::action('GroupController@edit',array('id'=>$group->id))}}" class="btn btn-default btn-mini"><i class="fa fa-edit"></i></a>
                        <a href="{{URL::action('GroupController@show',array('id'=>$group->id))}}" class="btn btn-default btn-mini" target="_blank"><i class="fa fa-eye"></i></a>
                        {{Form::open(array('url' => URL::action('GroupController@destroy',array('id'=>$group->id)), 'method' => 'delete','style'=>'display:inline-block')) }}
                        <button onClick="if(!confirm('{{trans('group.messageDelete')}}')) return false;" type="submit" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></button>
                        {{Form::close();}}
                    </td>
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop