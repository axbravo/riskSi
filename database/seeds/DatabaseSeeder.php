<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(TestUserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        //this->call(LocalTableSeeder::class);
        $this->call(OrganizerTableSeeder::class);
        $this->call(politicsSeeder::class);
        $this->call(AccessPromotionSeeder::class);
        $this->call(ExchangeRateTableSeeder::class);
        $this->call(ModuleAssigmentTableSeeder::class);
        $this->call(AboutTableSeeder::class);
        $this->call(BusinessTableSeeder::class);

        Model::reguard();
    }
}
