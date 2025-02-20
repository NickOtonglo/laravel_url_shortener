<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('encode', '\App\Http\Controllers\Api\UrlController@encode');
Route::post('decode', '\App\Http\Controllers\Api\UrlController@decode');