<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function index()
    {
        $restaurants = Restaurant::all();
        return response()->json($restaurants);
    }


    public function show(string $id)
    {
        $restaurants = Restaurant::with('programs')->find($id);
        if($restaurants){
            return response()->json($restaurants);
        }else{
            return response()->json(['message' => 'El restaurant no exiteix a les bases de dades'], 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'province' => 'sometimes|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $restaurants = Restaurant::create($validated);
        if($restaurants){
            return response()->json($restaurants);
        }else{
            return response()->json(['message' => 'No s\'ha pogut crear el restaurant'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $restaurants = Restaurant::find($id);
        if($restaurants){

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'address' => 'sometimes|string|max:255',
                'city' => 'sometimes|string|max:255',
                'province' => 'sometimes|string|max:255',
                'postal_code' => 'nullable|string|max:10',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            $restaurants->update($validated);
            return response()->json($restaurants);
        }else{
            return response()->json(['message' => 'El restaurant no exiteix a les bases de dades'], 404);
        }
    }

    public function destroy(string $id)
    {
        $restaurants = Restaurant::find($id);
        if($restaurants){
            $restaurants->delete();
            return response()->json(['message' => 'Restaurant eliminat correctament'], $restaurants);
        }else{
            return response()->json(['message' => 'El restaurant no exiteix a les bases de dades'], 404);
        }
    }
}
