<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Usuario;
use App\UsuarioPeriodo;
use App\UsuarioTurma;
use App\TurmaLocal;

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

    public static function usuarioExist($token) {
      
      $usuario =  Usuario::where(['token' => $token])->first();

      if(!$usuario) {
        return response()->json([
          'mensagem' => 'error'
        ], 401);
      }

      return $usuario;
    }
    
    public function dados(Request $rq) {

      $autorizacao = $rq->header('Authorization');
      list($jwt, $token) = explode(' ', $autorizacao);

      $usuario = self::usuarioExist($token);

      $vinculo = $usuario->vinculo;

      if (is_null($vinculo)) {
        return response()->json([
          'messagem' => 'error'
        ], 400);
      }

    	return response()->json([
    		'id' => $usuario->id,
        'matricula' => $usuario->matricula,
        'nome_usual' => $usuario->nome_usual,
        'email' => $usuario->email,
        'url_foto' => $usuario->url_foto,
        'tipo_vinculo' => $usuario->tipo_vinculo,
        'vinculo' => [
          'matricula' => $vinculo->matricula,
          'nome' => $vinculo->nome,
          'curso' => $vinculo->curso,
          'campus' => $vinculo->campus,
          'situacao' => $vinculo->situacao,
          'cota_sistec' => $vinculo->cota_sistec,
          'cota_mec' => $vinculo->cota_mec,
          'situacao_sistemica' => $vinculo->situacao_sistemica,
        ],
    	], 200);
    }

    public function periodos(Request $rq) {

      $autorizacao = $rq->header('Authorization');
      list($jwt, $token) = explode(' ', $autorizacao);

      $usuario = self::usuarioExist($token);

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

    // DEPOIS
   	public function boletin(Request $rq, $ano, $periodo) {
   		return response()->json([
    		'boletin' => 'OK'
    	], 200);
   	}

   	public function getTurmasVirtuais(Request $rq, $ano, $periodo) {
   		
      $autorizacao = $rq->header('Authorization');
      list($jwt, $token) = explode(' ', $autorizacao);

      $usuario = self::usuarioExist($token);
      
      $usuario_turma = UsuarioTurma::where(['usuario_id' => $usuario->id])->get();

      $turmas_ids = array();

      foreach ($usuario_turma as $ut) {
        array_push($turmas_ids, $ut->turma_id);
      }

      $turmas = DB::table('turma')
                ->where(['ano_letivo', '=', $ano], ['periodo_letivo', '=', $periodo])
                ->whereIn('id', $turmas_ids)
                ->get();
                

      $turmas_virtuais = array();

      foreach ($turmas as $turma) {
        array_push($turmas_virtuais, [
          'id' => $turma->id,
          'sigla' => $turma->sigla,
          'descricao' => $turma->descricao,
          'observacao' => $turma->observacao,
          'locais_de_aula' => self::getLocais($turma->id),
          'horarios_de_aula' => $turma->horarios_de_aula
        ]);
      }

      return response()->json([
    		$turmas_virtuais,
    	], 200);
   	}

    protected static function getLocais($turma_id) {

      $turma_local = TurmaLocal::where([ 'turma_id' => $turma_id ])->get();

      $locais = array();

      foreach ($turma_local as $tl) {
        array_push($locais, $tl->local->local);
      }

      return $locais;
    }

   	public function getTurmaVirtual(Request $rq, $id) {
   		return response()->json([
    		'Turma Virtual' => 'OK'
    	], 200);
   	}
}
