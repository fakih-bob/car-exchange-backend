<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        try {
            $cars = Car::all();
            return response()->json($cars, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve companies', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
   
    public function store(Request $request)
    {
        $new_car=Car::create($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'New company is created successfuly',
            'data'=>$new_car
        ]);
    }

}
