<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductDocumentController;

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

Route::get('/', [ProductDocumentController::class, 'index'])->name('home');

Route::get('product-documents', [ProductDocumentController::class, 'index'])->name('product-document.index');
Route::post('product-documents', [ProductDocumentController::class, 'store'])->name('product-document.store');
Route::get('product-documents-data', [ProductDocumentController::class, 'data'])->name('product-document.data');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
