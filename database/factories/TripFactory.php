<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Trip;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return array<string, mixed>
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'car_id' => Car::factory()->create(),
            'date' => $this->faker->date(),
            'miles' => $this->faker->randomFloat(2, 1, 500),
        ];
    }
}
