<?php

namespace App\Models;

use App\Http\Controllers\TituloListaDeEmailsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TituloListaDeEmails extends Model
{
    use HasFactory;

    protected $table = 'titulo_lista_de_emails';

    protected $fillable = [
        'titulo'
    ];

    public static function Equals(TituloListaDeEmails $titulo1, TituloListaDeEmails $titulo2)
    {
        $isEquals = true;

        if ($titulo1->titulo != $titulo2->titulo) {
            $isEquals = false;
        }

        return $isEquals;
    }
}
