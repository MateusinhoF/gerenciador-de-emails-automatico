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

class AnexosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $vinculador_anexos_id)
    {
        try {
            VinculadorAnexos::where('id','=',$vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch(Exception $e){
            return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao procurar anexos '.$e->getMessage()]);
        }
        $listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=',$vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        $anexos = [];

        foreach ($listaanexos as $identificador){
            $anexo = Anexos::where('id','=',$identificador->anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            array_push($anexos, $anexo);
        }
        return view('anexos/index', ['anexos'=>$anexos, 'vinculador_anexos_id'=>$vinculador_anexos_id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $vinculador_anexos_id)
    {
        try {
            VinculadorAnexos::where('id','=',$vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch(Exception $e){
            return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao adicionar anexo '.$e->getMessage()]);
        }
        return view('anexos/create', ['vinculador_anexos_id'=>$vinculador_anexos_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $vinculador_anexos_id)
    {
        if ($request->hasFile('anexos')){

            try {
                $vinculador_anexos = VinculadorAnexos::where('id','=',$vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                
                if($vinculador_anexos == null){
                    $vinculador_anexos = [
                        'user_id'=>Auth::user()->getAuthIdentifier()
                    ];
                    $vinculador_anexos = VinculadorAnexos::create($vinculador_anexos);
                }
            }catch(Exception $e){
                return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao adicionar anexo '.$e->getMessage()]);
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
                        return redirect(route('anexos.create', ['vinculador_anexos_id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro ao adicionar anexo a mensagem, anexo: '.$e->getMessage()]);
                    }

                    $listaanexos = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'vinculador_anexos_id'=>$vinculador_anexos->id,
                        'anexos_id'=>$anexoDB->id
                    ];

                    try{
                        ListaAnexos::create($listaanexos);
                    }catch (Exception $e){
                        return redirect(route('anexos.create', ['vinculador_anexos_id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro ao adicionar anexos a mensagem, lista de anexo: '.$e->getMessage()]);
                    }
                }else{
                    return redirect(route('anexos.create', ['vinculador_anexos_id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro ao adicionar anexos a mensagem, erro no anexo: '.$anexo->getErrorMessage()]);
                }
            }
        }

        return redirect(route('anexos.index', ['vinculador_anexos_id'=>$vinculador_anexos_id]));

    }

    public function novoAnexo(string $mensagem_id)
    {
        return view('anexos/novoAnexo', ['mensagem_id'=>$mensagem_id]);
    }

    public function storeNovoAnexo(Request $request, string $mensagem_id){

        if ($request->hasFile('anexos')){
            try {
                $mensagem = Mensagem::where('id','=',$mensagem_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            }catch(Exception $e){
                return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao adicionar anexo '.$e->getMessage()]);
            }
            $vinculador_anexos = [
                'user_id'=>Auth::user()->getAuthIdentifier()
            ];
            try {
                $vinculador_anexos = VinculadorAnexos::create($vinculador_anexos);
            }catch(Exception $e){
                return redirect(route('mensagem.index'))->withErrors(['errors'=>'Erro ao adicionar anexo '.$e->getMessage()]);
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
                        return redirect(route('anexos.novoAnexo', ['mensagem_id'=>$mensagem_id]))->withErrors(['errors'=>'Erro ao adicionar anexo a mensagem, anexo: '.$e->getMessage()]);
                    }

                    $listaanexos = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'vinculador_anexos_id'=>$vinculador_anexos->id,
                        'anexos_id'=>$anexoDB->id
                    ];

                    try{
                        ListaAnexos::create($listaanexos);
                    }catch (Exception $e){
                        return redirect(route('anexos.novoAnexo', ['mensagem_id'=>$mensagem_id]))->withErrors(['errors'=>'Erro ao adicionar anexos a mensagem, lista de anexo: '.$e->getMessage()]);
                    }
                }else{
                    return redirect(route('anexos.novoAnexo', ['mensagem_id'=>$mensagem_id]))->withErrors(['errors'=>'Erro ao adicionar anexos a mensagem, erro no anexo: '.$anexo->getErrorMessage()]);
                }
            }

            $mensagem->vinculador_anexos_id = $vinculador_anexos->id;
            $mensagem->save();
        }

        return redirect(route('mensagem.index'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, string $vinculador_anexos_id)
    {
        try{
            $anexo = Anexos::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch(Exception $e){
            return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro ao encontrar mensagem: '.$e->getMessage()]);
        }

        return view('anexos/update',['anexo'=>$anexo, 'vinculador_anexos_id'=>$vinculador_anexos_id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $vinculador_anexos_id)
    {
        $request->validate([
            'nome'=>'required'
        ]);

        try {
            $anexo = Anexos::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
        }catch (Exception $e){
            return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id,]))->withErrors(['errors'=>'Erro ao encontrar: '.$e->getMessage()]);
        }
        $novoAnexo = $anexo->replicate();

        $novoAnexo->nome = $request->nome;

        if(!Anexos::Equals($anexo,$novoAnexo)){
            try{
                $anexo->nome = $novoAnexo->nome;
                $anexo->save();
            }catch (Exception $e){
                return redirect(route('anexos.edit',['id'=>$id, 'vinculador_anexos_id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro ao salvar anexo: '.$e->getMessage()]);
            }
        }

        return redirect(route('anexos.index',['id'=>$vinculador_anexos_id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, string $vinculador_anexos_id)
    {
        try{
            $anexo = Anexos::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($anexo){
                $listaanexo = ListaAnexos::where('anexos_id','=', $anexo->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

                $listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=', $vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();

                File::delete(base_path().'/anexos/'.$anexo->hashname);
                $listaanexo->delete();
                Anexos::destroy($anexo);

                if ($listaanexos->count() == 1){
                    Mensagem::where('vinculador_anexos_id','=',$vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->update(['vinculador_anexos_id'=>null]);
                    $vinculadoranexos = VinculadorAnexos::where('id','=',$listaanexo->vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                    VinculadorAnexos::destroy($vinculadoranexos);

                    return redirect(route('mensagem.index'));
                }

            }else{
                return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro, anexo não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('anexos.index', ['vinculador_anexos_id'=>$vinculador_anexos_id]));
    }
}
