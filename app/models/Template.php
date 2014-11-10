<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Template extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $guarded = array('_token');
}