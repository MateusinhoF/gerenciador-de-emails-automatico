<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $table = 'mensagem';

    protected $fillable = [
        'user_id',
        'titulo',
        'assunto',
        'texto',
        'vinculador_anexos_id'
    ];

    public static function Equals(Mensagem $corpo1, Mensagem $corpo2)
    {
        $isEquals = true;

        if ($corpo1->titulo != $corpo2->titulo) {
            $isEquals = false;
        }
        if ($corpo1->assunto != $corpo2->assunto) {
            $isEquals = false;
        }
        if ($corpo1->texto != $corpo2->texto) {
            $isEquals = false;
        }
        if ($corpo1->vinculador_anexos_id != $corpo2->vinculador_anexos_id) {
            $isEquals = false;
        }

        return $isEquals;
    }

}
