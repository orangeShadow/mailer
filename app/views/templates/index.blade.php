@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('template.create'))
        <div class="alert alert-info">{{Session::get('tempalte.create')}}</div>
        @endif
        @if(Session::has('template.destroy'))
        <div class="alert alert-info">{{Session::get('template.destroy')}}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{trans('title')}}</th>
                    <th style="width:150px;">{{trans('updatedAt')}}</th>
                    <th style="width:150px;"></th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($templates))
                    @foreach($templates as $template)
                    <tr>
                        <td>{{$template->id}}</td>
                        <td>{{$template->title}}</td>
                        <td>{{$template->updated_at}}</td>
                        <td>
                            <a href="{{URL::action('TemplatesController@edit',array('id'=>$template->id))}}" class="btn btn-default btn-mini"><i class="fa fa-edit"></i></a>
                            <a href="{{URL::action('TemplatesController@show',array('id'=>$template->id))}}" class="btn btn-default btn-mini" target="_blank"><i class="fa fa-eye"></i></a>
                            {{Form::open(array('url' => URL::action('TemplatesController@destroy',array('id'=>$template->id)), 'method' => 'delete','style'=>'display:inline-block')) }}
                                <button onClick="if(!confirm('{{trans('templates.messageDelete')}}')) return false;" type="submit" class="btn btn-danger btn-mini"><i class="fa fa-trash-o"></i></button>
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
