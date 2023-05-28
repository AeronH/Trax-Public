<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Car;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CarsTest extends TestCase
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

        $this->user = User::factory()->create();
    }


    /**
     * Test getting all cars of a user.
     *
     * @return void
     */
    public function testGettingUsersCars(): void
    {
        $car1 = [
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2023
        ];

        $car2 = [
            'make' => 'Honda',
            'model' => 'Civic',
            'year' => 2015
        ];

        Car::factory()->create(array_merge($car1, ['user_id' => $this->user->id]));

        Car::factory()->create(array_merge($car2, ['user_id' => $this->user->id]));

        $response = $this
            ->actingAs($this->user, 'api')
            ->get('/api/car/all');

        $response->assertStatus(200);

        $response->assertJson(['data' => [$car1 ,$car2]]);
    }


    /**
     * Test storing a car.
     *
     * @return void
     */
    public function testStoreingCar(): void
    {
        $car = [
            'user_id' => $this->user->id,
            'make' => 'Mazda',
            'model' => '3',
            'year' => 2012,
        ];

        $this->assertDatabaseMissing('cars', $car);

        $response = $this
            ->actingAs($this->user, 'api')
            ->post('/api/car/store', $car);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cars', $car);
    }


    /**
     * Test getting a single car.
     *
     * @return void
     */
    public function testGettingSingleCar():void
    {
        $car = [
            'make' => 'Bugatti',
            'model' => 'Veyron',
            'year' => 2020,
        ];

        $createdCar = Car::factory()->create(array_merge($car, ['user_id' => $this->user->id]));

        $response = $this
            ->actingAs($this->user, 'api')
            ->get('/api/car/' . $createdCar->id);

        $response->assertStatus(200);

        $response->assertJson(['data' => $car]);
    }


    /**
     * Test deleting a car.
     *
     * @return void
     */
    public function testDeletingCar(): void
    {
        $car = [
            'user_id' => $this->user->id,
            'make' => 'Ford',
            'model' => 'Fiesta',
            'year' => 2012,
        ];

        $createdCar = Car::factory()->create($car);

        $this->assertDatabaseHas('cars', $car);

        $response = $this
            ->actingAs($this->user, 'api')
            ->delete('/api/car/delete/' . $createdCar->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('cars', $car);
    }
}