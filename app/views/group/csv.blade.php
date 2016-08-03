@extends('layouts.default')

@section('title')
Подгрузка групп через CSV файл
@stop

@section('content')
    {{ Form::open(array('url' => URL::to('/group/fromCSV'),'class'=>"form-horizontal",'method'=>"POST",'files'=>true))}}
        <div id="form-content">
            <div class="form-group">
                <label  class="col-sm-2 control-label">Тип:</label>
                <div class="col-sm-10">
                    {{Form::select('group_id',Group::lists('title','id'))}}
                </div>
            </div>
        </div>
        <div id="form-content">
            <div class="form-group">
                <label  class="col-sm-2 control-label">Фаил:</label>
                <div class="col-sm-10">
                    {{Form::file('csv')}}
                </div>
            </div>
        </div>
        <div id="form-content">
            <div class="form-group">
                <label  class="col-sm-2 control-label">Тип:</label>
                <div class="col-sm-10">
                    {{Form::checkbox('clean',1)}}
                </div>
            </div>
        </div>
            {{ Form::token()}}
            {{ Form::submit(trans('templates.create'),array('class'=>'btn btn-default'))}}
    {{ Form::close()}}
@stop