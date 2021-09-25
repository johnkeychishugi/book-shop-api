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

Route::get('/external-books',[BookController::class, 'getBooksExternalApi']);

Route::group(['prefix' => 'v1' ], function(){
    Route::post('/books',[BookController::class, 'createBook']);  
    Route::get('/books',[BookController::class, 'getBooks']);
    Route::patch('/books/{id}',[BookController::class,'updateBook']);
    Route::delete('/books/{id}',[BookController::class,'deleteBook']);
    Route::get('/books/{id}',[BookController::class,'getBook']);
});
 