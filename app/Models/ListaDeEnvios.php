<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDeEnvios extends Model
{
    use HasFactory;

    protected $table = 'lista_de_envios';

    protected $fillable = [
        'user_id',
        'titulo_lista_de_envios_id',
        'envios_id'
    ];

    public static function Equals(ListaDeEnvios $lista1, ListaDeEnvios $lista2)
    {
        $isEquals = true;

        if ($lista1->titulo_lista_de_envios_id != $lista2->titulo_lista_de_envios_id) {
            $isEquals = false;
        }
        if ($lista1->envios_id != $lista2->envios_id) {
            $isEquals = false;
        }

        return $isEquals;
    }

    public function tituloListaDeEnvios(){
        return $this->hasMany(TituloListaDeEnvios::class);
    }

    public function envios(){
        return $this->hasMany(Envios::class);
    }
}
