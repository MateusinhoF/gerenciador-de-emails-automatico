<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracoesUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfiguracoesUsuarioController extends Controller
{
    public function index(){
        $configuracoes = DB::table('configuracoes_usuario')->select('id','email')->get();
        return view('configuracoesusuario/index', ['configuracoes'=>$configuracoes]);
    }

    public function create(){
        return view('configuracoesusuario/create');
    }

    public function store(Request $request){
        $request->validate([
            'email'=>'required|email',
            'senha'=>'required'
        ]);

        //encriptar a senha
        $senha = $request->senha;

        $configuracao = [
            'users_id' => 'id atual',
            'email' => $request->email,
            'senha' => $senha
        ];

        try{
            ConfiguracoesUsuario::create($configuracao);
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.create'))->withErrors(['errors'=>'Erro ao cadastrar o email '.$e->getMessage()]);
        }
        return redirect(route('configuracoesusuario.index'));
    }

    public function edit(string $id){
        try{
            $configuracoes = ConfiguracoesUsuario::find($id);
            $user = User::find($configuracoes->user_id);
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.index'))->withErrors(['errors'=>'Erro ao encontrar configurações: '.$e->getMessage()]);
        }

        return view('emails/update',['configuracoes'=>$configuracoes, 'user'=>$user]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'email'=>'required|email',
            'emailenvio'=>'required|email'
        ]);

        try {
            $configuracoes = ConfiguracoesUsuario::find($id);
        }catch (Exception $e){
            return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao encontrar configuracoes: '.$e->getMessage()]);
        }
        try {
            $usuario = User::find($configuracoes->user_id);
        }catch (Exception $e){
            return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao encontrar configuracoes: '.$e->getMessage()]);
        }

        $novousuario = $usuario->replicate();
        $novousuario->email = $request->email;
        if (isset($request->senha)){
            $novousuario->senha = $request->senha;
        }

        if(!User::Equals($usuario,$novousuario)){
            try{
                $usuario->email = $novousuario->email;
                $usuario->senha = $novousuario->senha;
                $usuario->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova configuração: '.$e->getMessage()]);
            }
        }
        $novoconfiguracao = $configuracoes->replicate();
        $novoconfiguracao->email = $request->emailenvio;

        if (isset($request->senhaenvio)){
            $novoconfiguracao->senha = $request->senhaenvio;
        }

        if(!ConfiguracoesUsuario::Equals($configuracoes,$novoconfiguracao)){
            try{
                $configuracoes->email = $novoconfiguracao->email;
                $configuracoes->senha = $novoconfiguracao->senha;
                $configuracoes->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova configuração: '.$e->getMessage()]);
            }
        }

        return redirect(route('configuracoesusuario.index'));
    }

    public function destroy(string $id){
        try{
            $configuracao = ConfiguracoesUsuario::find($id);

            if($configuracao){
                $configuracao->delete();
            }else{
                return redirect(route('configuracoesusuario.index'))->withErrors(['errors'=>'Erro, configuração não encontrada']);
            }
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('configuracoesusuario.index'));
    }

}
