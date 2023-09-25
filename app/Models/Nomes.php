<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomes extends Model
{
    use HasFactory;

    protected $table = 'nomes';

    protected $fillable = [
        'nome1',
        'nome2',
        'nome3',
        'nome4',
        'nome5'
    ];

    public static function Equals(Nomes $nomes1, Nomes $nomes2){
        $isEquals = true;

        if($nomes1->nome1 != $nomes2->nome1){
            $isEquals = false;
        }
        if($nomes1->nome2 != $nomes2->nome2){
            $isEquals = false;
        }

        if($nomes1->nome3 != $nomes2->nome3){
            $isEquals = false;
        }

        if($nomes1->nome4 != $nomes2->nome4){
            $isEquals = false;
        }

        if($nomes1->nome5 != $nomes2->nome5){
            $isEquals = false;
        }

        return $isEquals;
    }
}
