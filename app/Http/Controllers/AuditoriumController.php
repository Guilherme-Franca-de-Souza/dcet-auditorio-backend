<?php

namespace App\Http\Controllers;

use App\Libraries\Enums\ActionsEnum;
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'capacity' => 'required|integer|min:1',
                'location' => 'required|string|max:255',
                'equipment' => 'array',
                'equipment.*' => 'exists:equipment,id',
            ]);
            
            $auditorium = new Auditorium();

            $auditorium->name = $validatedData['name'];
            $auditorium->capacity = $validatedData['capacity'];
            $auditorium->location = $validatedData['location'];
            $auditorium->save();

            if (!empty($validatedData['equipment'])) {
                $auditorium->equipment()->sync($validatedData['equipment']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
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
        try {
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'capacity' => 'integer|min:1',
                'location' => 'string|max:255',
                'equipment' => 'array',
                'equipment.*' => 'exists:equipment,id',
            ]);
            
            $auditorium = Auditorium::findOrFail($id);
            $auditorium->update([
                'name' => $validatedData['name'] ?? $auditorium->name,
                'capacity' => $validatedData['capacity'] ?? $auditorium->capacity,
                'location' => $validatedData['location'] ?? $auditorium->location,
            ]);

            if (!empty($validatedData['equipment'])) {
                $auditorium->equipment()->sync($validatedData['equipment']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        
        return response()->json(['message' => 'Auditorium updated successfully', 'auditorium' => $auditorium], 200);
    }

    // Remover auditório
    public function destroy($id)
    {
        try {
            $auditorium = Auditorium::findOrFail($id);
            $auditorium->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        return response()->json(['message' => 'Auditorium deleted successfully'], 200);
    }

    // verificar disponibilidade
    public function verify($id, Request $request)
    {
        try {
            $validatedData = $request->validate([
                'start_time' => 'required|date|after:now',
                'end_time' => 'required|date|after:start_time',
            ]);

            $user = Auth::user(); 

            if (!$user->approved) {
                return response()->json(['message' => 'Your account is not approved'], 403);
            }

            if ($user->can(ActionsEnum::VERIFY_DISPONIBILITY))
            {
                return response()->json(['message' => 'Only technicians, professors or coordinators can verify disponibility'], 403);
            }

            $reservations = Reservation::where('auditorium_id', $id)
            ->where('approved', true)
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']]);
            })->get();

            return response()->json($reservations, 200);
        }
        catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
