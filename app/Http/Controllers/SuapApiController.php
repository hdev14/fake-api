<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Usuario;
use App\Material;
use App\Aula;
use App\Turma;
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
                ->whereRaw('id IN (?) AND ano_letivo = '
                    .$ano." AND periodo_letivo = ". $periodo, [ $turmas_ids ])->get();

      $turmas_virtuais = array();

      foreach ($turmas as $turma) {
        array_push($turmas_virtuais, [
          'id' => $turma->id,
          'sigla' => $turma->sigla,
          'descricao' => $turma->descricao,
          'observacao' => $turma->observacao,
          'professores' => self::getProfessores($turma->id),
          'locais_de_aula' => self::getLocais($turma->id),
          'horarios_de_aula' => $turma->horarios_de_aula,
        ]);

        ;
      }

      return response()->json([
    		$turmas_virtuais,
    	], 200);

   	}

   	public function getTurmaVirtual(Request $rq, $turma_id) {
   		
      $autorizacao = $rq->header('Authorization');
      list($jwt, $token) = explode(' ', $autorizacao);

      $usuario = self::usuarioExist($token);
      
      $usuario_turma = UsuarioTurma::where(['usuario_id' => $usuario->id, 'turma_id' => $turma_id])->first();

      $turma = Turma::find($usuario_turma->turma_id);

      $turma_virtual = array([
        'id' => $turma->id,
        'sigla' => $turma->sigla,
        'descricao' => $turma->descricao,
        'observacao' => $turma->observacao,
        'professores' => self::getProfessores($turma->id),
        'locais_de_aula' => self::getLocais($turma->id),
        'horarios_de_aula' => $turma->horarios_de_aula,
        'data_inicio' => $turma->data_inicio,
        'data_fim' => $turma->data_fim,
        'participantes' => self::getParticipantes($turma->id),
        'aulas' => self::getAulas($turma->id),
        'materiais_de_aula' => self::getMateriais($turma->id),
      ]);

      return response()->json([
        $turma_virtual,
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

    protected static function getProfessores($turma_id) {

      $usuario_turma = UsuarioTurma::whereRaw('turma_id = '. $turma_id .' AND professor = 1')->get();

      $professores_ids = array();

      foreach ($usuario_turma as $ut) {
        array_push($professores_ids, $ut->usuario_id);
      }

      $professores =  Usuario::whereRaw('id IN (?)',[$professores_ids])->get();

      $professores_turma = array();

      foreach ($professores as $p) {
        array_push($professores_turma,[
          'matricula' => $p->matricula,
          'foto' => $p->url_foto,
          'email' => $p->email,
          'nome' => $p->nome_usual,
        ]);
      }

      return $professores_turma;
    }

    protected static function getParticipantes($turma_id) {

      $usuario_turma = UsuarioTurma::whereRaw('turma_id = '. $turma_id .' AND NOT professor = 1')->get();

      $participantes_ids = array();

      foreach ($usuario_turma as $ut) {
        array_push($participantes_ids, $ut->usuario_id);
      }

      $participantes =  Usuario::whereRaw('id IN (?)',[$participantes_ids])->get();

      $participantes_turma = array();

      foreach ($participantes as $p) {
        array_push($participantes_turma,[
          'matricula' => $p->matricula,
          'foto' => $p->url_foto,
          'email' => $p->email,
          'nome' => $p->nome_usual,
        ]);
      }

      return $participantes_turma;
    }

    protected static function getMateriais($turma_id) {
      
      $materiais =  Material::where(['turma_id' => $turma_id])->get();
      
      $materiais_turma = array();

      foreach ($materiais as $m) {
        array_push($materiais_turma, [
          'url' => $m->url,
          'data_vinculacao' => $m->data_vinculacao,
          'descricao' => $m->descricao,
        ]);
      }

      return $materiais_turma;

    }

    protected static function getAulas($turma_id) {
      
      $aulas =  Aula::where(['turma_id' => $turma_id])->get();
      
      $aulas_turma = array();

      foreach ($aulas as $a) {
        array_push($aulas_turma, [
          'etapa' => $a->etapa,
          'professor' => $a->professor,
          'quantidade' => $a->quantidade,
          'faltas' => $a->faltas,
          'conteudo' => $a->conteudo,
          'data' => $a->data,
        ]);
      }

      return $aulas_turma;

    }
}
