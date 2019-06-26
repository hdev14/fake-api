<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('autenticacao/acesso_responsaveis/', 'SuapApiController@acesso');

Route::post('autenticacao/token/', 'SuapApiController@token');

Route::post('autenticacao/token/verify/', 'SuapApiController@verificarToken');

Route::get('minhas-informacoes/meus-dados/', 'SuapApiController@dados');

Route::get('minhas-informacoes/meus-periodos-letivos/', 'SuapApiController@periodos');

Route::get('minhas-informacoes/boletim/{ano}/{periodo}/', 'SuapApiController@boletin');

Route::get('minhas-informacoes/turmas-virtuais/{ano}/{periodo}/', 'SuapApiController@getTurmasVirtuais');

Route::get('minhas-informacoes/turmas-virtuais/{id}/', 'SuapApiController@getTurmaVirtual');
