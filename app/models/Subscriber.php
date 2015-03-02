<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Subscriber extends \Eloquent {
    protected $guarded = array('_token');
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    public function groups()
    {
        return $this->belongsToMany('Group','subscriber_group','subscriber_id');
    }
}