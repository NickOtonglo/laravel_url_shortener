<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UrlController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/{randString}', '\App\Http\Controllers\Api\UrlController@redirect')->name('redirect');
