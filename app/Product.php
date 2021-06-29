<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = "products";

    protected $fillable = [
        'name', 'price', 'desc', 'detail', 'product_cat', 'qty', 'status', 'supplier_cat', 'user_id', 'img', 'total_price'
    ];

    function category()
    {
        return $this->belongsTo('App\Category', 'product_cat');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_cat');
    }

    function orderform()
    {
        return $this->belongsToMany('App\OrderForm', 'Detail_OrderForm', 'product_id', 'orderform_id');
    }

    function input(){
        return $this->belongsToMany('App\Input');
    }

    function output(){
        return $this->hasMany('App\Output');
    }
}
