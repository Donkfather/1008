<?php

use App\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Event::truncate();
        \App\EventToken::truncate();
        \App\CheckinLocation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
$events = [
          [
            'name' => 'Eveniment Global',
            'start_date' => '2018-08-10 16:00:00',
            'end_date' => '2018-08-11 04:00:00'
          ],
          [
            'name' => 'Interval 1',
            'start_date' => '2018-08-10 18:00:00',
            'end_date' => '2018-08-10 19:00:00'
          ],
          [
            'name' => 'Interval 2',
            'start_date' => '2018-08-10 19:00:00',
            'end_date' => '2018-08-10 20:00:00'
          ],
          [
            'name' => 'Interval 3',
            'start_date' =>'2018-08-10 20:00:00',
            'end_date' => '2018-08-10 21:00:00'
          ],
          [
            'name' => 'Interval 4',
            'start_date' =>'2018-08-10 21:00:00',
            'end_date' => '2018-08-10 22:00:00'
          ],
          [
            'name' => 'Interval 5',
            'start_date' => '2018-08-10 22:00:00',
            'end_date' => '2018-08-10 23:00:00'
          ],
          [
            'name' => 'Interval 6',
            'start_date' => '2018-08-10 23:00:00',
            'end_date' => '2018-08-11 00:00:00'
          ],
        ];        
collect($events)->each(function($event){
            Event::create($event);
        });

dump(Event::all());        
    }
}
