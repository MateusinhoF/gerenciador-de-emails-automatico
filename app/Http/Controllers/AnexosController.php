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
use Mockery\Exception;

class AnexosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        try {
            VinculadorAnexos::where('id','=',$id)->first();
        }catch(Exception $e){
            return redirect(route('corpoemail.index'))->withErrors(['errors'=>'Erro ao procurar anexos '.$e->getMessage()]);
        }
        $listaanexos = DB::table('lista_anexos')->where('vinculador_anexos_id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        $anexos = [];

        foreach ($listaanexos as $identificador){
            $anexo = Anexos::where('id','=',$identificador->anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            array_push($anexos, $anexo);
        }
        return view('anexos/index', ['anexos'=>$anexos, 'vinculador_anexos_id'=>$id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro ao encontrar corpo de email: '.$e->getMessage()]);
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

                if ($listaanexos->count() == 1){
                    $vinculadoranexos = VinculadorAnexos::where('id','=',$listaanexo->vinculador_anexos_id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                    VinculadorAnexos::destroy($vinculadoranexos);
                }

                File::delete(base_path().'/anexos/'.$anexo->hashname);
                $listaanexo->delete();
                Anexos::destroy($anexo);

            }else{
                return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro, anexo não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('anexos.index', ['id'=>$vinculador_anexos_id]));
    }
}
