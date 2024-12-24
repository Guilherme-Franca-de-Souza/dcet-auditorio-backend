<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Equipment;
use App\Models\Penalty;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Listar reservas do usuário autenticado
    public function index()
    {
        $user = Auth::user();
        $reservations = $user->reservations;
        return response()->json($reservations, 200);
    }

    // Exibir detalhes de uma reserva
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($reservation, 200);
    }

    // Criar uma nova reserva
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'auditorium_id' => 'required|exists:auditoriums,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'description' => 'required|string|max:255',
                'participants_count' => 'required|integer|min:1',
                'equipment' => 'array',
                'equipment.*' => 'exists:equipment,id',
            ]);

            $overlap = Reservation::where('auditorium_id', $validatedData['auditorium_id'])
                ->where(function ($query) use ($validatedData) {
                    $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                        ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']]);
                })->exists();

            if ($overlap) {
                return response()->json(['message' => 'Auditorium is not available at the chosen time'], 422);
            }

            $reservation = Auth::user()->reservations()->create($validatedData);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

        return response()->json(['message' => 'Reservation created successfully', 'reservation' => $reservation], 201);
    }

    // Cancelar uma reserva
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            if ($reservation->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            if (now()->diffInHours($reservation->start_time) < 24) {
                // Adicionar penalidade
                Penalty::create([
                    'user_id' => Auth::id(),
                    'start_date' => now(),
                    'end_date' => now()->addMonth(),
                ]);
                return response()->json(['message' => 'Reservation canceled late. Penalty applied.'], 200);
            }

            $reservation->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }
        return response()->json(['message' => 'Reservation canceled successfully'], 200);
    }

    // Histórico de reservas
    public function history()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->withTrashed()->get();
        return response()->json($reservations, 200);
    }

    // Listar reservas pendentes (admin)
    public function pending()
    {
        $reservations = Reservation::where('approved', false)->get();
        return response()->json($reservations, 200);
    }

    // Aprovar uma reserva (admin)
    public function approve($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update(['approved' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }
        return response()->json(['message' => 'Reservation approved successfully'], 200);
    }

    // Rejeitar uma reserva (admin)
    public function reject($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }
        return response()->json(['message' => 'Reservation rejected successfully'], 200);
    }
}
