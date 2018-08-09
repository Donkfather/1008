<?php

namespace App\Console\Commands;

use App\Events\BatchPointsAdded;
use App\Events\PointAdded;
use Faker\Generator;
use Illuminate\Console\Command;

class AddRandomPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '1008:add-points {n}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds random points';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $faker;

    public function __construct()
    {
        parent::__construct();
        $this->faker = app('Faker\Generator');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('n')) {
            $n = $this->argument('n');
            $locations = [];
            for ($i = 1; $i <= $n; $i++) {
                array_push($locations, $this->generateLocation());
            }
            event(new BatchPointsAdded($locations));
        } else {
            $location = $this->generateLocation();
            event(new PointAdded($location['lat'], $location['lng']));
        }
    }

    private function generateLocation()
    {
        return [
            'lat' => $this->faker->latitude(44.451587, 44.453962),
            'lng' => $this->faker->longitude(26.083375, 26.086933),
        ];
    }
}
