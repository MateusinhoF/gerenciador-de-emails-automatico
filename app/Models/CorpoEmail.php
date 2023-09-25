<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorpoEmail extends Model
{
    use HasFactory;

    protected $table = 'corpo_email';

    protected $fillable = [
        'titulo',
        'assunto',
        'texto'
    ];

    public static function Equals(CorpoEmail $corpo1, CorpoEmail $corpo2)
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

        return $isEquals;
    }

}
