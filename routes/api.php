<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
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
    Route::post('reset', 'reset');
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
    Route::put('user/updatePassword',[UserController::class,'updatePassword']);
    Route::put('user/updateName',[UserController::class,'updateName']);
    Route::put('user/updateEmail',[UserController::class,'updateEmail']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});


// Tags routes
Route::apiResource('tags', TagController::class);
Route::get('SortByTag/{tag_id}', [TagController::class, 'SortByTag']);
