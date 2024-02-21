<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexos extends Model
{
    use HasFactory;


    protected $table = 'anexos';

    protected $fillable = [
        'user_id',
        'nome',
        'hashname'
    ];

    public static function Equals(Anexos $anexo1, Anexos $anexo2)
    {
        $isEquals = true;

        if ($anexo1->nome != $anexo2->nome) {
            $isEquals = false;
        }
        if ($anexo1->hashname != $anexo2->hashname) {
            $isEquals = false;
        }

        return $isEquals;
    }
}
