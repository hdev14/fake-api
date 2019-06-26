<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Usuario;
use App\UsuarioPeriodo;

class SuapApiController extends Controller
{	

    public function acesso(Request $rq) {
    	
    	// {
    	// 	'matricula': matricula, 
    	// 	'chave': senha
    	// }

    	return response()->json([
    		'token' => 'OK'
    	], 200);
    }

    public function token(Request $rq) {
    	
    	// {
    	// 	'username': matricula, 
    	// 	'password': senha
    	// }

    	$dados = $rq->json()->all();

    	if (!Auth::attempt(['matricula' => $dados['username'], 
    			'password' => $dados['password']])) {

    		return response()->json([
	    		'mensagem' => 'erro'
	    	], 400);
    	}

        $token = Str::random(60);
        
        Auth::user()->forceFill([
            'token' => $token,
        ])->save();

        // Adicionar o token na sessão.

    	return response()->json([
    		'token' => $token
    	], 200);
    }

    public function verificarToken(Request $rq) {
    	
    	// {
    	// 	'token': token
    	// }

    	$dados = $rq->json()->all();

    	// Verificar se o token na sessão e se igual a do usuário.

    	$usuario = Usuario::where('token', $dados['token'])->first();

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

      $autorizacao = $rq->header('Authorization');
      list($jwt, $token) = explode(' ', $autorizacao);

      $usuario =  Usuario::where(['token' => $token])->first();

      if(!$usuario) {
        return response()->json([
          'mensagem' => 'error'
        ], 401);
      }

      $usuario_periodo = UsuarioPeriodo::where(['usuario_id' => $usuario->id])->get();
      
      $periodos = array();

      foreach ($usuario_periodo as $up) {
        array_push($periodos, [
          'ano_letivo' => $up->periodo->ano_letivo, 
          'periodo_letivo' => $up->periodo->periodo_letivo
        ]);
      }
      
    	return response()->json([
    		$periodos,
    	], 200);
    }

    public static function getPeriodo($up) {
      return $up->periodo;
    }

    // DEPOIS
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
