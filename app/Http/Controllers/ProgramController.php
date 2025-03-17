<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return response()->json($programs);
    }

    public function show(string $id)
    {
        $program = Program::with('restaurants')->find($id);

        if ($program) {
            return response()->json($program);
        } else {
            return response()->json(['message' => 'El programa no exiteix a les bases de dades'], 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'year' => 'required|numeric',
            'season' => 'required|numeric',
            'restaurant_id' => 'nullable|numeric',
        ]);
        try {
            $program = Program::create($validated);
            return response()->json($program, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se pudo crear el programa debido a un error inesperado.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, string $id)
    {
        $programs = Program::find($id);
        if($programs){

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:255',
                'year' => 'sometimes|numeric',
                'season' => 'sometimes|numeric',
                'restaurant_id' => 'sometimes|numeric',
            ]);

            $programs->fill($validated);
            $programs->save();
            return response()->json($programs);
        }else{
            return response()->json(['message' => 'El programa no exiteix a les bases de dades'], 404);
        }
    }

    public function destroy(string $id)
    {
        $programs = Program::find($id);
        if($programs){
            $programs->delete();
            return response()->json($programs);
        }else{
            return response()->json(['message' => 'El programa no exiteix a les bases de dades'], 404);
        }
    }
}
