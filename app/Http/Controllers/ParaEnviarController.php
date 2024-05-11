<?php

namespace App\Http\Controllers;

use App\Models\CorpoEmail;
use App\Models\Nomes;
use App\Models\ParaEnviar;
use App\Models\TituloListaDeEnvios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ParaEnviarController extends Controller
{
    public function index(){
        $paraenviar = DB::table('para_enviar')
            ->where('para_enviar.user_id','=',Auth::user()->getAuthIdentifier())
            ->leftJoin('nomes','nomes.id','=','para_enviar.nomes_id')
            ->leftJoin('corpo_email','corpo_email.id','=','para_enviar.corpo_email_id')
            ->leftJoin('titulo_lista_de_emails AS titulo_envio','titulo_envio.id','=','para_enviar.titulo_lista_de_emails_id')
            ->leftJoin('titulo_lista_de_emails AS titulo_cc','titulo_cc.id','=','para_enviar.titulo_lista_de_emails_cc_id')
            ->leftJoin('titulo_lista_de_emails AS titulo_cco','titulo_cco.id','=','para_enviar.titulo_lista_de_emails_cco_id')
            ->select('para_enviar.*','nomes.nome1','nomes.nome2','nomes.nome3','nomes.nome4','nomes.nome5',
                'corpo_email.titulo as corpo_email_titulo',
                'titulo_envio.titulo AS titulo_envio', 'titulo_cc.titulo AS titulo_cc', 'titulo_cco.titulo AS titulo_cco')
            ->orderBy('continuar_envio', 'desc')
            ->orderBy('para_enviar.id','desc')->get();

        return view('paraenviar/index', ['paraenviar'=>$paraenviar]);
    }

    public function create(){
        $listatitulos = DB::table('titulo_lista_de_emails')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        $nomes = DB::table('nomes')->orderBy('nome1')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('nome2')->orderBy('nome3')->orderBy('nome4')->orderBy('nome5')->get();
        $corpoemails = DB::table('corpo_email')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();

        return view('paraenviar/create', ['listatitulos'=>$listatitulos,'nomes'=>$nomes,'corpoemails'=>$corpoemails]);
    }

    public function store(Request $request){
        $request->validate([
            'titulo'=>'required',
            'corpoemail'=>'required',
            'listatitulos'=>'required'
        ]);

        $paraenviar = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'titulo'=>$request->titulo,
            'corpo_email_id'=>$request->corpoemail,
            'titulo_lista_de_emails_id'=>$request->listatitulos,
            'titulo_lista_de_emails_cc_id'=>$request->listatituloscc,
            'titulo_lista_de_emails_cco_id'=>$request->listatituloscco,
            'nomes_id'=>$request->nomes,
            'data_inicio'=>$request->data_inicio,
            'data_fim'=>$request->data_fim
        ];

        try{
            CorpoEmail::where('id','=',$paraenviar['corpo_email_id'])->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            TituloListaDeEnvios::where('id','=',$paraenviar['titulo_lista_de_emails_id'])->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if (isset($paraenviar['titulo_lista_de_emails_cc_id'])){
                TituloListaDeEnvios::where('id','=',$paraenviar['titulo_lista_de_emails_cc_id'])->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            }
            if (isset($paraenviar['titulo_lista_de_emails_cco_id'])){
                TituloListaDeEnvios::where('id','=',$paraenviar['titulo_lista_de_emails_cco_id'])->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            }
            if (isset($paraenviar['nomes_id'])){
                Nomes::where('id','=',$paraenviar['nomes_id'])->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            }
        }catch(Exception $e){
            return redirect(route('paraenviar.create'))->withErrors(['errors'=>'Erro ao pesquisar dados de envio '.$e->getMessage()]);
        }
        try{
            ParaEnviar::create($paraenviar);
        }catch(Exception $e){
            return redirect(route('paraenviar.create'))->withErrors(['errors'=>'Erro ao cadastrar envio '.$e->getMessage()]);
        }
        return redirect(route('paraenviar.index'));
    }

    public function edit(string $id){
        try{
            $paraenviar = ParaEnviar::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch(Exception $e){
            return redirect(route('paraenbiar.index'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }

        $corpoemails = DB::table('corpo_email')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        $listatitulos = DB::table('titulo_lista_de_emails')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        $nomes = DB::table('nomes')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('paraenviar/update',['paraenviar'=>$paraenviar, 'corpoemails'=>$corpoemails, 'listatitulos'=>$listatitulos, 'nomes'=>$nomes]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'titulo'=>'required',
            'corpoemail'=>'required',
            'listatitulos'=>'required'
        ]);

        try {
            $paraenviar = ParaEnviar::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch (Exception $e){
            return redirect(route('paraenviar.edit'))->withErrors(['errors'=>'Erro ao encontrar envio: '.$e->getMessage()]);
        }
        $novoParaEnviar = $paraenviar->replicate();

        $novoParaEnviar->titulo = $request->titulo;
        $novoParaEnviar->corpo_email_id = $request->corpoemail;
        $novoParaEnviar->nomes_id = $request->nomes;
        $novoParaEnviar->titulo_lista_de_emails_id = $request->listatitulos;
        $novoParaEnviar->titulo_lista_de_emails_cc_id = $request->listatituloscc;
        $novoParaEnviar->titulo_lista_de_emails_cco_id = $request->listatituloscco;
        $novoParaEnviar->data_inicio = $request->data_inicio;
        $novoParaEnviar->data_fim = $request->data_fim;

        if(!ParaEnviar::Equals($paraenviar,$novoParaEnviar)){
            try{
                $paraenviar->titulo = $novoParaEnviar->titulo;
                $paraenviar->corpo_email_id = $novoParaEnviar->corpo_email_id;
                $paraenviar->nomes_id = $novoParaEnviar->nomes_id;
                $paraenviar->titulo_lista_de_emails_id = $novoParaEnviar->titulo_lista_de_emails_id;
                $paraenviar->titulo_lista_de_emails_cc_id = $novoParaEnviar->titulo_lista_de_emails_cc_id;
                $paraenviar->titulo_lista_de_emails_cco_id = $novoParaEnviar->titulo_lista_de_emails_cco_id;
                $paraenviar->data_inicio = $novoParaEnviar->data_inicio;
                $paraenviar->data_fim = $novoParaEnviar->data_fim;
                $paraenviar->save();
            }catch (Exception $e){
                return redirect(route('paraenviar.edit'))->withErrors(['errors'=>'Erro ao salvar novo envio: '.$e->getMessage()]);
            }
        }

        return redirect(route('paraenviar.index'));
    }

    public function destroy(string $id){
        try{
            $paraenviar = ParaEnviar::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($paraenviar){
                $paraenviar->delete();
            }else{
                return redirect(route('paraenviar.index'))->withErrors(['errors'=>'Erro, envio não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('paraenviar.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('paraenviar.index'));
    }

    public function alterarEnvio(string $id)
    {
        try {
            $paraenvia = ParaEnviar::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            $paraenvia->continuar_envio = !$paraenvia->continuar_envio;
            $paraenvia->save();
        } catch (Exception $e){
            return redirect(route('paraenviar.index'))->withErrors(['errors' => 'Erro na alteração do status: ' . $e->getMessage()]);
        }

        return redirect(route('paraenviar.index'));
    }
}
