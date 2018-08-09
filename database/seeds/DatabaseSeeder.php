<?php

use App\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Event::truncate();
        \App\EventToken::truncate();
        $events = [
            [
                'name' => 'Eveniment Global',
                'start_date' => Carbon::now()->hour('13'),
                'end_date' => Carbon::now()->addDay(1)->hour('4')
            ],
            [
                'name' => 'Eveniment 1',
                'start_date' => Carbon::now()->hour('13'),
                'end_date' => Carbon::now()->hour('18')
            ],
            [
                'name' => 'Eveniment 2',
                'start_date' => Carbon::now()->hour('18'),
                'end_date' => Carbon::now()->hour('19')
            ],
            [
                'name' => 'Eveniment 3',
                'start_date' => Carbon::now()->hour('19'),
                'end_date' => Carbon::now()->hour('20')
            ],
        ];
        collect($events)->each(function($event){
            Event::create($event);
        });
    }
}
