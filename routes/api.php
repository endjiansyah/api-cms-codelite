<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// ----------( user )---------
Route::get("/user", [UserController::class, "index"])->middleware("auth:sanctum");
Route::get("/user/{id}", [UserController::class, "show"])->middleware("auth:sanctum");
// Route::post("/user/forgotpass", [UserController::class, "forgotpass"]);
Route::post("/user/add", [UserController::class, "store"])->middleware("auth:sanctum");
Route::post("/user/{id}/edit", [UserController::class, "update"])->middleware("auth:sanctum");
Route::post("/user/{id}/delete", [UserController::class, "destroy"])->middleware("auth:sanctum");

// ---------{news}-------
Route::get("/news", [NewsController::class, "index"]);
Route::get("/news/{id}", [NewsController::class, "show"]);
Route::post("/news", [NewsController::class, "store"]);
Route::post("/news/{id}/edit", [NewsController::class, "update"]);
Route::post("/news/{id}/delete", [NewsController::class, "destroy"]);

// ---------{Auth}-------
Route::post("/login", [AuthController::class, "login"]);
Route::get("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
Route::get("/me", [AuthController::class, "getUser"])->middleware("auth:sanctum");