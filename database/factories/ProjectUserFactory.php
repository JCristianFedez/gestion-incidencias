<?php

namespace Database\Factories;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //TODO: Hacer factory agregandole a usuarios y proyectos, project_id y level_id deven existir

        return [
            'project_id' => $this->faker->unique(true)->numberBetween(1, 300),
            'user_id' => 3,
            'level_id' => $this->faker->unique(true)->numberBetween(1, 300)
        ];
    }
}
