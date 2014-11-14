@extends('layouts.default')

@section('title')
{{$title}}
@stop

@section('content')
@if(Session::has('template.edit'))
    <div class="alert alert-success">
        {{Session::get('template.edit')}}
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => URL::action('TemplatesController@update',array('id'=>$template->id)),'method'=>"PUT"))}}
            <?$errorTitle=$errors->first('title')?>
            <div class="form-group @if(!empty($errorTitle)) {{'has-error'}} @endif">
                {{Form::label(trans('templates.Title'),'',array('class'=>'control-label'))}}
                {{Form::text('title',$template->title,array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label(trans('templates.MetaInfo'),'',array('class'=>'control-label'))}}
                {{Form::textarea('meta',$template->meta,array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label(trans('templates.Stylesheet'),'',array('class'=>'control-label'))}}
                {{Form::textarea('css',$template->css,array('class'=>'form-control'))}}
                <div style="height:300px; margin: 10px;" id="css"></div>
            </div>
            <div class="form-group">
                {{Form::label(trans('templates.Header'),'',array('class'=>'control-label'))}}
                {{Form::textarea('header',$template->header,array('class'=>'form-control'))}}
                <div style="height:300px; margin: 10px;" id="header"></div>
            </div>
            <div class="form-group">
                {{Form::label(trans('templates.Footer'),'',array('class'=>'control-label'))}}
                {{Form::textarea('footer',$template->footer,array('class'=>'form-control'))}}
                <div style="height:300px; margin: 10px;" id="footer"></div>
            </div>

            <hr>
            <div class="form-group">
                {{Form::submit(trans('templates.save'),array('class'=>'btn btn-success'))}}
                <a target="_blank" class="btn btn-primary" href="{{URL::action('TemplatesController@show',array('id'=>$template->id))}}">{{trans('templates.preview')}}</a>
                <a class="btn btn-default" href="{{URL::action('TemplatesController@edit',array('id'=>$template->id))}}">{{trans('templates.cancel')}}</a>
            </div>
        {{Form::close()}}
    </div>
</div>
@stop
