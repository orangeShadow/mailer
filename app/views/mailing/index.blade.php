@extends('layouts.default')

@section('title')
{{trans('mailing.mailingList')}}
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
        @if(Session::has('mailing.message'))
            <div class="alert alert-info">{{Session::get('mailing.message')}}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>{{trans('mailing.title')}}</th>
                    <th style="width:150px;">{{trans('mailing.comment')}}</th>
                    <th style="width:185px;"></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($mailings))
                    @foreach($mailings as $mailing)
                    <tr>
                        <td>{{$mailing->id}}</td>
                        <td>{{$mailing->title}}</td>
                        <td>{{$mailing->comment}}</td>
                        <td>
                            {{Form::open(array('url' => URL::action('MailingController@destroy',array('id'=>$mailing->id)), 'method' => 'delete','style'=>'display:inline-block')) }}
                                <button onClick="if(!confirm('{{trans('mailing.messageDelete')}}')) return false;" type="submit" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></button>
                            {{Form::close();}}
                            <a href="{{URL::action('MailingController@edit',array('id'=>$mailing->id))}}" class="btn btn-default btn-mini"><i class="fa fa-edit"></i></a>

                            @if($mailing->isStart())
                                <a class="btn btn-default stop" href="/mailing/stop?id={{$mailing->id}}"><i class="fa fa-stop"></i></a>
                            @else
                                <a class="btn btn-default play" href="/mailing/start?id={{$mailing->id}}"><i class="fa fa-play"></i></a>
                            @endif

                            @if($mailing->hasMailing())
                                <a class="btn btn-default clean" href="/mailing/clean?id={{$mailing->id}}"><i class="fa fa-times"></i></a>
                                <?if(!empty($sendProcent[$mailing->id])){?> <span><?=$sendProcent[$mailing->id]?>  %</span><?}?>
                            @endif
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
