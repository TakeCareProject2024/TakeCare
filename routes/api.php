<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;

// Company Routes
Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index']); // Get all companies
    Route::post('/', [CompanyController::class, 'store']); // Create a new company
    Route::get('{id}', [CompanyController::class, 'show']); // Get a specific company
    Route::put('{id}', [CompanyController::class, 'update']); // Update a specific company
    Route::delete('{id}', [CompanyController::class, 'destroy']); // Delete a specific company
    Route::post('/login',[CompanyController::class, 'Login']);//login to admin dashboard
});

// Employee Routes
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']); // Get all employees
    Route::post('/', [EmployeeController::class, 'store']); // Create a new employee
    Route::get('{id}', [EmployeeController::class, 'show']); // Get a specific employee
    Route::put('{id}', [EmployeeController::class, 'update']); // Update a specific employee
    Route::delete('{id}', [EmployeeController::class, 'destroy']); // Delete a specific employee
});

// Order Routes
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']); // Get all orders
    Route::post('/', [OrderController::class, 'store']); // Create a new order
    Route::get('{id}', [OrderController::class, 'show']); // Get a specific order
    Route::put('{id}', [OrderController::class, 'update']); // Update a specific order
    Route::delete('{id}', [OrderController::class, 'destroy']); // Delete a specific order
});

Route::post('/order',[OrderController::class,'store'])->name('AddOrder');