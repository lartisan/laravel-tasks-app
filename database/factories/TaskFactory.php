<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $userIds = \App\User::pluck('id');
    return [
        'title' => $faker->sentence,
        'created_by' => $faker->randomElement($userIds),
        'assigned_to' => $faker->randomElement($userIds),
        'priority' => $faker->randomElement([3, 2, 1, 0]), // 3 - critical, 2 - high, 1 - medium, 0 - low
        'completed' => $faker->boolean(50),
        'due_date' => $faker->dateTimeBetween('-1 week', '1 week')
    ];
});
