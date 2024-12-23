<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Equipment;
use App\Models\Penalty;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuditoriumController extends Controller
{
    // Listar auditórios
        public function index()
        {
            $auditoriums = Auditorium::all();
            return response()->json($auditoriums, 200);
        }

        // Criar um auditório
        public function store(Request $request)
        {
            \Log::info($request->all());
            try {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'capacity' => 'required|integer|min:1',
                    'location' => 'required|string|max:255',
                ]);

                \Log::info($validatedData['name']);
                
                $auditorium = new Auditorium();

                $auditorium->name = $validatedData['name'];
                $auditorium->capacity = $validatedData['capacity'];
                $auditorium->location = $validatedData['location'];

                $auditorium->save();
            } catch (\Exception $e) {
                \Log::info($e);
            }
            
            return response()->json(['message' => 'Auditorium created successfully', 'auditorium' => $auditorium], 201);
        }

        // Exibir detalhes de um auditório
        public function show($id)
        {
            $auditorium = Auditorium::findOrFail($id);
            return response()->json($auditorium, 200);
        }

        // Atualizar auditório
        public function update(Request $request, $id)
        {
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'capacity' => 'integer|min:1',
                'location' => 'string|max:255',
            ]);

            $auditorium = Auditorium::findOrFail($id);
            $auditorium->update($validatedData);
            return response()->json(['message' => 'Auditorium updated successfully', 'auditorium' => $auditorium], 200);
        }

        // Remover auditório
        public function destroy($id)
        {
            $auditorium = Auditorium::findOrFail($id);
            $auditorium->delete();
            return response()->json(['message' => 'Auditorium deleted successfully'], 200);
        }
}
