<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Supplier extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = "suppliers";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'note', 'user_id'
    ];

    function user(){
        return $this->belongsTo('App\User');
    }

    function product(){
        return $this->hasMany('App\Product');
    }

    function orderform(){
        return $this->hasMany('App\OrderForm');
    }

    function input(){
        return $this->hasMany('App\Input');
    }

    function output(){
        return $this->hasMany('App\Output');
    }
}
