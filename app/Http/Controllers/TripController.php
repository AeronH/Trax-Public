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
            ->join('cars', 'trips.car_id', '=', 'cars.id')
            ->select(
                'trips.id as trip_id',
                'trips.date',
                'trips.miles',
                'cars.trip_miles as total',
                'cars.id as car_id',
                'cars.make',
                'cars.model',
                'cars.year'
            )
            ->get();

        $formattedTrips = $trips->map(function ($trip) {
            return [
                'id' => $trip->trip_id,
                'date' => $trip->date,
                'miles' => $trip->miles,
                'total' => $trip->total,
                'car' => [
                    'id' => $trip->car_id,
                    'make' => $trip->make,
                    'model' => $trip->model,
                    'year' => $trip->year,
                ],
            ];
        });

        return response()->json(['data' => $formattedTrips]);
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

            DB::table('cars')
                ->where('id', $carId)
                ->increment('trip_miles', $miles);

            DB::table('cars')
                ->where('id', $carId)
                ->increment('trip_count', 1);
        } catch (Exception) {
            return response()->json(['message' => 'Trip could not be stored']);
        }
        
        return response()->json([
            'message' => 'New trip stored successfully!',
            'data' => $trip,
        ]);
    }
}
