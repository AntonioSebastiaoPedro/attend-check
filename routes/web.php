<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;

// Rotas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas públicas e de convidados (redirecionam se logado)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rotas protegidas (requerem autenticação)
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Turmas (Visualização)
    Route::get('/classes', [ClassRoomController::class, 'index'])->name('classes.index');
    Route::get('/classes/{class}', [ClassRoomController::class, 'show'])->name('classes.show');

    // Turmas (Gestão apenas Admin)
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/classes/create', [ClassRoomController::class, 'create'])->name('classes.create');
        Route::post('/classes', [ClassRoomController::class, 'store'])->name('classes.store');
        Route::get('/classes/{class}/edit', [ClassRoomController::class, 'edit'])->name('classes.edit');
        Route::put('/classes/{class}', [ClassRoomController::class, 'update'])->name('classes.update');
        Route::delete('/classes/{class}', [ClassRoomController::class, 'destroy'])->name('classes.destroy');
    });

    // Gestão de Alunos na Turma (Admin e Professores)
    Route::get('/classes/{class}/students', [ClassRoomController::class, 'students'])->name('classes.students');
    Route::post('/classes/{class}/students', [ClassRoomController::class, 'attachStudents'])->name('classes.students.attach');
    Route::delete('/classes/{class}/students/{student}', [ClassRoomController::class, 'detachStudent'])->name('classes.students.detach');

    // Estudantes
    Route::resource('students', StudentController::class);

    // Frequência
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
    Route::get('/attendances/mark', [AttendanceController::class, 'markAttendance'])->name('attendances.mark');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');

    // Gestão de Usuários (Apenas Admin)
    Route::middleware(['can:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});
