<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Auditorium;
use app\Models\Equipment;
use app\Models\Penalty;
use app\Models\Reservation;
use app\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Listar usuários
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    // Aprovar usuário
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approved' => true]);
        return response()->json(['message' => 'User approved successfully'], 200);
    }

    // Desativar usuário
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approved' => false]);
        return response()->json(['message' => 'User deactivated successfully'], 200);
    }

    // Remover usuário
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
