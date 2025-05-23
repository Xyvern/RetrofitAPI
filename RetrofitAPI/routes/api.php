<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User Routes
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/users/{id}', [UserController::class, 'getUserById']);
Route::post('/users', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

// Product Routes
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProductById']);
Route::post('/products', [ProductController::class, 'createProduct']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
Route::get('/products/category/name/{categoryName}', [ProductController::class, 'getProductsByCategoryName']);
Route::get('/products/category/id/{categoryID}', [ProductController::class, 'getProductsByCategoryID']);

// Order Routes
Route::get('/orders', [OrderController::class, 'getAllOrders']);
Route::get('/orders/{id}', [OrderController::class, 'getOrderById']);
Route::get('/orders/{userid}', [OrderController::class, 'getOrderByUserID']);
Route::post('/orders', [OrderController::class, 'createOrder']);
Route::put('/orders/{id}', [OrderController::class, 'updateOrder']);
Route::delete('/orders/{id}', [OrderController::class, 'deleteOrder']);