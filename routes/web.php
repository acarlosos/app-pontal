<?php

use Carbon\Carbon;
use App\Models\Corte;
use App\Imports\TesteImport;
use Illuminate\Support\Facades\Storage;

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



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::namespace('Remessa')->group(function () {
    Route::get('/remessa', 'RemessaController@index')->name('remessa.index');
    Route::post('/remessa', 'RemessaController@store')->name('remessa.store');
    Route::get('/remessa/list', 'RemessaController@list')->name('remessa.list');
    Route::get('/remessa/download/{id}', 'RemessaController@download')->name('remessa.download');
});

Route::namespace('Corte')->group(function () {
    Route::get('/corte', 'CorteController@index')->name('corte.index');
    Route::post('/corte', 'CorteController@store')->name('corte.store');
    Route::get('/corte/list', 'CorteController@list')->name('corte.list');
    Route::get('/corte/download/{id}', 'CorteController@download')->name('corte.download');
});

Route::namespace('Email')->group(function () {
    Route::get('/email', 'EmailController@index')->name('email.index');
    Route::post('/email', 'EmailController@store')->name('email.store');
    Route::get('/email/list', 'EmailController@list')->name('email.list');
    Route::get('/email/download/{id}', 'EmailController@download')->name('email.download');
});


Route::namespace('Segmentacao')->group(function () {
    Route::get('/segmentacao', 'SegmentacaoController@index')->name('segmentacao.index');
    Route::post('/segmentacao', 'SegmentacaoController@store')->name('segmentacao.store');
    Route::get('/segmentacao/list', 'SegmentacaoController@list')->name('segmentacao.list');
    Route::get('/segmentacao/download/{id}', 'SegmentacaoController@download')->name('segmentacao.download');
});

Route::namespace('Validador')->group(function () {
    Route::get('/validador', 'ValidadorController@index')->name('validador.index');
    Route::post('/validador', 'ValidadorController@store')->name('validador.store');
    Route::get('/validador/list', 'ValidadorController@list')->name('validador.list');
    Route::get('/validador/downloadSuccess/{id}', 'ValidadorController@downloadSuccess')->name('validador.downloadSuccess');
    Route::get('/validador/downloadError/{id}', 'ValidadorController@downloadError')->name('validador.downloadError');
    Route::get('/validador/downloadLog/{id}', 'ValidadorController@downloadLog')->name('validador.downloadLog');
});

