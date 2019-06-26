<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Usuario;

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

   	public function criarUsuario(Request $rq) {
   		
   		$dados = $rq->json()->all();
   		
   		$usuario = new Usuario($dados);
   		$usuario->senha = Hash::make($usuario->senha);
   		$usuario->save();

   		return response()->json([
    		'mensagem' => 'OK'
    	], 200);
   	}
}
