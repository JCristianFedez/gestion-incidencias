<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SupportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Suport - Project 1
        User::create([ // id = 3
            "name" => "support",
            "email" => "support@gmail.com",
            "password" => bcrypt("123"),
            "role" => 1
        ]);
        User::create([ // Id = 4
            "name" => "support s2",
            "email" => "support2@gmail.com",
            "password" => bcrypt("123"),
            "role" => 1
        ]);
    }
}
