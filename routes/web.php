<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


// routes untuk data portofolio
// Route::get('/photo', 'photoController@phototampil');