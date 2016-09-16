<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try{
            $system = DB::table('business')->first();

            if($system){
                view()->share('business_name',$system->business_name);
                view()->share('favicon', $system->favicon);
            }
        }catch(\Exception $e){

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
