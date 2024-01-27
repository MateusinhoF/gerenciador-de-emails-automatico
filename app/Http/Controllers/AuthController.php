<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return $this->redirectUsuario();
        }
        return view('acesso/login');
    }

    public function create()
    {
        if(Auth::check()){
            return $this->redirectUsuario();
        }
        return view('acesso/registrese');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'senha_email'=>'required'
        ]);
        $usuario = $request->only('login','password','email','senha_email');

        try{
            User::create($usuario);
        }
        catch(Exception $e){
            return redirect(route('registrese'))->withErrors(['errors'=>'Erro ao criar cadastro: '.$e->getMessage()]);
        }

        return redirect(route('login'));
    }


    public function logar(Request $request){

        $validator = $request->validate([
            'login'=>'required',
            'password'=>'required'
        ]);

        $validate = Auth::attempt($validator);

        if($validate){
            return $this->redirectUsuario();
        }else{
            return redirect(route('login'))->withErrors(['errors'=>'Login ou senha inválidos']);
        }
    }

    private function redirectUsuario(){

        return redirect(route('paraenviar.index'));

    }

    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }
}
