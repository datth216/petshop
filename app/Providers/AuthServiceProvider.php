<?php

namespace App\Providers;

use App\Policies\AdminSupplierPolicy;
use App\Supplier;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Supplier::class => AdminSupplierPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // dd(config('permissions.access.add-supplier'));

        Gate::define('is-admin', function ($user) {
            // dd($user);
            return $user->is_admin;
        });

        Gate::define('supplier-list', 'App\Policies\AdminSupplierPolicy@view');
        Gate::define('supplier-add', 'App\Policies\AdminSupplierPolicy@create');
        Gate::define('supplier-edit', 'App\Policies\AdminSupplierPolicy@edit');
        Gate::define('supplier-delete', 'App\Policies\AdminSupplierPolicy@delete');
        Gate::define('supplier-restore', 'App\Policies\AdminSupplierPolicy@restore');

        Gate::define('category-list', 'App\Policies\AdminCategoryPolicy@view');
        Gate::define('category-edit', 'App\Policies\AdminCategoryPolicy@edit');
        Gate::define('category-delete', 'App\Policies\AdminCategoryPolicy@delete');

        Gate::define('product-list', 'App\Policies\AdminProductPolicy@view');
        Gate::define('product-add', 'App\Policies\AdminProductPolicy@create');
        Gate::define('product-edit', 'App\Policies\AdminProductPolicy@edit');
        Gate::define('product-delete', 'App\Policies\AdminProductPolicy@delete');
        Gate::define('product-restore', 'App\Policies\AdminProductPolicy@restore');
        Gate::define('detail-product','App\Policies\AdminProductPolicy@detail') ;

        Gate::define('orderform-list', 'App\Policies\AdminOrderformPolicy@view');
        Gate::define('orderform-add', 'App\Policies\AdminOrderformPolicy@create');
        Gate::define('orderform-edit', 'App\Policies\AdminOrderformPolicy@edit');
        Gate::define('orderform-delete', 'App\Policies\AdminOrderformPolicy@delete');
        Gate::define('orderform-detail', 'App\Policies\AdminOrderformPolicy@detail');

        Gate::define('output-list', 'App\Policies\AdminOutputPolicy@view');
        Gate::define('output-add', 'App\Policies\AdminOutputPolicy@create');
        Gate::define('output-edit', 'App\Policies\AdminOutputPolicy@edit');
        Gate::define('output-delete', 'App\Policies\AdminOutputPolicy@delete');

        Gate::define('input-list', 'App\Policies\AdminInputPolicy@view');
        Gate::define('input-add', 'App\Policies\AdminInputPolicy@create');
        Gate::define('input-edit', 'App\Policies\AdminInputPolicy@edit');
        Gate::define('input-delete', 'App\Policies\AdminInputPolicy@delete');

        Gate::define('staff-list', 'App\Policies\AdminUserPolicy@view');
        Gate::define('staff-add', 'App\Policies\AdminUserPolicy@create');
        Gate::define('staff-edit', 'App\Policies\AdminUserPolicy@edit');
        Gate::define('staff-delete', 'App\Policies\AdminUserPolicy@delete');
        Gate::define('staff-restore', 'App\Policies\AdminUserPolicy@restore');

        Gate::define('role-list', 'App\Policies\AdminRolePolicy@view');
        Gate::define('role-add', 'App\Policies\AdminRolePolicy@create');
        Gate::define('role-edit', 'App\Policies\AdminRolePolicy@edit');
        Gate::define('role-delete', 'App\Policies\AdminRolePolicy@delete');

        Gate::define('permission-add', 'App\Policies\AdminPermissionPolicy@create');
    }
}
