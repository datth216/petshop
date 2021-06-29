<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'staff', 'display_name' => 'Nhân viên'],
        ]);
    }
}
