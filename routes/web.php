<?php

use Illuminate\Support\Facades\Route;

// Define the route for the homepage
Route::get('/', function () {
    return view('index');
});
