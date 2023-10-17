<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracoesUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ConfiguracoesUsuarioController extends Controller
{
    public function index(){
        $configuracoes = DB::table('configuracoes_usuario')->where('user_id','=',Auth::user()->getAuthIdentifier())->select('id','email')->get();
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

        $senha = $request->senha.'578g';
        $senha = Crypt::encrypt($senha);

        $configuracao = [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'email' => $request->email,
            'senha_email' => $senha
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

            if($user->id != Auth::user()->getAuthIdentifier()){
                return redirect(route('configuracoesusuario.index'))->withErrors(['errors'=>'Usuario logado divergente com o cadastrado']);
            }
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.index'))->withErrors(['errors'=>'Erro ao encontrar configurações: '.$e->getMessage()]);
        }

        return view('configuracoesusuario/update',['configuracoes'=>$configuracoes, 'user'=>$user]);
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
                $usuario->password = $novousuario->senha;
                $usuario->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova configuração: '.$e->getMessage()]);
            }
        }elseif (isset($request->senha)){
            try{
                $usuario->password = $novousuario->senha;
                $usuario->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova configuração: '.$e->getMessage()]);
            }
        }
        $novoconfiguracao = $configuracoes->replicate();
        $novoconfiguracao->email = $request->emailenvio;

        if (isset($request->senhaenvio)){
            $senha = $request->senhaenvio.'578g';
            $novoconfiguracao->senha = Crypt::encrypt($senha);
        }

        if(!ConfiguracoesUsuario::Equals($configuracoes,$novoconfiguracao)){
            try{
                $configuracoes->email = $novoconfiguracao->email;
                $configuracoes->senha_email = $novoconfiguracao->senha;
                $configuracoes->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova configuração: '.$e->getMessage()]);
            }
        }elseif (isset($request->senhaenvio)){
            try{
                $configuracoes->senha_email = $novoconfiguracao->senha;
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
