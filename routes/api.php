<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\AppointmentController;
//Exports
use Maatwebsite\Excel\Facades\Excel;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    });

    Route::apiResources([
        'patients' => PatientController::class,
        'dentists' => DentistController::class,
    ]);
});
// Public API routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//Patients
Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients/create', [PatientController::class, 'store']);
Route::put('/patients/update/{id}', [PatientController::class, 'update']);
Route::delete('/patients/delete/{id}', [PatientController::class, 'destroy']);

//Dentists
Route::get('/dentists', [DentistController::class, 'index']);
Route::post('/dentists/create', [DentistController::class, 'store']);
Route::put('/dentists/update/{id}', [DentistController::class, 'update']);
Route::delete('/dentists/delete/{id}', [DentistController::class, 'destroy']);

//Appointments
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments/create', [AppointmentController::class, 'store']);
Route::put('/appointments/update/{id}', [AppointmentController::class, 'update']);
Route::delete('/appointments/delete/{id}', [AppointmentController::class, 'destroy']);
?>