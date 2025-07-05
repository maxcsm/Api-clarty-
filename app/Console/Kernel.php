<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\AppointementEmail;
use App\Mail\AppointementonemonthEmail;
use App\Mail\AppointementtowmonthEmail;

use Carbon\Carbon;




class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
    
   */
/*
       protected function schedule(Schedule $schedule)
         {
            $schedule->call(function() {

 //$date = Carbon::now()->addMonth()->timezone('Europe/Stockholm')->toDateTimeString();
 $date = Carbon::now()->addMonth()->timezone('Europe/Stockholm')->toDateTimeString();
 $datemax = Carbon::now()->addMonth()->addDay()->timezone('Europe/Stockholm')->toDateTimeString();

  $location= DB::table('appointements')
   ->join('users', 'appointements.user_id', '=', 'users.id')
   ->where('appointements.state', 2 )
   ->where('appointements.start_at','>', $date)
   ->where('appointements.start_at','<', $datemax)
   ->select('users.id','appointements.user_id','appointements.id', 'appointements.content', 
   'users.company', 'appointements.start_at', 'appointements.title', 'users.email','users.firstname','users.lastname', 'users.company')
   ->groupBy('user_id')
   ->get();
   

   foreach ($location as $items) {
     $email = $items->email; 

     $user = new user;
     $user->firstname = $items->firstname ;
     $user->lastname = $items->lastname;
     $user->company = $items->company;
     $user->subject = $items->title;
     $user->message = $items->content;
     $test=$items->start_at;
     $test = strtotime($test);
     $user->jour= date('d-m-Y',$test);
     $user->heure= date('H:i',$test);

     Mail::to($email)->send(new AppointementonemonthEmail($user));

    }
         
             })->daily();



      $schedule->call(function() {


    //$date = Carbon::now()->addMonth()->timezone('Europe/Stockholm')->toDateTimeString();
    $date = Carbon::now()->addMonths(2)->timezone('Europe/Stockholm')->toDateTimeString();
    $datemax = Carbon::now()->addMonths(2)->addDay()->timezone('Europe/Stockholm')->toDateTimeString();

     $location= DB::table('appointements')
      ->join('users', 'appointements.user_id', '=', 'users.id')
      ->where('appointements.state', 2 )
      ->where('appointements.start_at','>', $date)
      ->where('appointements.start_at','<', $datemax)
      ->select('users.id','appointements.user_id','appointements.id', 'appointements.content', 
      'users.company', 'appointements.start_at', 'appointements.title', 'users.email','users.firstname','users.lastname', 'users.company')
      ->groupBy('user_id')
      ->get();
      
    
      foreach ($location as $items) {
        $email = $items->email; 

        $user = new user;
        $user->firstname = $items->firstname ;
        $user->lastname = $items->lastname;
        $user->company = $items->company;
        $user->subject = $items->title;
        $user->message = $items->content;
        $test=$items->start_at;
        $test = strtotime($test);
        $user->jour= date('d-m-Y',$test);
        $user->heure= date('H:i',$test);

        Mail::to($email)->send(new AppointementtowmonthEmail($user));
    
      }
             })->daily();


 }
*/


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
