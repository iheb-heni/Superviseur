<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
})->name('index');
Route::get('/redirect',[HomeController::class , 'handleredirect'])->name('handleredirect');
Auth::routes();

// Routes pour les utilisateurs normaux
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/employee/{id}', [HomeController::class, 'employee'])->name('employee');
    Route::get('/employee/profile/{id}', [EmployeeController::class, 'profile'])->name('emploee.profile');
    Route::put('/employee/profile/update', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');
    Route::get('/employee/machines/associee', [EmployeeController::class, 'employeemachine'])->name('employee.machines');

});

// Routes pour les administrateurs
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/{id}', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/profile/{id}', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/admin/password/update', [AdminController::class, 'updatePassword'])->name('admin.profile.updatePassword');
    Route::get('/admin/{id}/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/admins/add', [AdminController::class, 'addAdmin'])->name('admin.admins.add');
    Route::post('/admin/employees/add', [AdminController::class, 'addEmployee'])->name('admin.employees.add');
    Route::get('/admin/employee/edit/{employeeid}',[AdminController::class, 'editemployeeform'])->name('admin.employee.edit');
    Route::put('/admin/employee/update/{employeeid}', [AdminController::class, 'updateemployee'])->name('admin.employee.update');
    Route::delete('/admin/employee/delete/{employeeid}', [AdminController::class, 'deleteEmployee'])->name('admin.employee.delete');
    Route::get('/admin/employee/machines', [AdminController::class, 'employeemachine'])->name('admin.employee.machines');
    Route::get('/admin/all/machines', [AdminController::class, 'allmachinnes'])->name('admin.allmachinnes');
    Route::post('/admin/add-machine', [AdminController::class, 'addMachine'])->name('admin.addmachine');
    Route::delete('/admin/delete-machine/{machine_id}', [AdminController::class, 'deleteMachine'])->name('admin.deletemachine');
    Route::put('/admin/update-machine/{machine}', [AdminController::class, 'updateMachine'])->name('admin.updatemachine');
    Route::put('/admin/reinstallmachine/{machine_id}', [AdminController::class, 'reinstall'])->name('admin.reinstallmachine');
    Route::put('/admin/reinstallallmachines', [AdminController::class, 'reinstallAll'])->name('admin.reinstallallmachines');
    Route::delete('/admin/machines/delete-all', [AdminController::class, 'deleteAll'])->name('admin.deleteallmachines');
    Route::put('/admin/associate/machine', [AdminController::class, 'associateMachine'] )->name('admin.associate.machine');


});
