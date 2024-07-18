<?php

namespace App\Http\Controllers;

use App\Models\InformacoesDeEnvios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InformacoesDeEnviosController extends Controller
{
    public function index(){
        $informacoes_de_envios = DB::table('informacoes_de_envios')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('informacoes_de_envios/index', ['informacoes_de_envios'=>$informacoes_de_envios]);
    }

    public function create(){
        return view('informacoes_de_envios/create');
    }

    public function store(Request $request){
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email',
            'telefone' => 'nullable|regex:/^\d{2}\d{9}$/'
        ]);

        $informacoes_de_envios = [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'nome'=>$request->nome,
            'email'=>$request->email,
            'telefone'=>$request->telefone
        ];

        try{
            InformacoesDeEnvios::create($informacoes_de_envios);
        }catch(Exception $e){
            return redirect(route('informacoes_de_envios.create'))->withErrors(['errors'=>'Erro ao cadastrar o envio '.$e->getMessage()]);
        }
        return redirect(route('informacoes_de_envios.index'));
    }

    public function edit(string $id){
        try{
            $informacoes_de_envio = InformacoesDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch(Exception $e){
            return redirect(route('informacoes_de_envios.index'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }

        return view('informacoes_de_envios/update',['informacoes_de_envios'=>$informacoes_de_envio]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email',
            'telefone' => 'nullable|regex:/^\d{2}\d{9}$/'
        ]);

        try {
            $informacoes_de_envios = InformacoesDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch (Exception $e){
            return redirect(route('informacoes_de_envios.edit'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }
        $novoEnvios = $informacoes_de_envios->replicate();

        $novoEnvios->nome = $request->nome;
        $novoEnvios->email = $request->email;
        $novoEnvios->telefone = $request->telefone;

        if(!Envios::Equals($informacoes_de_envios,$novoEnvios)){
            try{
                $informacoes_de_envios->nome = $novoEnvios->nome;
                $informacoes_de_envios->email = $novoEnvios->email;
                $informacoes_de_envios->telefone = $novoEnvios->telefone;
                $informacoes_de_envios->save();
            }catch (Exception $e){
                return redirect(route('informacoes_de_envios.edit'))->withErrors(['errors'=>'Erro ao salvar novo envio: '.$e->getMessage()]);
            }
        }

        return redirect(route('informacoes_de_envios.index'));
    }

    public function destroy(string $id){
        try{
            $informacoes_de_envios = InformacoesDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($informacoes_de_envios){
                $informacoes_de_envios->delete();
            }else{
                return redirect(route('informacoes_de_envios.index'))->withErrors(['errors'=>'Erro, envio não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('informacoes_de_envios.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('informacoes_de_envios.index'));
    }

}
