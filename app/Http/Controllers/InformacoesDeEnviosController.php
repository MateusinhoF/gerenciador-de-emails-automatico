<?php

namespace App\Http\Controllers;

use App\Models\InformacoesDeEnvios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InformacoesDeEnviosController extends Controller
{
    public function index(){
        $informacoesdeenvios = DB::table('informacoes_de_envios')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('informacoesdeenvios/index', ['informacoesdeenvios'=>$informacoesdeenvios]);
    }

    public function create(){
        return view('informacoesdeenvios/create');
    }

    public function store(Request $request){
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email',
            'telefone' => 'nullable|regex:/^\d{2}\d{9}$/'
        ]);

        $informacoesdeenvios = [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'nome'=>$request->nome,
            'email'=>$request->email,
            'telefone'=>$request->telefone
        ];

        try{
            InformacoesDeEnvios::create($informacoesdeenvios);
        }catch(Exception $e){
            return redirect(route('informacoesdeenvios.create'))->withErrors(['errors'=>'Erro ao cadastrar o envio '.$e->getMessage()]);
        }
        return redirect(route('informacoesdeenvios.index'));
    }

    public function edit(string $id){
        try{
            $informacoesdeenvios = InformacoesDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch(Exception $e){
            return redirect(route('informacoesdeenvios.index'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }

        return view('informacoesdeenvios/update',['informacoesdeenvios'=>$informacoesdeenvios]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email',
            'telefone' => 'nullable|regex:/^\d{2}\d{9}$/'
        ]);

        try {
            $informacoesdeenvios = InformacoesDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch (Exception $e){
            return redirect(route('informacoesdeenvios.edit'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }
        $novoEnvios = $informacoesdeenvios->replicate();

        $novoEnvios->nome = $request->nome;
        $novoEnvios->email = $request->email;
        $novoEnvios->telefone = $request->telefone;

        if(!InformacoesDeEnvios::Equals($informacoesdeenvios,$novoEnvios)){
            try{
                $informacoesdeenvios->nome = $novoEnvios->nome;
                $informacoesdeenvios->email = $novoEnvios->email;
                $informacoesdeenvios->telefone = $novoEnvios->telefone;
                $informacoesdeenvios->save();
            }catch (Exception $e){
                return redirect(route('informacoesdeenvios.edit'))->withErrors(['errors'=>'Erro ao salvar novo envio: '.$e->getMessage()]);
            }
        }

        return redirect(route('informacoesdeenvios.index'));
    }

    public function destroy(string $id){
        try{
            $informacoesdeenvios = InformacoesDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($informacoesdeenvios){
                $informacoesdeenvios->delete();
            }else{
                return redirect(route('informacoesdeenvios.index'))->withErrors(['errors'=>'Erro, envio não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('informacoesdeenvios.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('informacoesdeenvios.index'));
    }

}
