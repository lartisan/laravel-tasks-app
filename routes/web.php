<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Auth::routes(['registration' => false]);

Route::get('/home', 'HomeController@index')->name('home');
