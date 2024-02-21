<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaAnexos extends Model
{
    use HasFactory;


    protected $table = 'lista_anexos';

    protected $fillable = [
        'user_id',
        'vinculador_anexos_id',
        'anexos_id'
    ];

    public static function Equals(ListaAnexos $lista1, ListaAnexos $lista2)
    {
        $isEquals = true;

        if ($lista1->vinculador_anexos_id != $lista2->vinculador_anexos_id) {
            $isEquals = false;
        }

        return $isEquals;
    }

    public function anexos(){
        return $this->hasMany(Anexos::class);
    }

}
