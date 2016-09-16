<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class TestUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([  'name' => 'Project Manager','lastname' => 'ApellidoC', 'di_type'=> config('constants.national'), 'di' => '46898966', 'address'=>'Av. Project Manager #532 San Borja',
                        'email' => 'projectmanager@mail.com', 'phone' => '944133643', 'points'=>0, 'birthday'=>Carbon::create(1991,1,8)->toDateString(), 
                        'iniDate'=>Carbon::today(), 'role_id'=>1, 'password' => bcrypt('projectmanager')]);

        User::insert([  'name' => 'RiskManager','lastname' => 'ApellidoV', 'di_type'=> config('constants.national'), 'di' => '54312666', 'address'=>'Av. RiskManager #532 San Borja',
                        'email' => 'riskmanager@mail.com', 'phone' => '944133643', 'birthday'=>Carbon::create(1994,2,14)->toDateString(), 
                        'iniDate'=>Carbon::today(), 'role_id'=>2, 'password' => bcrypt('riskmanager')]);

        User::insert([  'name' => 'Analist','lastname' => 'ApellidoP', 'di_type'=> config('constants.international'), 'di' => '42362311', 'address'=>'Av. Analist #532 San Borja',
                        'email' => 'analist@mail.com', 'phone' => '944133643', 'birthday'=>Carbon::create(1984,6,24)->toDateString(), 
                        'iniDate'=>Carbon::today(), 'role_id'=>5, 'password' => bcrypt('analist')]);

        User::insert([  'name' => 'Admin','lastname' => 'ApellidoA', 'di_type'=> config('constants.international'), 'di' => '64222267', 'address'=>'Av. Admin #532 San Borja',
                        'email' => 'admin@mail.com', 'phone' => '944133643', 'birthday'=>Carbon::create(1994,1,24)->toDateString(), 
                        'iniDate'=>Carbon::today(), 'role_id'=>4, 'password' => bcrypt('admin')]);
        
        User::insert([  'name' => 'Portfolio Manager','lastname' => 'ApellidoPM', 'di_type'=> config('constants.national'), 'di' => '12345678', 'address'=>'Av. Port Manager',
                        'email' => 'portmanager@mail.com', 'phone' => '977139700', 'birthday'=>Carbon::create(1990,2,14)->toDateString(), 
                        'iniDate'=>Carbon::today(), 'role_id'=>3, 'module_id'=>2,'password' => bcrypt('portmanager')]);


    }
}
