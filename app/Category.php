<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
class Category extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = "category";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'level', 'slug', 'user_id', 'parent_id'
    ];

    function user()
    {
        return $this->belongsTo('App\User',);
    }

    function product(){
        return $this->hasMany('App\Product');
    }
}
