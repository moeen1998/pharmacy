<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MedicienController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ParchaseController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();


Route::resource('users', UserController::class);
Route::get('current', [UserController::class,'current']);
Route::resource('suppliers', SupplierController::class);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('places', PlaceController::class);
Route::resource('drugs', MedicienController::class);
Route::resource('companies', CompanyController::class);
Route::resource('categories', CategoryController::class);
Route::resource('parchases', ParchaseController::class);
Route::resource('orders', OrderController::class);
Route::get('/root', [App\Http\Controllers\RootController::class, 'index']);


Route::get('/user/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/user', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/supplier/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/supplier', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/place/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/place', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/drug/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/drug', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/company/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/company', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/category/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/category', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/parchase/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/parchase', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/order/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
Route::get('/order', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/suppiercompany/{ig}', function($id){
    $company = Company::find($id);
    
    return $company->suppliers;
});

// Route::resource('users/add', [UserController::class, 'register']);
