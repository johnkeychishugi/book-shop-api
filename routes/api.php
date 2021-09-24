<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1' ], function(){
    Route::get('/external-books',[BookController::class, 'getBooksExternalApi']);
    Route::post('/books',[BookController::class, 'createBook']);  
    Route::get('/books',[BookController::class, 'getBooks']);
    Route::patch('/books/{id}',[BookController::class,'updateBook']);
    Route::delete('/books/{id}',[BookController::class,'deleteBook']);

});
 