<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            "name" => "Proyecto A",
            "description" => "El proyecto A consiste en desarrollar un sitio web moderno.",
            "start" => now()
        ]);

        Project::create([
            "name" => "Proyecto B",
            "description" => "El proyecto B consiste en desarrollar una aplicación Android.",
            "start" => now()
        ]);
    }
}
