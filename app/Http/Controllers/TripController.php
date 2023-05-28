<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    /**
     * Get all the trips.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $trips = DB::table('trips')
            ->select('id', 'date', 'miles', 'car_id')
            ->get();

        $carIds = $trips->pluck('car_id')->toArray();

        $cars = DB::table('cars')
            ->whereIn('id', $carIds)
            ->select('id', 'make', 'model', 'year')
            ->get()
            ->keyBy('id');

        $total = 0;
        $data = [];

        foreach ($trips as $trip) {
            $car = $cars->get($trip->car_id);

            if ($car) {
                $total += $trip->miles;

                $completeTrip = [
                    'id' => $trip->id,
                    'date' => $trip->date,
                    'miles' => $trip->miles,
                    'total' => $total,
                    'car' => [
                        'id' => $car->id,
                        'make' => $car->make,
                        'model' => $car->model,
                        'year' => $car->year,
                    ],
                ];
    
                array_push($data, $completeTrip); 
            }
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created trip in the database.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'car_id' => 'required|integer',
            'date' => 'required|date',
            'miles' => 'required|string',
        ]);

        $userId = auth()->id();
        $carId = $request->get('car_id');
        $date = $request->get('date');
        $miles = (float) $request->get('miles');


        try {
            $trip = new Trip;

            $trip->user_id = $userId;
            $trip->car_id = $carId;
            $trip->date = new DateTimeImmutable($date);
            $trip->miles = $miles;

            $trip->save();
        } catch (Exception) {
            return response()->json(['message' => 'Trip could not be stored']);
        }
        
        return response()->json([
            'message' => 'New trip stored successfully!',
            'data' => $trip,
        ]);
    }
}
