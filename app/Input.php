<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Input extends Model
{
    use Notifiable;
    protected $table = "Input";

    protected $fillable = [
        'user_id', 'product_id', 'qty', 'content', 'address', 'supplier_cat', 'price', 'total_price','status'
    ];

    function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_cat');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
