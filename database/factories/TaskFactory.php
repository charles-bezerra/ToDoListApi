<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $status = ["pendente", "fazendo" ,"concluída"];
    $nUsers = Task::all()->count();

    return [
        'name' => $faker->name,
        'details' => $faker->sentence($nbWords = 20, $variableNbWords = true),
        'status' => $status[rand(0,2)],
        'id_user' => rand(1,$nUsers) 
    ];
});
