<?php

use App\Http\Controllers\admin\AuthUserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\InventoryController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\ManagerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\EventsController as clientEventsController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', 'store')->name('login');
    });

    Route::post('/logout', 'destroy')->middleware('auth')->name('logout');
});

// Route::middleware('client')->group(function () {
//     Route::get('/', function () {
//         return view('pages.client.index');
//     });
// });

Route::prefix("/")->group(function () {
    Route::get('/', HomeController::class);
    Route::get('/liveEvents', [clientEventsController::class, 'index']);
    Route::get('/upcomingEvents', [clientEventsController::class, 'upcomingEvents']);
    Route::get('/eventDetails/{event}', [clientEventsController::class, 'show']);
    Route::get('/itemDetails/{item}', [clientEventsController::class, 'item']);
    Route::view('/aboutUs', "pages.client.about");
});

Route::middleware(['auth', 'role:admin|manager|employee'])->prefix('/dashboard')->group(function () {

    Route::get('/', [EventController::class,'index']);
    Route::controller(EventController::class)->prefix('/events')->group(function () {
        Route::get('/', 'index');
        Route::get('/downloadItems/{event}', 'export');
        Route::get('/addEvent', 'create');
        Route::post('/addEvent', 'store');
        Route::get('/updateEvent/{event}', 'edit');
        Route::put('/updateEvent/{event}', 'update');
        Route::delete('/deleteEvent/{event}', 'destroy');
    });

    Route::controller(InventoryController::class)->prefix('/inventory')->group(function () {
        Route::get('/', 'index');
        Route::get('/addItem', 'create');
        Route::post('/addItem', 'store');
        Route::get('/updateItem/{product}', 'edit');
        Route::delete('/deleteImages/{product}', 'deleteImages');
        Route::put('/updateItem/{product}', 'update');
        Route::delete('/deleteItem/{product}', 'destroy');
    });

    Route::controller(ManagerController::class)->prefix('/managers')->group(function () {
        Route::get('/', 'index');
        Route::get('/addManager', 'create');
        Route::post('/addManager', 'store');
        Route::get('/updateManager/{user:uuid}', 'edit');
        Route::put('/updateManager/{user:uuid}', 'update');
        Route::delete('/deleteManager/{user:uuid}', 'destroy');
    });

    Route::controller(EmployeeController::class)->prefix('/employees')->group(function () {
        Route::get('/', 'index');
        Route::get('/addEmployee', 'create');
        Route::post('/addEmployee', 'store');
        Route::get('/updateEmployee/{user:uuid}', 'edit');
        Route::put('/updateEmployee/{user:uuid}', 'update');
        Route::delete('/deleteEmployee/{user:uuid}', 'destroy');
    });

    Route::controller(CategoryController::class)->prefix('/categories')->group(function () {
        Route::get('/', 'index');
        Route::get('/addCategory', 'create');
        Route::post('/addCategory', 'store');
        Route::get('/updateCategory/{category}', 'edit');
        Route::patch('/updateCategory/{category}', 'update');
        Route::delete('/deleteCategory/{category}', 'destroy');
    });

    Route::controller(LocationController::class)->prefix('/locations')->group(function () {
        Route::get('/', 'index');
        Route::get('/addLocation', 'create');
        Route::post('/addLocation', 'store');
        Route::get('/updateLocation/{location}', 'edit');
        Route::patch('/updateLocation/{location}', 'update');
        Route::delete('/deleteLocation/{location}', 'destroy');
    });

    Route::controller(AuthUserController::class)->prefix('/settings')->group(function () {
        Route::get('/', 'show')->name('settings');
        Route::get('/update', 'edit');
        Route::put('/update', 'update');
        Route::delete('/delete', 'destroy');
    });
});