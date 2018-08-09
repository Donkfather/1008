<?php

use Faker\Generator as Faker;

$factory->define(\App\CheckinLocation::class, function (Faker $faker) {
    return [
        'lat' => $this->faker->latitude(44.451587, 44.453962),
        'lng' => $this->faker->longitude(26.083375, 26.086933),
        'event_id' => 1
    ];
});
