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


Auth::routes();

Route::group([
    'middleware' => ['auth']
    ],
    function() {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/imprime_hr/{hojaRuta}/{pos}', 'ImpresionHRController@show')->name('impresion_hr');
});

Route::get('/reporte/{reporte}/html', 'ReporteController@html')->name('reportehtml');
Route::get('/reporte/{reporte}/excel', 'ReporteController@excel')->name('reporteexcel');
Route::get('/reporte/{reporte}/pdf', 'ReporteController@pdf')->name('reportepdf');
