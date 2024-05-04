<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmailsController extends Controller
{
    public function index(){
        $emails = DB::table('emails')->where('user_id','=',Auth::user()->getAuthIdentifier())->orderBy('id','desc')->get();
        return view('emails/index', ['emails'=>$emails]);
    }

    public function create(){
        return view('emails/create');
    }

    public function store(Request $request){
        $request->validate([
            'nome'=>'required|nome',
            'email'=>'required|email'
        ]);

        $email = [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'nome'=>$request->nome,
            'email'=>$request->email,
            'telefone'=>$request->telefone
        ];

        try{
            Emails::create($email);
        }catch(Exception $e){
            return redirect(route('emails.create'))->withErrors(['errors'=>'Erro ao cadastrar o email '.$e->getMessage()]);
        }
        return redirect(route('emails.index'));
    }

    public function edit(string $id){
        try{
            $email = Emails::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch(Exception $e){
            return redirect(route('emails.index'))->withErrors(['errors'=>'Erro ao encontrar email: '.$e->getMessage()]);
        }

        return view('emails/update',['email'=>$email]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nome'=>'required|nome',
            'email'=>'required|email'
        ]);

        try {
            $email = Emails::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();;
        }catch (Exception $e){
            return redirect(route('emails.edit'))->withErrors(['errors'=>'Erro ao encontrar email: '.$e->getMessage()]);
        }
        $novoEmail = $email->replicate();

        $novoEmail->nome = $request->nome;
        $novoEmail->email = $request->email;
        $novoEmail->telefone = $request->telefone;

        if(!Emails::Equals($email,$novoEmail)){
            try{
                $email->nome = $novoEmail->nome;
                $email->email = $novoEmail->email;
                $email->telefone = $novoEmail->telefone;
                $email->save();
            }catch (Exception $e){
                return redirect(route('emails.edit'))->withErrors(['errors'=>'Erro ao salvar novo email: '.$e->getMessage()]);
            }
        }

        return redirect(route('emails.index'));
    }

    public function destroy(string $id){
        try{
            $email = Emails::where('id','=',$id)->where('user_id','=',Auth::user()->getAuthIdentifier())->first();

            if($email){
                $email->delete();
            }else{
                return redirect(route('emails.index'))->withErrors(['errors'=>'Erro, email não encontrado']);
            }
        }catch(Exception $e){
            return redirect(route('emails.index'))->withErrors(['errors'=>'Erro na exclusão: '.$e->getMessage()]);
        }

        return redirect(route('emails.index'));
    }

}
