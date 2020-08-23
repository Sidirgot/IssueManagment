<?php

Route::get('/', function() {
    return redirect()->route('login');
});

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('manage')->middleware(['auth', 'role:manager'])->group( function() {
    Route::get('/{any}', 'Api\Managers\DashboardController@index')->where('any', '.*')->name('manager.dashboard');
});

Route::prefix('team')->middleware(['auth'])->group( function() {
    Route::get('/{any}', 'Api\Team\DashboardController@index')->where('any', '.*')->name('tester.dashboard');
});
