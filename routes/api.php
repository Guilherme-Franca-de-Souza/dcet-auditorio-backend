<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rotas Públicas
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
});

// Rotas Protegidas (Apenas para Usuários Autenticados)
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard do Usuário
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de Reservas
    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::get('/history', [ReservationController::class, 'history'])->name('reservations.history');
    });
});

// Rotas Protegidas para Administradores
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Gerenciamento de Usuários
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Gerenciamento de Auditórios
    Route::prefix('auditoriums')->group(function () {
        Route::get('/', [AuditoriumController::class, 'index'])->name('admin.auditoriums.index');
        Route::post('/', [AuditoriumController::class, 'store'])->name('admin.auditoriums.store');
        Route::get('/{id}', [AuditoriumController::class, 'show'])->name('admin.auditoriums.show');
        Route::put('/{id}', [AuditoriumController::class, 'update'])->name('admin.auditoriums.update');
        Route::delete('/{id}', [AuditoriumController::class, 'destroy'])->name('admin.auditoriums.destroy');
    });

    // Aprovação de Reservas
    Route::prefix('reservations')->group(function () {
        Route::get('/pending', [ReservationController::class, 'pending'])->name('admin.reservations.pending');
        Route::post('/{id}/approve', [ReservationController::class, 'approve'])->name('admin.reservations.approve');
        Route::post('/{id}/reject', [ReservationController::class, 'reject'])->name('admin.reservations.reject');
    });

    // Dashboard Administrativo
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});















/*
Route::post("/register", function (Request $request) {
    $request->validate([
        'email' => "required|string|email|unique:users",
        'name' => "required|string|max:32",
        'password' => "required|string|min:6",
    ]);

    $user = User::create([
        "email" => $request->email,
        "name" => $request->name,
        "password" => Hash::make($request->password),
    ]);

    return request()->json([
        "message" => "Sucesso",
        "user" => $user,
    ]);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => 'Bearer'
        ]);
    }

    return response()->json([
        "message" => 'Não foi possível autenticar'
    ]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
