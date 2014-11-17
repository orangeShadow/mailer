@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-8">
        {{Form::open(array('url' => URL::to('/sql/')))}}
           <div class="form-group">
               {{Form::label(trans('mailing.groups'),'',array('class'=>'control-label'))}}
               {{Form::textarea('q',Input::get('q',''),array('class'=>'form-control'))}}
           </div>
            <div class="form-group">
                {{ Form::hidden('place','mailer')}}
                {{ Form::submit(trans('subscriber.create'),array('class'=>'btn btn-default'))}}
            </div>
        {{Form::close()}}
    </div>
    <div class="col-lg-4">
        <b>Список табилц</b> <br>
        <?
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table){
            echo $table->Tables_in_mailer."<br>";
        }
        ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table">
            @if(!empty($data))
                <?$filds=array();?>
                <tr>
                    <?
                        foreach($data[0] as $k=>$v){
                            $filds[] = $k;
                    ?>
                        <th><?=$k?></th>
                    <?}?>
                    <?foreach($data as $el){?>
                        <tr>
                            <?foreach($filds as $k){?>
                                <td>{{$el->$k}}</td>
                            <?}?>
                        </tr>
                    <?}?>
                </tr>
            @endif
        </table>
    </div>
</div>
@stop