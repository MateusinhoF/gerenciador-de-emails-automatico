<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracoesUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ConfiguracoesUsuarioController extends Controller
{
    public function edit(string $id){
        try{
            $user = Auth::user();
            if($user->id != $id){
                return redirect(route('configuracoesusuario.index', ['id'=>$user->id]))->withErrors(['errors'=>'Usuário divergente']);
            }
        }catch(Exception $e){
            return redirect(route('paraenviar.index'))->withErrors(['errors'=>'Erro ao encontrar configurações: '.$e->getMessage()]);
        }
        $user->password = '';
        $user->senha_email = '';

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
            return redirect(route('paraenviar.edit'))->withErrors(['errors'=>'Erro ao encontrar configuracoes: '.$e->getMessage()]);
        }

        $novousuario = $usuario->replicate();
        $novousuario->login = $request->login;
        $novousuario->email = $request->email;
        $novousuario->assinatura = $request->assinatura;
        if (isset($request->password)){
            $novousuario->password = $request->password;
        }
        if (isset($request->senha_email)){
            $novousuario->senha_email = $request->senha_email;
        }

        if(!User::Equals($usuario,$novousuario)){
            $usuario->login = $novousuario->login;
            $usuario->email = $novousuario->email;
        }
        if (isset($request->password)){
            $usuario->password = $novousuario->password;
        }
        if (isset($request->senha_email)){
            $usuario->senha_email = $novousuario->senha_email;
        }

        if (isset($request->assinatura)){
            $usuario->assinatura = $novousuario->assinatura;
        }

        if ($request->hasFile('imagem_assinatura')){
            $hashname = Str::random(40).'.'.$request->imagem_assinatura->extension();
            $request->imagem_assinatura->move(base_path().'/assinaturas', $hashname);

            $usuario->imagem_assinatura = $hashname;
        }


        try{
            $usuario->save();
        }catch (Exception $e){
            return redirect(route('configuracoesusuario.edit', ['id'=>$usuario->id]))->withErrors(['errors'=>'Erro ao salvar nova configuração: '.$e->getMessage()]);
        }

        return redirect(route('paraenviar.index'));
    }

    public function destroyimg(string $id){
        try{
            $user = Auth::user();
            if($user->id != $id){
                return redirect(route('configuracoesusuario.index', ['id'=>$user->id]))->withErrors(['errors'=>'Usuário divergente']);
            }
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.index', ['id'=>$user->id]))->withErrors(['errors'=>'Erro ao encontrar configurações: '.$e->getMessage()]);
        }
        File::delete(base_path().'/anexos/'.$user->imagem_assinatura);
        $user->imagem_assinatura = '';
        $user->save();

        return redirect(route('configuracoesusuario.edit', ['id'=>$user->id]));

    }

    public function downloadAssinatura(string $id){
        try{
            $user = Auth::user();
            if($user->id != $id){
                return redirect(route('configuracoesusuario.index', ['id'=>$user->id]))->withErrors(['errors'=>'Usuário divergente']);
            }
        }catch(Exception $e){
            return redirect(route('configuracoesusuario.index', ['id'=>$user->id]))->withErrors(['errors'=>'Erro ao encontrar configurações: '.$e->getMessage()]);
        }

        $assinatura = base_path().'/assinaturas/'.$user->imagem_assinatura;

        if (file_exists($assinatura)) {
            return response()->download($assinatura);
        } else {
            return redirect(route('configuracoesusuario.edit', ['id'=>$user->id]))->withErrors(['errors'=>'Erro ao encontrar imagem']);
        }


    }

}
