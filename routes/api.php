<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/home', [ProductController::class, 'getAll'])->middleware('auth:sanctum');
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user/{id}', [UserController::class, 'getById'])->middleware('auth:sanctum');
Route::get('/product/{id}', [ProductController::class, 'getById'])->middleware('auth:sanctum');
Route::post('/post-product', [ProductController::class, 'postProduct'])->middleware('auth:sanctum');
Route::get('/search', [ProductController::class, 'search'])->middleware('auth:sanctum');