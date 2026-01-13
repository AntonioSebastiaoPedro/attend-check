<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;

// Rotas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas (requerem autenticação)
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Turmas
    Route::resource('classes', ClassRoomController::class);
    Route::get('/classes/{class}/students', [ClassRoomController::class, 'students'])->name('classes.students');
    Route::post('/classes/{class}/students', [ClassRoomController::class, 'attachStudents'])->name('classes.students.attach');
    Route::delete('/classes/{class}/students/{student}', [ClassRoomController::class, 'detachStudent'])->name('classes.students.detach');

    // Estudantes
    Route::resource('students', StudentController::class);

    // Frequência
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/mark', [AttendanceController::class, 'markAttendance'])->name('attendances.mark');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
});
