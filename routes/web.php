<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassRoomController;
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

    // Estudantes
    Route::resource('students', StudentController::class);

    // Turmas
    Route::resource('classes', ClassRoomController::class);
    Route::get('/classes/{class}/manage-students', [ClassRoomController::class, 'manageStudents'])
        ->name('classes.manage-students');
    Route::post('/classes/{class}/attach-students', [ClassRoomController::class, 'attachStudents'])
        ->name('classes.attach-students');
    Route::delete('/classes/{class}/students/{student}', [ClassRoomController::class, 'detachStudent'])
        ->name('classes.detach-student');

    // Presenças
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/mark', [AttendanceController::class, 'markAttendance'])->name('attendances.mark');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/students/{student}/history', [AttendanceController::class, 'studentHistory'])
        ->name('attendances.student-history');
    Route::get('/classes/{class}/report', [AttendanceController::class, 'classReport'])
        ->name('attendances.class-report');
});
