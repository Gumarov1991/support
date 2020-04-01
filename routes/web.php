<?php

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

Route::get('/', 'Cabinet\HomeController@index')->name('home');

Auth::routes();
Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('tickets', 'TicketController')->only(['create', 'store']);
        Route::get('tickets/{ticket}', 'TicketController@show')
            ->name('tickets.show')
            ->middleware('can:own-ticket,ticket');
        Route::get('tickets/{ticket}/close', 'TicketController@close')->name('tickets.close');
        Route::post('tickets/{ticket}/message', 'TicketController@message')->name('tickets.message');

}
);

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'can:admin-panel'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('tickets/{ticket}', 'TicketController@show')->name('tickets.show');
        Route::get('tickets/{ticket}/close', 'TicketController@close')->name('tickets.close');
        Route::post('tickets/{ticket}/message', 'TicketController@message')->name('tickets.message');
        Route::get('tickets/{ticket}/take', 'TicketController@take')->name('tickets.take');
    }
);


