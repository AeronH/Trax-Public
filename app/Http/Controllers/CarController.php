<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Get all the cars for logged in user
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $cars = DB::table('cars')
            ->where('user_id', $userId)
            ->select('id', 'make', 'model', 'year')
            ->get();

        return response()->json(['data' => $cars]);
    }

    /**
     * Store a newly created car in the database.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
        ]);

        $userId = auth()->id();
        $make = $request->get('make');
        $model = $request->get('model');
        $year = $request->get('year');

        try {
            $car = new Car;

            $car->user_id = $userId;
            $car->make = $make;
            $car->model = $model;
            $car->year = $year;

            $car->save();
        } catch(Exception) {
            return response()->json(['message' => 'Car could not be stored']);
        }
        
        return response()->json(['message' => 'New car stored successfully!']);
    }

    /**
     * Get detailed information about a single car
     *
     * @param  int  $int
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $car = DB::table('cars')
            ->where('id', $id)
            ->select('id', 'make', 'model', 'year', 'trip_count', 'trip_miles')
            ->first();

        if (!$car) {
            return response()->json(['message' => 'Cannot find car with the id ' . $id], 404);
        }
        
        return response()->json(['data' => $car]);
    }

    /**
     * Delete a car by it's id
     *
     * @param  int  $int
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $carExists = DB::table('cars')->where('id', $id)->exists();

        if (!$carExists) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        try {
            DB::table('cars')->where('id', $id)->delete();
        } catch (Exception) {
            return response()->json(['message' => 'Car could not be deleted']);
        }

        return response()->json(['message' => 'Car deleted successfully']);
    }
}
