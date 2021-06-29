<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderForm extends Model
{
    use Notifiable;
    protected $table = "orderform";

    protected $fillable = [
        'name', 'content', 'status', 'user_id', 'supplier_cat', 'address'
    ];

    function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_cat');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // function product()
    // {
    //     return $this->belongsToMany('App\Product', 'Detail_OrderForm', 'product_id', 'orderform_id');
    // }
}
