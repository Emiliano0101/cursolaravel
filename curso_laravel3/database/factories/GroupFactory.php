<?php

namespace Database\Factories;

use App\Models\Group; // Asegúrate de importar el modelo
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class; // Define el modelo asociado

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // Usa $this->faker
        ];
    }
}
