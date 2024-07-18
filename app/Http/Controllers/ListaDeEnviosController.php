<?php

namespace App\Http\Controllers;

use App\Models\InformacoesDeEnvios;
use App\Models\ListaDeEnvios;
use App\Models\TituloListaDeEnvios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class ListaDeEnviosController extends Controller
{
    public function index(){

        $listatitulosenvios = DB::table('lista_de_envios')
            ->where('lista_de_envios.user_id','=',Auth::user()->getAuthIdentifier())
            ->join('titulo_lista_de_envios','titulo_lista_de_envios.id','=','lista_de_envios.titulo_lista_de_envios_id')
            ->join('informacoes_de_envios','informacoes_de_envios.id','=','lista_de_envios.envios_id')
            ->select('lista_de_envios.*','titulo_lista_de_envios.titulo','informacoes_de_envios.email')
            ->orderBy('lista_de_envios.titulo_lista_de_envios_id','desc')->get();

        return view('listadeenvios/index', ['listatitulosenvios'=>$listatitulosenvios]);
    }

    public function create(){
        $informacoes_de_envios = DB::table('informacoes_de_envios')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('listadeenvios/create',['informacoes_de_envios'=>$informacoes_de_envios]);
    }

    public function store(Request $request){

        $request->validate([
            'titulo'=>'required',
            'informacoes_de_envios'=>'required'
        ]);

        try {
            $titulo = TituloListaDeEnvios::create(['user_id'=>Auth::user()->getAuthIdentifier(),'titulo' => $request->titulo]);
        }catch(Exception $e){
            return redirect(route('listadeenvios.create'))->withErrors(['errors'=>'Erro ao criar título '.$e->getMessage()]);
        }
        try{
            foreach ($request->informacoes_de_envios as $informacoes_de_envio){
                $informacoes_de_envio = Envios::find($informacoes_de_envio)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                $lista = [
                    'user_id'=>Auth::user()->getAuthIdentifier(),
                    'titulo_lista_de_envios_id'=>$titulo->id,
                    'informacoes_de_envios_id'=>$informacoes_de_envio->id
                ];
                ListaDeEnvios::create($lista);
            }
            $titulo->save();
        }catch(Exception $e){
            return redirect(route('listadeenvios.create'))->withErrors(['errors'=>'Erro ao cadastrar lista '.$e->getMessage()]);
        }
        return redirect(route('listadeenvios.index'));
    }

    public function edit(string $id){
        try{
            $listatitulosenvios = DB::table('lista_de_envios')
                ->where('titulo_lista_de_envios_id','=',$id)
                ->where('lista_de_envios.user_id','=',Auth::user()->getAuthIdentifier())
                ->join('titulo_lista_de_envios','titulo_lista_de_envios.id','=','lista_de_envios.titulo_lista_de_envios_id')
                ->select('lista_de_envios.*','titulo_lista_de_envios.titulo')
                ->orderBy('lista_de_envios.id','desc')->get();

            $informacoes_de_envio = DB::table('informacoes_de_envios')->orderBy('id','desc')->get();

        }catch(Exception $e){
            return redirect(route('listadeenvios.index'))->withErrors(['errors'=>'Erro ao encontrar as partes da lista: '.$e->getMessage()]);
        }

        return view('listadeenvios/update',['listatitulosenvios'=>$listatitulosenvios, 'informacoes_de_envios'=>$informacoes_de_envio]);
    }

    public function update(Request $request, string $id){

        $request->validate([
            'titulo'=>'required',
            'email'=>'required'
        ]);

        try{
            $listatitulosenvios = DB::table('lista_de_envios')
                ->where('user_id','=',Auth::user()->getAuthIdentifier())
                ->where('titulo_lista_de_envios_id','=',$id)
                ->get();
        }catch (Exception $e){
            return redirect(route('listadeenvios.edit'))->withErrors(['errors'=>'Erro ao encontrar lista: '.$e->getMessage()]);
        }

        $titulo = TituloListaDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        $novoTitulo = $titulo->replicate();

        $novoTitulo->titulo = $request->titulo;

        if(!TituloListaDeEnvios::Equals($titulo,$novoTitulo)){
            try{
                $titulo->titulo = $novoTitulo->titulo;
                $titulo->save();
            }catch (Exception $e){
                return redirect(route('titulolistadeenvios.edit'))->withErrors(['errors'=>'Erro ao salvar novo titulo: '.$e->getMessage()]);
            }
        }

        $informacoes_de_envio = $request->envio;

        foreach ($listatitulosenvios as $listatitulosenvio) {
            $continua = false;
            foreach ($informacoes_de_envios as $informacoes_de_envio){
                if($listatitulosenvio->informacoes_de_envios_id == $informacoes_de_envio){
                    $continua = true;
                    break;
                }
            }
            if (!$continua){
                ListaDeEnvios::destroy($listatitulosenvio->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
            }
        }

        foreach ($informacoes_de_envios as $informacoes_de_envio){
            $novo = true;
            foreach ($listatitulosenvios as $listatitulosenvio) {
                if($informacoes_de_envio == $listatitulosenvio->informacoes_de_envios_id){
                    $novo = false;
                    break;
                }
            }
            if($novo){
                $novaLista = [
                    'user_id'=>Auth::user()->getAuthIdentifier(),
                    'titulo_lista_de_envios_id'=>$id,
                    'informacoes_de_envios_id'=>$informacoes_de_envio
                ];
                ListaDeEnvios::create($novaLista);
            }
        }

        return redirect(route('listadeenvios.index'));
    }

    public function destroy(string $id){
        try{
            $lista = DB::table('lista_de_envios')->where('titulo_lista_de_envios_id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();
            if($lista->count() > 0){
                foreach ($lista as $index) {
                    ListaDeEnvios::destroy($index->id);
                }
            }else{
                return redirect(route('listadeenvios.index'))->withErrors(['errors'=>'Erro, lista não encontrado']);
            }
            $titulo = TituloListaDeEnvios::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            TituloListaDeEnvios::destroy($titulo->id);
        }catch(Exception $e){
            return redirect(route('listadeenvios.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('listadeenvios.index'));
    }

    public function receiveListEmails(){
        return view('listadeenvios/receivelistemails');
    }

    public function storeListEmails(Request $request){
        $request->validate([
            'titulo'=>'required',
            'lista'=>'required'
        ]);

        $tituloListaEnvios = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'titulo'=>$request->titulo
        ];
        try {
            $tituloListaEnvios= TituloListaDeEnvios::create($tituloListaEnvios);
        }catch(Exception $e){
            return redirect(route('listadeenvios.index'))->withErrors(['errors'=>'Erro ao cadastrar titulo: '.$e->getMessage()]);
        }

        $listaparatratar = preg_split("/[\s,]+|\n/",$request->lista);

        foreach ($listaparatratar as $possivelemail){
            if (strpos($possivelemail, "@") > 0){
                $email = preg_replace('/[^a-zA-Z0-9@\.\-_]/', '', $possivelemail);

                $informacoes_de_envio = [
                    'user_id'=>Auth::user()->getAuthIdentifier(),
                    'nome'=>$request->titulo,
                    'email'=>$email,
//                    'telefone'=>$request->telefone,
                ];
                try {
                    $informacoes_de_envio = InformacoesDeEnvios::create($informacoes_de_envio);
                }catch(Exception $e){
                    return redirect(route('listadeenvios.index'))->withErrors(['errors'=>'Erro ao cadastrar envio: '.$e->getMessage()]);
                }

                try {
                    $listaEnvio = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'titulo_lista_de_envios_id'=>$tituloListaEnvios->id,
                        'informacoes_de_envios_id'=>$informacoes_de_envio->id
                    ];
                    ListaDeEnvios::create($listaEnvio);
                }catch(Exception $e){
                    return redirect(route('listadeenvios.index'))->withErrors(['errors'=>'Erro ao cadastrar lista de envios: '.$e->getMessage()]);
                }
            }
        }

        return redirect(route('listadeenvios.index'));
    }
}
