<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\ListaDeEmails;
use App\Models\TituloListaDeEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class ListaDeEmailsController extends Controller
{
    public function index(){

        $listatitulosemails = DB::table('lista_de_emails')
            ->where('lista_de_emails.user_id','=',Auth::user()->getAuthIdentifier())
            ->join('titulo_lista_de_emails','titulo_lista_de_emails.id','=','lista_de_emails.titulo_lista_de_emails_id')
            ->join('emails','emails.id','=','lista_de_emails.emails_id')
            ->select('lista_de_emails.*','titulo_lista_de_emails.titulo','emails.email')
            ->orderBy('lista_de_emails.titulo_lista_de_emails_id','desc')->get();

        return view('listadeemails/index', ['listatitulosemails'=>$listatitulosemails]);
    }

    public function create(){
        $emails = DB::table('emails')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('listadeemails/create',['emails'=>$emails]);
    }

    public function store(Request $request){

        $request->validate([
            'titulo'=>'required',
            'email'=>'required'
        ]);

        try {
            $titulo = TituloListaDeEmails::create(['user_id'=>Auth::user()->getAuthIdentifier(),'titulo' => $request->titulo]);
        }catch(Exception $e){
            return redirect(route('listadeemails.create'))->withErrors(['errors'=>'Erro ao criar título '.$e->getMessage()]);
        }
        try{
            foreach ($request->email as $email){
                $email = Emails::find($email)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
                $lista = [
                    'user_id'=>Auth::user()->getAuthIdentifier(),
                    'titulo_lista_de_emails_id'=>$titulo->id,
                    'emails_id'=>$email->id
                ];
                ListaDeEmails::create($lista);
            }
            $titulo->save();
        }catch(Exception $e){
            return redirect(route('listadeemails.create'))->withErrors(['errors'=>'Erro ao cadastrar lista '.$e->getMessage()]);
        }
        return redirect(route('listadeemails.index'));
    }

    public function edit(string $id){
        try{
            $listatitulosemails = DB::table('lista_de_emails')
                ->where('titulo_lista_de_emails_id','=',$id)
                ->where('lista_de_emails.user_id','=',Auth::user()->getAuthIdentifier())
                ->join('titulo_lista_de_emails','titulo_lista_de_emails.id','=','lista_de_emails.titulo_lista_de_emails_id')
                ->select('lista_de_emails.*','titulo_lista_de_emails.titulo')
                ->orderBy('lista_de_emails.id','desc')->get();

            $emails = DB::table('emails')->orderBy('id','desc')->get();

        }catch(Exception $e){
            return redirect(route('listadeemails.index'))->withErrors(['errors'=>'Erro ao encontrar as partes da lista: '.$e->getMessage()]);
        }

        return view('listadeemails/update',['listatitulosemails'=>$listatitulosemails, 'emails'=>$emails]);
    }

    public function update(Request $request, string $id){

        $request->validate([
            'titulo'=>'required',
            'email'=>'required'
        ]);

        try{
            $listatitulosemails = DB::table('lista_de_emails')
                ->where('user_id','=',Auth::user()->getAuthIdentifier())
                ->where('titulo_lista_de_emails_id','=',$id)
                ->get();
        }catch (Exception $e){
            return redirect(route('listadeemails.edit'))->withErrors(['errors'=>'Erro ao encontrar lista: '.$e->getMessage()]);
        }

        $titulo = TituloListaDeEmails::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
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

        $emails = $request->email;

        foreach ($listatitulosemails as $listatitulosemail) {
            $continua = false;
            foreach ($emails as $email){
                if($listatitulosemail->emails_id == $email){
                    $continua = true;
                    break;
                }
            }
            if (!$continua){
                ListaDeEmails::destroy($listatitulosemail->id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
            }
        }

        foreach ($emails as $email){
            $novo = true;
            foreach ($listatitulosemails as $listatitulosemail) {
                if($email == $listatitulosemail->emails_id){
                    $novo = false;
                    break;
                }
            }
            if($novo){
                $novaLista = [
                    'user_id'=>Auth::user()->getAuthIdentifier(),
                    'titulo_lista_de_emails_id'=>$id,
                    'emails_id'=>$email
                ];
                ListaDeEmails::create($novaLista);
            }
        }

        return redirect(route('listadeemails.index'));
    }

    public function destroy(string $id){
        try{
            $lista = DB::table('lista_de_emails')->where('titulo_lista_de_emails_id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->get();
            if($lista->count() > 0){
                foreach ($lista as $index) {
                    ListaDeEmails::destroy($index->id);
                }
            }else{
                return redirect(route('listadeemails.index'))->withErrors(['errors'=>'Erro, lista não encontrado']);
            }
            $titulo = TituloListaDeEmails::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();
            TituloListaDeEmails::destroy($titulo->id);
        }catch(Exception $e){
            return redirect(route('listadeemails.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('listadeemails.index'));
    }

    public function receiveListEmail(){
        return view('listadeemails/receivelistemail');
    }

    public function storeListEmail(Request $request){
        $request->validate([
            'titulo'=>'required',
            'lista'=>'required'
        ]);

        $tituloListaEmail = [
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'titulo'=>$request->titulo
        ];
        try {
            $tituloListaEmail = TituloListaDeEmails::create($tituloListaEmail);
        }catch(Exception $e){
            return redirect(route('listadeemails.index'))->withErrors(['errors'=>'Erro ao cadastrar titulo: '.$e->getMessage()]);
        }

        $listaparatratar = preg_split("/[\s,]+|\n/",$request->lista);

        foreach ($listaparatratar as $possivelemail){
            if (strpos($possivelemail, "@") > 0){
                $email = preg_replace('/[^a-zA-Z0-9@\.\-_]/', '', $possivelemail);

                $email = [
                    'user_id'=>Auth::user()->getAuthIdentifier(),
                    'email'=>$email,
                ];
                try {
                    $email = Emails::create($email);
                }catch(Exception $e){
                    return redirect(route('listadeemails.index'))->withErrors(['errors'=>'Erro ao cadastrar email: '.$e->getMessage()]);
                }

                try {
                    $listaEmail = [
                        'user_id'=>Auth::user()->getAuthIdentifier(),
                        'titulo_lista_de_emails_id'=>$tituloListaEmail->id,
                        'emails_id'=>$email->id
                    ];
                    ListaDeEmails::create($listaEmail);
                }catch(Exception $e){
                    return redirect(route('listadeemails.index'))->withErrors(['errors'=>'Erro ao cadastrar lista de emails: '.$e->getMessage()]);
                }
            }
        }

        return redirect(route('listadeemails.index'));
    }
}
