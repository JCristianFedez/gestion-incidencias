<?php

namespace Database\Seeders;

use App\Models\User;
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
        // $table->id();
        // $table->string('name');
        // $table->string('email')->unique();
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
        // $table->smallInteger("role"); //0: Admin | 1: Support | 2:Client
        // $table->rememberToken();
        // $table->timestamps();

        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("123"),
            "role" => 0
        ]);

        User::create([
            "name" => "client",
            "email" => "client@gmail.com",
            "password" => bcrypt("123"),
            "role" => 2
        ]);

    }
}
