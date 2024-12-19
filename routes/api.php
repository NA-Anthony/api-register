<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Utilisateur;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/authenticate', function (\Illuminate\Http\Request $request) {
    $utilisateur = new Utilisateur(); 
    return $utilisateur->authenticate($request);
});
Route::post('/auth/verify-pin', [AuthController::class, 'verifyPin']);
