<?php

class Mailing extends \Eloquent {
    protected $guarded = array('_token');
	protected $fillable = [];

    public function hasMailing(){
        $c = DB::table('sanding')->where('mailing_id',$this->id)->count('*');
        if($c>0) return true; else return false;
    }
    public function isStart(){
        $c = DB::table('sanding')->where('mailing_id',$this->id)->where('stop',0)->count('*');
        if($c>0) return true; else return false;
    }
}