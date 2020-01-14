<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'sidirgot',
            'email' => 'sidirgot@app.com',
            'password' => 'password',
            'role' => 'manager'
        ]);

        User::create([
            'name' => 'tester',
            'email' => 'tester@app.com',
            'password' => 'password',
            'role' => 'tester'
        ]);

        User::create([
            'name' => 'developer',
            'email' => 'developer@app.com',
            'password' => 'password',
            'role' => 'developer'
        ]);

    }
}
