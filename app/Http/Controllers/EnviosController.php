<?php

namespace App\Http\Controllers;

use App\Models\Envios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnviosController extends Controller
{
    public function index(){
        $envios = DB::table('envios')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('envios/index', ['envios'=>$envios]);
    }

    public function create(){
        return view('envios/create');
    }

    public function store(Request $request){
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email'
        ]);

        $envios = [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'nome'=>$request->nome,
            'email'=>$request->email,
            'telefone'=>$request->telefone
        ];

        try{
            Envios::create($envios);
        }catch(Exception $e){
            return redirect(route('envios.create'))->withErrors(['errors'=>'Erro ao cadastrar o envio '.$e->getMessage()]);
        }
        return redirect(route('envios.index'));
    }

    public function edit(string $id){
        try{
            $envios = Envios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch(Exception $e){
            return redirect(route('envios.index'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }

        return view('envios/update',['envios'=>$envios]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email'
        ]);

        try {
            $envios = Envios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch (Exception $e){
            return redirect(route('envios.edit'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }
        $novoEnvios = $envios->replicate();

        $novoEnvios->nome = $request->nome;
        $novoEnvios->email = $request->email;
        $novoEnvios->telefone = $request->telefone;

        if(!Envios::Equals($envios,$novoEnvios)){
            try{
                $envios->nome = $novoEnvios->nome;
                $envios->email = $novoEnvios->email;
                $envios->telefone = $novoEnvios->telefone;
                $envios->save();
            }catch (Exception $e){
                return redirect(route('envios.edit'))->withErrors(['errors'=>'Erro ao salvar novo envio: '.$e->getMessage()]);
            }
        }

        return redirect(route('envios.index'));
    }

    public function destroy(string $id){
        try{
            $envio = Envios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($envio){
                $envio->delete();
            }else{
                return redirect(route('envios.index'))->withErrors(['errors'=>'Erro, envio não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('envios.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('envios.index'));
    }

}
