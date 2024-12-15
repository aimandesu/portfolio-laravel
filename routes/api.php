<?php

use App\Http\Controllers\Controller;
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

// routes/web.php
Route::resource('projects', ProjectController::class);
Route::resource('users', UserController::class);
Route::resource('experiences', ExperienceController::class);
Route::resource('skills', SkillController::class);
Route::resource('education', EducationController::class);
Route::resource('files', FileController::class);

// app/Http/Controllers/ProjectController.php
class ProjectController extends Controller
{
    // Implement CRUD operations for projects
}

// app/Http/Controllers/UserController.php
class UserController extends Controller
{
    // Implement CRUD operations for users
}

// app/Http/Controllers/ExperienceController.php
class ExperienceController extends Controller
{
    // Implement CRUD operations for experiences
}

// app/Http/Controllers/SkillController.php
class SkillController extends Controller
{
    // Implement CRUD operations for skills
}

// app/Http/Controllers/EducationController.php
class EducationController extends Controller
{
    // Implement CRUD operations for education
}

// app/Http/Controllers/FileController.php
class FileController extends Controller
{
    // Implement CRUD operations for files
}
