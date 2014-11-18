@extends('layouts.default')

@section('title')
Подгрузка групп через API
@stop

@section('content')
   {{Form::open(array('class'=>"form-horizontal",'id'=>'form-api'))}}
        <div id="form-content">
            <div class="form-group">
                <label  class="col-sm-2 control-label">Тип:</label>
                <div class="col-sm-10">
                    {{Form::select('type',[0=>'Копилка',1=>"Контрагенты"],null,array('class'=>'form-control'))}}

                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{Form::submit('Выбрать',array('class'=>'btn btn-primary'))}}
            </div>
        </div>

   {{Form::close()}}
@stop