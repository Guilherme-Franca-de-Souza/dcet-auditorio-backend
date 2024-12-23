<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Equipment;
use App\Models\Penalty;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Método para exibir o dashboard do usuário
    public function index()
    {
        $user = Auth::user();
        return response()->json(['message' => 'Dashboard', 'user' => $user], 200);
    }
}
