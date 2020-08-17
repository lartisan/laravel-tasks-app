<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $userIds = \App\User::whereRole('staff')->pluck('id');

    return [
        'title' => $faker->sentence,
        'created_by' => $faker->randomElement($userIds),
        'assigned_to' => $faker->randomElement($userIds),
        'priority' => $faker->randomElement([3, 2, 1, 0]), // 3 - critical, 2 - high, 1 - medium, 0 - low
        'completed' => $faker->boolean(50),
        'due_date' => $faker->dateTimeBetween('-1 week', '1 week')
    ];
});

$factory->state(Task::class, 'admin', function (Faker $faker) {
    return [
        'created_by' => \App\User::where('role', 'admin')->first()->id,
        'assigned_to' => \App\User::where('role', 'admin')->first()->id
    ];
});

$factory->state(Task::class, 'manager', function (Faker $faker) {
    $ids = \App\User::where('role', 'admin')
        ->orWhere('role', 'manager')
        ->pluck('id');

    return [
        'created_by' => $faker->randomElement($ids),
        'assigned_to' => \App\User::where('role', 'manager')->first()->id
    ];
});

$factory->state(Task::class, 'team-leader', function (Faker $faker) {
    $ids = \App\User::where('role', 'admin')
        ->orWhere('role', 'manager')
        ->orWhere('role', 'team-leader')
        ->pluck('id');

    return [
        'created_by' => $faker->randomElement($ids),
        'assigned_to' => \App\User::where('role', 'team-leader')->first()->id
    ];
});

$factory->state(Task::class, 'staff', function (Faker $faker) {
    $ids = \App\User::pluck('id');

    return [
        'created_by' => $faker->randomElement($ids),
        'assigned_to' => \App\User::where('role', 'staff')->first()->id
    ];
});
