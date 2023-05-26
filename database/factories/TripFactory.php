<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Trip;
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
            'date' => $this->faker->date(),
            'miles' => $this->faker->randomFloat(2, 1, 500),
            'total' => $this->faker->randomFloat(2, 501, 5000),
            'car_id' => Car::factory(),
        ];
    }
}
