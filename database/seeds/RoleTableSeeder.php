<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert(['description'=>'PROJECT MANAGER']);
        Role::insert(['description'=>'PORTFOLIO MANAGER']);
        Role::insert(['description'=>'RISK MANAGER']);
        Role::insert(['description'=>'ADMIN']);
        Role::insert(['description'=>'ANALIST']);
    }
}
