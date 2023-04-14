<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach (User::all() as $user) {
            for ($i = rand(1, 5); $i > 0; $i--) {
                $user->companies()->attach(\App\Models\Company::all()->random());
            }
        }
    }
}
