<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Carbon\Carbon;
use Log;
use App\Models\Ticket;
use App\Models\Slot;
use App\Models\Event;
use App\Models\Highlight;
use App\Models\Presentation;
use App\Models\Zone;
use App\Models\Local;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->command('inspire')
                 ->everyMinute();*/
        $schedule->call(function(){
            $reservas = Ticket::whereNotNull('reserve')->get();
            foreach ($reservas as $reserva) {
                $reserve_date = strtotime($reserva->created_at);
                $reserve_hours = DB::table('business')->where('id',1)->first()->reserve_time;
                if($reserve_date + (3600*$reserve_hours) <= time()){
                    if($reserva->event->place->rows!=null)
                        DB::table('slot_presentation')->where('sale_id', $reserva->id)
                        ->update(['status' => config('constants.seat_free')]);
                    else{
                        DB::table('zone_presentation')->where('zone_id', $reserva->zone_id)
                        ->increment('slots_availables',$reserva->quantity);
                    }
                    $reserva->delete();
                }
            }
        })->everyMinute();
        $schedule->call(function(){
            $destacados = Highlight::where('start_date','<=',Carbon::now())->get();
            if($destacados && !empty($destacados))
                foreach($destacados as $destacado){
                    $tiempo = strtotime($destacado->start_date)+($destacado->days_active*3600*24);                    
                    if($tiempo>time()){
                        $destacado->active = 1;
                        $destacado->save();
                    }
                }
            $noDestacados = Highlight::where('active','1')->get();
            if($noDestacados && !empty($noDestacados))
                foreach ($noDestacados as $noDestacado) {
                    $tiempo = strtotime($noDestacado->start_date)+($noDestacado->days_active*3600*24);
                    if($tiempo <= time()){
                        $noDestacado->active = 0;
                        $noDestacado->save();
                    }
                }
        })->everyMinute();
    }
}
