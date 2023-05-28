<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('jobs/list', [JobController::class, 'getListJobs']);
Route::post('job/edit/{id}', [JobController::class, 'update']);
Route::post('job/create', [JobController::class, 'create']);
Route::get('job/delete/{id}', [JobController::class, 'delete']);

