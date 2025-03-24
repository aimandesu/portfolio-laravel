<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Experience\ExperienceController;
use App\Http\Controllers\Files\FilesController;
use App\Http\Controllers\User\UserController;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UserController::class)->except(['create', 'edit']);
Route::name('uploadImage')->post('users/{user}/uploadImage', [UserController::class, 'uploadImage']);


Route::resource('experience', ExperienceController::class)->except(['create', 'edit']);
Route::name('getExperienceAvailable')->get('getExperienceAvailable', [ExperienceController::class, 'getExperienceAvailable']);



Route::name('getFilesOnUser')->get('getFilesOnUser', [FilesController::class, 'getFilesOnUser']);
