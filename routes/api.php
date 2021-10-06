<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* 
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();


});

Route::get('users', 'App\Http\Controllers\Api\UsersController@users')->name('users');
Route::post('RegisterUser', 'App\Http\Controllers\Api\UsersController@RegisterUser')->name('RegisterUser');
Route::post('addUser', 'App\Http\Controllers\Api\UsersController@addUser')->name('addUser');
Route::delete('deleteUser/{id}', 'App\Http\Controllers\Api\UsersController@deleteUser')->name('deleteUser');
 
Route::post('login', 'App\Http\Controllers\Api\AuthController@login')->name('login');
Route::post('loginauth', 'App\Http\Controllers\Api\AuthController@loginauth')->name('loginauth');
Route::get('getUser/{id}', 'App\Http\Controllers\Api\UsersController@getUser')->name('getUser');
Route::post('updateUser', 'App\Http\Controllers\Api\UsersController@updateUser')->name('updateUser');
Route::post('AddEmployee', 'App\Http\Controllers\Api\EmployeeController@AddEmployee')->name('AddEmployee');
Route::get('getEmployees', 'App\Http\Controllers\Api\EmployeeController@getEmployees')->name('getEmployees');
Route::delete('deleteEmployee/{id}', 'App\Http\Controllers\Api\EmployeeController@deleteEmployee')->name('deleteEmployee');
Route::get('editEmployee/{id}', 'App\Http\Controllers\Api\EmployeeController@editEmployee')->name('editEmployee');
Route::post('updateEmployee', 'App\Http\Controllers\Api\EmployeeController@updateEmployee')->name('updateEmployee');