<?php

use Illuminate\Database\Seeder;
use App\Models\Business;
class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::insert([
            'business_name'	=>	'Risk System',
            'ruc'			=>	12345678912,
            'address'		=>	'Monte del destino #480',
            'logo'			=>	'images/logo.jpg',
            'favicon'		=>	'uploads/system_0.04427600 1458964043.png',
        ]);
    }
}
