<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Auditorium;
use app\Models\Equipment;
use app\Models\Penalty;
use app\Models\Reservation;
use app\Models\User;
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
