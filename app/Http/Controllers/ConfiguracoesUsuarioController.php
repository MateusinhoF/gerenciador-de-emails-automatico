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
    public function edit(){
        try{
            $user = Auth::user();
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.index'))->withErrors(['errors'=>'Erro ao encontrar configurações: '.$e->getMessage()]);
        }

        return view('configuracoesusuario/update',['user'=>$user]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'login'=>'required',
            'email'=>'required|email',
        ]);

        try {
            $usuario = User::find($id);
        }catch (Exception $e){
            return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao encontrar configuracoes: '.$e->getMessage()]);
        }

        $novousuario = $usuario->replicate();
        $novousuario->login = $request->login;
        $novousuario->email = $request->email;
        if (isset($request->password)){
            $novousuario->password = $request->password;
        }
        if (isset($request->senha_email)){
            $novousuario->senha_email = $request->senha_email;
        }

        if(!User::Equals($usuario,$novousuario)){
            try{
                $usuario->login = $novousuario->login;
                $usuario->email = $novousuario->email;
                $usuario->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar novo login ou email: '.$e->getMessage()]);
            }
        }elseif (isset($request->password)){
            try{
                $usuario->password = $novousuario->password;
                $usuario->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova senha de login: '.$e->getMessage()]);
            }
        }elseif (isset($request->senha_email)){
            try{
                $usuario->senha_email = $novousuario->senha_email;
                $usuario->save();
            }catch (Exception $e){
                return redirect(route('configuracoesusuario.edit'))->withErrors(['errors'=>'Erro ao salvar nova senha de email: '.$e->getMessage()]);
            }
        }

        return redirect(route('paraenviar.index'));
    }

}
