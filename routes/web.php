<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

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

Route::post(
    '/stripe/webhook',
    [WebhookController::class, 'handleWebhook']
);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/notice', function () {
    return view('notice');
})->name('notice');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::middleware(['auth:sanctum', 'verified'])->get('/subscribe/callback', [App\Http\Controllers\Subscribe::class,'callback'])->name('subscribe.callback');
Route::middleware(['auth:sanctum', 'verified'])->get('/subscribe/mine', [App\Http\Controllers\Subscribe::class,'mine'])->name('subscribe.mine');
Route::middleware(['auth:sanctum', 'verified'])->get('/subscribe/{plan}', [App\Http\Controllers\Subscribe::class,'go'])->name('subscribe.go');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/settings', function () {
    return view('settings');
})->name('settings');

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/members', function () {
    return view('members');
})->name('members');

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/droplets', function () {
    return view('droplets');
})->name('droplets');

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/plans', function () {
    return view('plans');
})->name('plans.list');

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/plans/create', function () {
    return view('plans.create');
})->name('plans.create');

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/plans/modify/{plan_id}', function () {
    return view('plans.modify');
})->name('plans.modify');
