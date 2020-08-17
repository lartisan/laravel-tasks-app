<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Task::class, 10)->states('admin')->create();
        factory(\App\Task::class, 15)->states('manager')->create();
        factory(\App\Task::class, 20)->states('team-leader')->create();
        factory(\App\Task::class, 30)->states('staff')->create();
    }
}
