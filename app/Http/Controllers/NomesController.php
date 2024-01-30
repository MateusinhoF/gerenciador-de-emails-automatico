<?php

namespace App\Http\Controllers;

use App\Models\Nomes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class NomesController extends Controller
{

    public function index(){

        $nomes = DB::table('nomes')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('nomes/index',['nomes'=>$nomes]);
    }

    public function create(){
        return view('nomes/create');
    }

    public function store(Request $request){

        $request->validate([
            'nome1'=>'required'
        ]);

        $nomes = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'nome1'=>$request->nome1,
            'nome2'=>$request->nome2,
            'nome3'=>$request->nome3,
            'nome4'=>$request->nome4,
            'nome5'=>$request->nome5,
        ];

        try{
            Nomes::create($nomes);
        }catch(Exception $e){
            return redirect(route('nomes.create'))->withErrors(['errors'=>'Erro ao cadastrar nomes '.$e->getMessage()]);
        }
        return redirect(route('nomes.index'));
    }

    public function edit(string $id){
        try{
            $nomes = Nomes::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch(Exception $e){
            return redirect(route('nomes.index'))->withErrors(['errors'=>'Erro ao encontrar nomes: '.$e->getMessage()]);
        }

        return view('nomes/update',['nomes'=>$nomes]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nome1'=>'required'
        ]);

        try {
            $nomes = Nomes::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch (Exception $e){
            return redirect(route('nomes.edit'))->withErrors(['errors'=>'Erro ao encontrar nomes: '.$e->getMessage()]);
        }
        $novosNomes = $nomes->replicate();

        $novosNomes->nome1 = $request->nome1;
        $novosNomes->nome2 = $request->nome2;
        $novosNomes->nome3 = $request->nome3;
        $novosNomes->nome4 = $request->nome4;
        $novosNomes->nome5 = $request->nome5;

        if(!Nomes::Equals($nomes,$novosNomes)){
            try{
                $nomes->nome1 = $novosNomes->nome1;
                $nomes->nome2 = $novosNomes->nome2;
                $nomes->nome3 = $novosNomes->nome3;
                $nomes->nome4 = $novosNomes->nome4;
                $nomes->nome5 = $novosNomes->nome5;
                $nomes->save();
            }catch (Exception $e){
                return redirect(route('nomes.edit'))->withErrors(['errors'=>'Erro ao salvar novos nomes: '.$e->getMessage()]);
            }
        }

        return redirect(route('nomes.index'));
    }

    public function destroy(string $id){
        try{
            $nomes = Nomes::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($nomes){
                $nomes->delete();
            }else{
                return redirect(route('nomes.index'))->withErrors(['errors'=>'Erro, nome não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('nomes.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('nomes.index'));
    }

}
