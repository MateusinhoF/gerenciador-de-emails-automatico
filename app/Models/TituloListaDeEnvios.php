<?php

namespace App\Models;

use App\Http\Controllers\TituloListaDeEmailsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TituloListaDeEnvios extends Model
{
    use HasFactory;

    protected $table = 'titulo_lista_de_envios';

    protected $fillable = [
        'user_id',
        'titulo'
    ];

    public static function Equals(TituloListaDeEnvios $titulo1, TituloListaDeEnvios $titulo2)
    {
        $isEquals = true;

        if ($titulo1->titulo != $titulo2->titulo) {
            $isEquals = false;
        }

        return $isEquals;
    }
}
