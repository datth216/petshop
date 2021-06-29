<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function category()
    {
        return $this->hasMany('App\Category');
    }

    function supplier()
    {
        return $this->hasMany('App\Supplier');
    }

    function product()
    {
        return $this->hasMany('App\Product');
    }

    function orderform()
    {
        return $this->hasMany('App\OrderForm');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }

    public function checkPermissionAccess($permissionCheck)
    {
        //Test user quản lý nhà cung cấp: xem, xoá, sửa, thêm, phục hồi
        //Lấy được các quyền user đang login
        //So sánh giá trị đưa vào route hiện tại có tồn tại trong các quyền mà mình lấy được hay không
        $roles = auth()->user()->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            // dd($permissions);
            if ($permissions->contains('key_code', $permissionCheck)) {
                return true;
            }
        }
        return false;
    }
}
