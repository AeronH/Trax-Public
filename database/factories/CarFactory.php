<?php

namespace Database\Factories;

use App\Models\Car;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return array<string, mixed>
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'make' => $this->faker->randomElement(['Honda', 'Toyota', 'Hyundai', 'Nissan', 'Ford']),
            'model' => $this->faker->word(),
            'year' => $this->faker->year(),
        ];
    }
}