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
        Event::truncate();
        \App\EventToken::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $now = now();
        $events = [
            [
                'name' => 'Eveniment Global',
                'start_date' => $now->hour('13'),
                'end_date' => $now->addDay(1)->hour('4')
            ],
            [
                'name' => 'Interval 1',
                'start_date' => $now->hour('18'),
                'end_date' => $now->hour('19')
            ],
            [
                'name' => 'Interval 2',
                'start_date' => $now->hour('19'),
                'end_date' => $now->hour('20')
            ],
            [
                'name' => 'Interval 3',
                'start_date' => $now->hour('20'),
                'end_date' => $now->hour('21')
            ],
            [
                'name' => 'Interval 4',
                'start_date' => $now->hour('21'),
                'end_date' => $now->hour('22')
            ],
            [
                'name' => 'Interval 5',
                'start_date' => $now->hour('22'),
                'end_date' => $now->hour('23')
            ],
            [
                'name' => 'Interval 6',
                'start_date' => $now->hour('23'),
                'end_date' => $now->addDay()->hour('00')
            ],
        ];
        collect($events)->each(function($event){
            Event::create($event);
        });
    }
}
