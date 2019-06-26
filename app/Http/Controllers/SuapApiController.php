<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuapApiController extends Controller
{
    public function acesso(Request $rq) {
    	return response()->json([
    		'acesso' => 'OK'
    	], 200);
    }

    public function token(Request $rq) {
    	
    	$dados = $rq->json()->all();

    	return response()->json([
    		'token' => 'OK'
    	], 200);
    }

    public function verificarToken(Request $rq) {
    	return response()->json([
    		'verifica' => 'OK'
    	], 200);
    }

    public function dados(Request $rq) {
    	return response()->json([
    		'dados' => 'OK'
    	], 200);
    }

    public function periodos(Request $rq) {
    	return response()->json([
    		'periodos' => 'OK'
    	], 200);
    }

   	public function boletin(Request $rq, $ano, $periodo) {
   		return response()->json([
    		'boletin' => 'OK'
    	], 200);
   	}

   	public function getTurmasVirtuais(Request $rq, $ano, $periodo) {
   		return response()->json([
    		'Turmas Virtuais' => 'OK'
    	], 200);
   	}

   	public function getTurmaVirtual(Request $rq, $id) {
   		return response()->json([
    		'Turma Virtual' => 'OK'
    	], 200);
   	}
}
