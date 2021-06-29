<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ConfigurationController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogController::class, 'index']);
Route::get('/carrito', [CatalogController::class, 'shop'])->name('shop');
Route::get('/destino', [CatalogController::class, 'from'])->name('destino');
Route::get('/pagar', [CatalogController::class, 'pay'])->name('pay');
Route::group(['middleware' => 'auth'], function () {
	Route::get('categorias', [ConfigurationController::class, 'categories']);
	Route::post('saveCategory', [ConfigurationController::class, 'saveCategory']);
    Route::post('updateStateCategory', [ConfigurationController::class, 'updateStateCategory']);
    Route::get('dtCategory', [ConfigurationController::class, 'dtCategory'])->name('dtCategory');
    Route::get('sub_categorias', [ConfigurationController::class, 'sub_categories']);
    Route::post('saveSubCategory', [ConfigurationController::class, 'saveSubCategory']);
    Route::post('updateStateSubCategory', [ConfigurationController::class, 'updateStateSubCategory']);
    Route::get('dtSubCategory', [ConfigurationController::class, 'dtSubCategory'])->name('dtSubCategory');
    Route::get('articulos', [ConfigurationController::class, 'articles']);
    Route::post('saveArticle', [ConfigurationController::class, 'saveArticle']);
    Route::post('updateStateArticle', [ConfigurationController::class, 'updateStateArticle']);
    Route::post('updateDiscount', [ConfigurationController::class, 'updateDiscount'])->name('updateDiscount');
    Route::post('updateDiscountDisable', [ConfigurationController::class, 'updateDiscountDisable'])->name('updateDiscountDisable');
    Route::post('deleteImage', [ConfigurationController::class, 'deleteImage'])->name('deleteImage');
    Route::get('dtArticle', [ConfigurationController::class, 'dtArticle'])->name('dtSubCategory');
    Route::get('metodos_pago', [ConfigurationController::class, 'payment_methods'])->name('payment_methods');
    Route::get('dtPaymentMethods', [ConfigurationController::class, 'dtPaymentMethods'])->name('dtPaymentMethods');
    Route::post('savePaymentMethod', [ConfigurationController::class, 'savePaymentMethod']);
});
