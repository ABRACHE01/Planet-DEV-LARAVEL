<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\categoryController;
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

//authentication Routes:
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth');
    Route::post('forgot', 'forgot');
    Route::post('reset/{token}', 'reset')->name('reset.password.post');
    Route::get('/email/verify/{id}/{hash}', 'verify')
    ->name('verification.verify');
});
//comment crud apiresources
Route::apiResource('comments', CommentController::class);



Route::get('sortcategory',[categoryController::class,'sortcategory'] );
//category crud routes
Route::apiresource('categories', categoryController::class);
Route::apiResource('articles', ArticleController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user',[UserController::class,'user']);
    Route::put('user/updatePassword',[UserController::class,'updatePassword']);
    Route::put('user/updateName',[UserController::class,'updateName']);
    Route::put('user/updateEmail',[UserController::class,'updateEmail']);
});



// Tags routes
Route::apiResource('tags', TagController::class);
Route::get('SortByTag/{tag_id}', [TagController::class, 'SortByTag']);


// Route::middleware()->group(function () {
    Route::get('users' , [UserController::class,'users']);
    Route::put('admin/switch-role/{id}' ,[UserController::class,'switchRole']);
    Route::get('user/{id}', [UserController::class,'showOneUser']);
// });