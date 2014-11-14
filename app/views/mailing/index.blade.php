@extends('layouts.default')

@section('title')
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('mailing.create'))
        <div class="alert alert-info">{{Session::get('mailing.create')}}</div>
        @endif
        @if(Session::has('mailing.destroy'))
        <div class="alert alert-info">{{Session::get('mailing.destroy')}}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>{{trans('mailing.title')}}</th>
                    <th style="width:150px;">{{trans('mailing.updatedAt')}}</th>
                    <th style="width:150px;"></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($mailings))
                    @foreach($mailings as $mailing)
                    <tr>
                        <td>{{$mailing->id}}</td>
                        <td>{{$mailing->title}}</td>
                        <td>{{$mailing->update_at}}</td>
                        <td>
                            <a href="{{URL::action('MailingController@edit',array('id'=>$mailing->id))}}" class="btn btn-default btn-mini"><i class="fa fa-edit"></i></a>
                            {{Form::open(array('url' => URL::action('MailingController@destroy',array('id'=>$mailing->id)), 'method' => 'delete','style'=>'display:inline-block')) }}
                            <button onClick="if(!confirm('{{trans('mailing.messageDelete')}}')) return false;" type="submit" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></button>
                            {{Form::close();}}
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        @if(!empty($mailings)) {{$mailings->links()}} @endif
    </div>
</div>
@stop
