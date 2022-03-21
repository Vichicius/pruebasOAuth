<?php

use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('googlelogin', function() {
    return redirect()->route('externalLogin');
});

Route::get('/auth/redirect', [UserController::class, 'redirect'])->name('externalLogin');

//este al google api console developer y al env
Route::get('/auth/callback', [UserController::class, 'createUser'])->name('loginCall');;
