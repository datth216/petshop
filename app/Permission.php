<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{   
    protected $guarded = [];
    function permissionsChildren(){
        return $this->hasMany('App\Permission', 'parent_id');
    }
}
