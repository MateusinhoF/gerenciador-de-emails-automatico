<?php

namespace App\Http\Controllers;

use App\Models\TituloListaDeEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TituloListaDeEmailsController extends Controller
{
    public function index(){
        $titulos = DB::table('titulo_lista_de_emails')->orderBy('id','desc')->get();
        return view('titulolistadeemails/index', ['titulos'=>$titulos]);
    }

    public function create(){
        return view('titulolistadeemails/create');
    }

    public function store(Request $request){
        $request->validate([
            'titulo'=>'required'
        ]);

        $titulo = [
            'titulo'=>$request->titulo
        ];

        try{
            TituloListaDeEmails::create($titulo);
        }catch(Exception $e){
            return redirect(route('titulolistadeemails.create'))->withErrors(['errors'=>'Erro ao cadastrar titulo '.$e->getMessage()]);
        }
        return redirect(route('titulolistadeemails.index'));
    }

    public function edit(string $id){
        try{
            $titulo = TituloListaDeEmails::find($id);
        }catch(Exception $e){
            return redirect(route('titulolistadeemails.index'))->withErrors(['errors'=>'Erro ao encontrar titulo: '.$e->getMessage()]);
        }

        return view('titulolistadeemails/update',['titulo'=>$titulo]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'titulo'=>'required'
        ]);

        try {
            $titulo = TituloListaDeEmails::find($id);
        }catch (Exception $e){
            return redirect(route('titulolistadeemails.edit'))->withErrors(['errors'=>'Erro ao encontrar titulo: '.$e->getMessage()]);
        }
        $novoTitulo = $titulo->replicate();

        $novoTitulo->titulo = $request->titulo;

        if(!TituloListaDeEmails::Equals($titulo,$novoTitulo)){
            try{
                $titulo->titulo = $novoTitulo->titulo;
                $titulo->save();
            }catch (Exception $e){
                return redirect(route('titulolistadeemails.edit'))->withErrors(['errors'=>'Erro ao salvar novo titulo: '.$e->getMessage()]);
            }
        }

        return redirect(route('titulolistadeemails.index'));
    }

    public function destroy(string $id){
        try{
            $titulo = TituloListaDeEmails::find($id);

            if($titulo){
                $titulo->delete();
            }else{
                return redirect(route('titulolistadeemails.index'))->withErrors(['errors'=>'Erro, titulo não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('titulolistadeemails.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('titulolistadeemails.index'));
    }

}
