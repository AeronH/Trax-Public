<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Car;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CarModelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    /**
     * Set up the test case.
     *
     * This method is executed before each test method.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();

        $this->user = User::factory()->create(['email' => 'email@gmail.com']);
    }

    /**
     * Test the creation of a new car.
     *
     * @return void
     */
    public function testCreateNewCar(): void
    {
        $car = Car::factory()->create([
            'user_id' => $this->user->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2023,
        ]);

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'user_id' => $this->user->id,
        ]);
    }
    
    /**
     * Test the deletion of a car.
     *
     * @return void
     */
    public function testDeleteCar(): void
    {
        $car = Car::factory()->create([
            'user_id' => $this->user->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2023,
        ]);

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'user_id' => $this->user->id,
        ]);

        $car->delete();

        $this->assertDatabaseMissing('cars', [
            'id' => $car->id,
        ]);
    }
}