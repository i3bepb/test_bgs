<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(function () {
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register','AuthController@register')->name('register');
    Route::get('/unauthorized', 'AuthController@unauthorized')->name('unauthorized');
    Route::middleware(['auth:sanctum'])->name('api.')->group(function () {
        Route::post('/logout', 'AuthController@logout')->name('logout');
        Route::post('/members', 'MemberController@index')->name('members');
        Route::resource('member', 'MemberController')->except([
            'index',
            'edit',
            'create',
        ])->parameters([
            'member' => 'id'
        ]);;
    });
});