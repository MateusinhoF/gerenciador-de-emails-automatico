<?php

namespace App\Http\Controllers;

use App\Models\Anexos;
use App\Models\CorpoEmail;
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

        $mensagems = DB::table('mensagem')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('mensagem/index',['mensagems'=>$mensagems]);
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
                return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar corpo de email, vincular anexo: '.$e->getMessage()]);
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
                        return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar corpo de email, anexo: '.$e->getMessage()]);
                    }

                    $listaanexos = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'vinculador_anexos_id'=>$vinculadoranexosDB->id,
                        'anexos_id'=>$anexoDB->id
                    ];

                    try{
                        ListaAnexos::create($listaanexos);
                    }catch (Exception $e){
                        return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar corpo de email, lista de anexo: '.$e->getMessage()]);
                    }
                }else{
                    return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar corpo de email, erro no anexo: '.$anexo->getErrorMessage()]);
                }
            }
        }

        $corpo = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'titulo'=>$request->titulo,
            'assunto'=>$request->assunto,
            'texto'=>$request->texto,
            'vinculador_anexos_id'=>$vinculadoranexosDB->id ?? null
        ];

        try{
            Mensagem::create($corpo);
        }catch(Exception $e){
            return redirect(route('mensagem.create'))->withErrors(['errors'=>'Erro ao cadastrar corpo de email '.$e->getMessage()]);
        }
        return redirect(route('mensagem.index'));
    }

    public function edit(string $id){
        try{
            $mensagem = Mensagem::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            $vinculadoranexos = VinculadorAnexos::where('id','=',$mensagem->vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            $listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=', $vinculadoranexos->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();
            $anexos = [];
            foreach ($listaanexos as $identificador){
                $anexo = Anexos::where('id','=',$identificador->anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

                array_push($anexos, base_path().'/anexos/'.$anexo->hashname);
            }
        }catch(Exception $e){
            return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao encontrar corpo de email: '.$e->getMessage()]);
        }

        return view('mensagem/update',['mensagem'=>$mensagem, 'anexos'=>$anexos]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'titulo'=>'required',
            'assunto'=>'required',
            'texto'=>'required'
        ]);

        try {
            $corpo = Mensagem::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch (Exception $e){
            return redirect(route('mensagem.edit'))->withErrors(['errors'=>'Erro ao encontrar corpo de email: '.$e->getMessage()]);
        }
        $novoCorpo = $corpo->replicate();

        $novoCorpo->titulo = $request->titulo;
        $novoCorpo->assunto = $request->assunto;
        $novoCorpo->texto = $request->texto;

        if(!Mensagem::Equals($corpo,$novoCorpo)){
            try{
                $corpo->titulo = $novoCorpo->titulo;
                $corpo->assunto = $novoCorpo->assunto;
                $corpo->texto = $novoCorpo->texto;
                $corpo->save();
            }catch (Exception $e){
                return redirect(route('mensagem.edit'))->withErrors(['errors'=>'Erro ao salvar novo corpo de email: '.$e->getMessage()]);
            }
        }

        return redirect(route('mensagem.index'));
    }

    public function destroy(string $id){
        try{
            $corpo = Mensagem::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($corpo){
                $vinculadoranexos = VinculadorAnexos::where('id','=',$corpo->vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                $listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=', $vinculadoranexos->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();
                $corpo->delete();

                foreach ($listaanexos as $identificador){
                    $anexo = Anexos::where('id','=',$identificador->anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

                    File::delete(base_path().'/anexos/'.$anexo->hashname);

                    $anexo->delete();
                }

                ListaAnexos::destroy($listaanexos);
                $vinculadoranexos->delete();

            }else{
                return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro, corpo de email não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('mensagem.index'));
    }

}
