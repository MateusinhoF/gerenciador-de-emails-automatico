<?php

namespace App\Http\Controllers;

use App\Models\CorpoEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CorpoEmailController extends Controller
{

    public function index(){

        $corpoemails = DB::table('corpo_email')->orderBy('id','desc')->get();
        return view('corpoemail/index',['corpoemails'=>$corpoemails]);
    }

    public function create(){
        return view('corpoemail/create');
    }

    public function store(Request $request){

        $request->validate([
            'titulo'=>'required',
            'assunto'=>'required',
            'texto'=>'required'
        ]);

        $corpo = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'titulo'=>$request->titulo,
            'assunto'=>$request->assunto,
            'texto'=>$request->texto
        ];

        try{
            CorpoEmail::create($corpo);
        }catch(Exception $e){
            return redirect(route('corpoemail.create'))->withErrors(['errors'=>'Erro ao cadastrar corpo de email '.$e->getMessage()]);
        }
        return redirect(route('corpoemail.index'));
    }

    public function edit(string $id){
        try{
            $corpoemail = CorpoEmail::find($id);
        }catch(Exception $e){
            return redirect(route('corpoemail.index'))->withErrors(['errors'=>'Erro ao encontrar corpo de email: '.$e->getMessage()]);
        }

        return view('corpoemail/update',['corpoemail'=>$corpoemail]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'titulo'=>'required',
            'assunto'=>'required',
            'texto'=>'required'
        ]);

        try {
            $corpo = CorpoEmail::find($id);
        }catch (Exception $e){
            return redirect(route('corpoemail.edit'))->withErrors(['errors'=>'Erro ao encontrar corpo de email: '.$e->getMessage()]);
        }
        $novoCorpo = $corpo->replicate();

        $novoCorpo->titulo = $request->titulo;
        $novoCorpo->assunto = $request->assunto;
        $novoCorpo->texto = $request->texto;

        if(!CorpoEmail::Equals($corpo,$novoCorpo)){
            try{
                $corpo->titulo = $novoCorpo->titulo;
                $corpo->assunto = $novoCorpo->assunto;
                $corpo->texto = $novoCorpo->texto;
                $corpo->save();
            }catch (Exception $e){
                return redirect(route('corpoemail.edit'))->withErrors(['errors'=>'Erro ao salvar novo corpo de email: '.$e->getMessage()]);
            }
        }

        return redirect(route('corpoemail.index'));
    }

    public function destroy(string $id){
        try{
            $corpo = CorpoEmail::find($id);

            if($corpo){
                $corpo->delete();
            }else{
                return redirect(route('corpoemail.index'))->withErrors(['errors'=>'Erro, corpo de email não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('corpoemail.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('corpoemail.index'));
    }

}
