<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;

class UsuarioController extends Controller
{
    
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
