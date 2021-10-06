
<?php

use App\Http\Controllers\PostController;
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

Route::get('/welcome', function () { 
    return view('welcome');
});
     

Route::get('/new_register',[PostController::class , 'index']);
Route::get('/testing/{id}',\App\Http\Controllers\PostController::class . '@show');

Route::get('/register', function(){
return view('register');

});

Route::get('/user' ,\App\Http\Controllers\PostController::class . '@user')->name('user');
Route::post('/UpdateUser' ,\App\Http\Controllers\PostController::class . '@UpdateUser')->name('UpdateUser');

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/', function () {

        return view('dashboard');
    });
});

 
Route::get('/dashboard', function () {

            $users = DB::select('select * from users');
        return view('dashboard', ['users' => $users]);
})->middleware(['auth'])->name('dashboard');
// Route::get('/users' , function)
Route::get('/Testing_users', function () {
    return view('Testing_users');
});

Route::get('/Delete/{id}',\App\Http\Controllers\PostController::class . '@Delete')->name('Delete');
Route::get('/CreateUser',\App\Http\Controllers\PostController::class . '@CreateUser')->name('CreateUser');
Route::post('/CreateNewUser',\App\Http\Controllers\PostController::class . '@CreateNewUser')->name('CreateNewUser');
Route::get('/imageCropper',\App\Http\Controllers\imageCropperController::class . '@imageUpload')->name('imageUpload');
 
// Route::get('imageCropper', '\App\Http\Controllers\imageCropperController@imageUpload')->name('imageUpload');

require __DIR__.'/auth.php';
