<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RecoverPasswordCodeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Rota pública
Route::post('/', [LoginController::class, 'login'])->name('login'); // POST - http://127.0.0.1:8000/api/ - { "email": "cesar@celke.com.br", "password": "123456a" }

// Recuperar a senha
Route::post("/forgot-password-code", [RecoverPasswordCodeController::class, 'forgotPasswordCode']);
Route::post("/reset-password-validate-code", [RecoverPasswordCodeController::class, 'resetPasswordValidateCode']);
Route::post("/reset-password-code", [RecoverPasswordCodeController::class, 'resetPasswordCode']);

// Rota restrita
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('/users', [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/users?page=2

    Route::post('/logout/{user}', [LoginController::class, 'logout']); // POST - http://127.0.0.1:8000/api/logout/1
});
