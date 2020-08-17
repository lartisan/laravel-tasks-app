<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Admin',         'email' => 'admin@example.com',         'role' => 'admin',          'role_rank' => 1],
            ['name' => 'Manager',       'email' => 'manager@example.com',       'role' => 'manager',        'role_rank' => 2],
            ['name' => 'TeamLeader',    'email' => 'teamleader@example.com',    'role' => 'team-leader',    'role_rank' => 3],
            ['name' => 'Staff',         'email' => 'staff@example.com',         'role' => 'staff',          'role_rank' => 4],
        ];

        foreach($users as $user) {
            factory(User::class)->create($user);
        }
    }
}
