<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\User>
 */
class TripFactory extends Factory
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
            'make' => $this->faker->randomElement(['Honda', 'Toyota', 'Hyundai', 'Nissan', 'Ford']),
            'model' => $this->faker->word(),
            'year' => $this->faker->year(),
            'user_id' => User::factory(),
            'trip_count' => $this->faker->randomDigit(),
            'trip_miles' => $this->faker->randomFloat(2, 1, 50),
        ];
    }
}