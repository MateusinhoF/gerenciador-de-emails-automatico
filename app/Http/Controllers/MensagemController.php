<?php

namespace App\Http\Controllers;

use App\Models\Anexos;
use App\Models\Mensagem;
use App\Models\ListaAnexos;
use App\Models\VinculadorAnexos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mockery\Exception;

class MensagemController extends Controller
{

    public function index(){

        $mensagens = DB::table('mensagem')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('mensagem/index',['mensagens'=>$mensagens]);
    }

    public function create(){
        return view('mensagem/create');
    }

    public function store(Request $request){
        $request->validate([
            'titulo'=>'required',
            'assunto'=>'required',
            'texto'=>'required'
        ]);

        if ($request->hasFile('anexos')){

            $vinculadoranexos = [
                'user_id'=>Auth::user()->getAuthIdentifier()
            ];

            try{
                $vinculadoranexosDB = VinculadorAnexos::create($vinculadoranexos);
            }catch (Exception $e){
                return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar mensagem, vincular anexo: '.$e->getMessage()]);
            }

            foreach ($request->file('anexos') as $anexo){

                if ($anexo->isValid()){
                    $hashname = Str::random(40).'.'.$anexo->extension();
                    $anexo->move(base_path().'/anexos', $hashname);

                    $anexoDB = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'nome'=>$anexo->getClientOriginalName(),
                        'hashname'=>$hashname
                    ];
                    try{
                        $anexoDB = Anexos::create($anexoDB);
                    }catch (Exception $e){
                        return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar mensagem, anexo: '.$e->getMessage()]);
                    }

                    $listaanexos = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'vinculador_anexos_id'=>$vinculadoranexosDB->id,
                        'anexos_id'=>$anexoDB->id
                    ];

                    try{
                        ListaAnexos::create($listaanexos);
                    }catch (Exception $e){
                        return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar mensagem, lista de anexo: '.$e->getMessage()]);
                    }
                }else{
                    return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar mensagem, erro no anexo: '.$anexo->getErrorMessage()]);
                }
            }
        }

        $mensagem = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'titulo'=>$request->titulo,
            'assunto'=>$request->assunto,
            'texto'=>$request->texto,
            'vinculador_anexos_id'=>$vinculadoranexosDB->id ?? null
        ];

        try{
            Mensagem::create($mensagem);
        }catch(Exception $e){
            return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar mensagem '.$e->getMessage()]);
        }
        return redirect(route('mensagem.index'));
    }

    public function edit(string $id){
        try{
            $mensagem = Mensagem::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            $vinculadoranexos = VinculadorAnexos::where('id','=',$mensagem->vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            /*$listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=', $vinculadoranexos->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();
            $anexos = [];
            foreach ($listaanexos as $identificador){
                $anexo = Anexos::where('id','=',$identificador->anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

                array_push($anexos, base_path().'/anexos/'.$anexo->hashname);
            }*/
        }catch(Exception $e){
            return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao encontrar mensagem: '.$e->getMessage()]);
        }

    return view('mensagem/update',['mensagem'=>$mensagem/*, /*'anexos'=>$anexos*/]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'titulo'=>'required',
            'assunto'=>'required',
            'texto'=>'required'
        ]);

        try {
            $mensagem = Mensagem::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch (Exception $e){
            return redirect(route('mensagem.edit'))->withErrors(['errors'=>'Erro ao encontrar mensagem: '.$e->getMessage()]);
        }
        $novaMensagem = $mensagem->replicate();

        $novaMensagem->titulo = $request->titulo;
        $novaMensagem->assunto = $request->assunto;
        $novaMensagem->texto = $request->texto;

        if(!Mensagem::Equals($mensagem,$novaMensagem)){
            try{
                $mensagem->titulo = $novaMensagem->titulo;
                $mensagem->assunto = $novaMensagem->assunto;
                $mensagem->texto = $novaMensagem->texto;
                $mensagem->save();
            }catch (Exception $e){
                return redirect(route('mensagem.edit'))->withErrors(['errors'=>'Erro ao salvar nova mensagem: '.$e->getMessage()]);
            }
        }

        return redirect(route('mensagem.index'));
    }

    public function destroy(string $id){
        try{
            $mensagem = Mensagem::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($mensagem){
                $vinculadoranexos = VinculadorAnexos::where('id','=',$mensagem->vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                if ($vinculadoranexos->id != null){
                    $listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=', $vinculadoranexos->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();
                    
                    foreach ($listaanexos as $identificador){
                        $anexo = Anexos::where('id','=',$identificador->anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
    
                        File::delete(base_path().'/anexos/'.$anexo->hashname);
    
                        $anexo->delete();
                    }
    
                    ListaAnexos::destroy($listaanexos);
                    $vinculadoranexos->delete();

                }
                $mensagem->delete();

            }else{
                return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro, mensagem não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('mensagem.index'));
    }

}
