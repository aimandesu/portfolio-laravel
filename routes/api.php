<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Education\EducationController;
use App\Http\Controllers\Experience\ExperienceController;
use App\Http\Controllers\Files\FilesController;
use App\Http\Controllers\Skill\SkillController;
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

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('users', [UserController::class, 'index']);  
    // Route::post('users', [UserController::class, 'store']); 
    Route::put('users/{user}', [UserController::class, 'update']); 
    Route::delete('users/{user}', [UserController::class, 'destroy']);

    //Auth
    Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    //Education
    Route::resource('education', EducationController::class)->except(['create', 'edit', 'destroy']);
    Route::get('education/user/{user}', [EducationController::class, 'show']);
    Route::delete('education/delete', [EducationController::class, 'destroyEducation']);
    
    //Skill
    Route::resource('skill', SkillController::class)->except(['create', 'edit']);
    Route::get('skill/user/{user}', [SkillController::class, 'show']);

    //Experience
    Route::resource('experience', ExperienceController::class)->except(['create', 'edit']);

    //Files
    Route::resource('files', FilesController::class)->except(['create', 'edit']);
});

//public routes
//User
Route::get('users/{user}', [UserController::class, 'show']);
Route::name('uploadImage')->post('users/{user}/uploadImage', [UserController::class, 'uploadImage']);

//Auth
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']); 

//Experience
Route::name('getExperienceAvailable')->get('getExperienceAvailable', [ExperienceController::class, 'getExperienceAvailable']);


