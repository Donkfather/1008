<?php

use App\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestEventsSeeder extends Seeder
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
                'name' => 'Eveniment 1',
                'start_date' => $now->hour('13'),
                'end_date' => $now->hour('18')
            ],
            [
                'name' => 'Eveniment 2',
                'start_date' => $now->hour('18'),
                'end_date' => $now->hour('19')
            ],
            [
                'name' => 'Eveniment 3',
                'start_date' => $now->hour('19'),
                'end_date' => $now->hour('20')
            ],
        ];
        collect($events)->each(function($event){
            Event::create($event);
        });
    }
}
