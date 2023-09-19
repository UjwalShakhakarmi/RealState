<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\RoleController;
use App\Models\Amenities;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::middleware(['auth','roles:admin'])->group(function()
{
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/Profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/Profile/Store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/Profile/ChangePassword', [AdminController::class, 'AdminChangePassword'])->name('admin.profile.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

}); //End Group Admin Middleware

Route::middleware(['auth','roles:agent'])->group(function()
{
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
}); //End Group Agent Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::get('/admin/Register', [AdminController::class, 'AdminRegister'])->name('admin.Register');

Route::middleware(['auth','roles:admin'])->group(function()
{
//Property Type All Route
Route::controller(PropertyTypeController::class)->group(function(){
    Route::get('/all/type','AllType')->name('all.type')->middleware('permission:all.type');
    Route::get('/add/type','AddType')->name('add.type');
    Route::post('/store/type','StoreType')->name('store.type');
    Route::get('/edit/type/{id}','EditType')->name('edit.type');
    Route::post('/update/type','UpdateType')->name('update.type');
    Route::get('/delete/type/{id}','DeleteType')->name('delete.type');

});

Route::controller(AmenitiesController::class)->group(function(){
    Route::get('/all/Amenities','AllAmenities')->name('all.amenities');
    Route::get('/add/Amenities','AddAmenities')->name('add.amenities');
    Route::post('/store/Amenities','StoreAmenities')->name('store.amenities');
    Route::post('/Update/Amenities','UpdateAmenities')->name('update.amenities');
    Route::get('/delete/Amenities/{id}','DeleteAmenities')->name('delete.amenities');
    Route::get('/edit/Amenities/{id}','EditAmenities')->name('edit.amenities');
});
//Permission All Route
Route::controller(RoleController::class)->group(function()
{
    Route::get('/all/permission','AllPermission')->name('all.Permission');
    Route::get('/add/permission','AddPermission')->name('add.Permission');
    Route::post('/store/permission','StorePermission')->name('store.Permission');
    Route::get('/edit/permission/{id}','EditPermission')->name('edit.Permission');
    Route::get('/Delete/permission/{id}','DeletePermission')->name('delete.Permission');
    Route::post('/Update/permission','UpdatePermission')->name('Update.Permission');
});

Route::controller(RoleController::class)->group(function(){
    Route::get('/all/Roles','AllRoles')->name('all.roles');
    Route::get('/add/Roles','AddRoles')->name('add.roles');
    Route::post('/store/Roles','StoreRoles')->name('store.roles');
    Route::get('/edit/Roles/{id}','EditRoles')->name('edit.roles');
    Route::get('/Delete/Roles/{id}','DeleteRoles')->name('delete.roles');
    Route::post('/Update/Roles','UpdateRoles')->name('Update.roles');

    Route::get('/add/Roles/Permission','AddRolesPermission')->name('add.roles.permission');
    Route::post('/Roles/Permission/Store','StoreRolesPermission')->name('role.permission.store');
    Route::get('/all/Roles/Permission','AllRolesPermission')->name('all.roles.permission');
    Route::get('/edit/Roles/Permission/{id}','AdminEditRoles')->name('admin.edit.roles');
    Route::get('/Delete/Roles/Permission/{id}','AdminDeleteRoles')->name('admin.delete.roles');
    Route::post('/Update/Roles/Permission/{id}','AdminUpdateRoles')->name('admin.Update.roles');
    
    
});
//admin user all routes
Route::controller(AdminController::class)->group(function(){
    Route::get('/all/admin', 'AllAdmin')->name('all.admin');
    Route::get('/add/admin', 'AddAdmin')->name('add.admin');
    Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
    Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
    Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
    Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
});


});
