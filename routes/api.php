<?php

use App\Http\Controllers\CatalogController;
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
Route::get('getSubCategories', [CatalogController::class, 'getSubCategories'])->name('getSubCategories');
Route::get('getCategories', [CatalogController::class, 'getCategories'])->name('getCategories');
Route::get('getCatalogArticles', [CatalogController::class, 'getCatalogArticles'])->name('getCatalogArticles');
Route::get('getPaymentMethod', [CatalogController::class, 'getPaymentMethod'])->name('getPaymentMethod');
Route::post('checkShoppingCart', [CatalogController::class, 'checkShoppingCart'])->name('checkShoppingCart');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
