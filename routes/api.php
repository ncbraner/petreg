<?php

use App\Data\Validations\PetRegistrationValidations;
use App\Http\Controllers\UserController;
use App\Http\Requests\PetRegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetRegistrationController;
use App\Http\Controllers\BreedController;
use GuzzleHttp\Client;


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



Route::group(['middleware' => 'auth0'], function () {
    Route::post('/pet-registrations', [PetRegistrationController::class, 'store']);
    Route::get('/pet-registrations', [PetRegistrationController::class, 'getAllByUser']);
});

Route::get('/breeds', [BreedController::class, 'getBreedsByType']);
Route::get('/get-user', [UserController::class, 'getUser']);

Route::get('/validation-rules', function () {
    return response()->json((new PetRegistrationValidations())->rulesToJson());
});


