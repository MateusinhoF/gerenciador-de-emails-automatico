<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VinculadorAnexos extends Model
{
    use HasFactory;


    protected $table = 'vinculador_anexos';

    protected $fillable = [
        'user_id',
        'hash'
    ];

    public static function Equals(VinculadorAnexos $vinculador1, VinculadorAnexos $vinculador2)
    {
        $isEquals = true;

        if ($vinculador1->hash != $vinculador2->hash) {
            $isEquals = false;
        }

        return $isEquals;
    }
}
