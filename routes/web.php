<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/data', [NewsController::class, 'getNews'])->name('getNews');
Route::get('/', [NewsController::class, 'index'])->name('index');


// Route::get('/', function () {
//     return redirect()->route('admin.employees.index');
// })->name('home');

// Admin routes
// Route::prefix('admin')->as('admin.')->group(function ()
// {
//     //Employees cruds
//     Route::delete('employees/delete', [EmployeeController::class, 'delete'])->name('employees.delete');;
//     Route::resource('employees', EmployeeController::class);
//     Route::get('employees-data', [EmployeeController::class, 'data'])->name('employees.data');
    
//     //Departments cruds
//     Route::delete('departments/delete', [DepartmentController::class, 'delete'])->name('departments.delete');;
//     Route::resource('departments', DepartmentController::class);
//     Route::get('departments-data', [DepartmentController::class, 'data'])->name('departments.data');
// });

require __DIR__.'/auth.php';