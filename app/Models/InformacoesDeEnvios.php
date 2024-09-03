<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacoesDeEnvios extends Model
{
    use HasFactory;

    protected $table = 'informacoes_de_envios';

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'telefone'
    ];

    public static function Equals(InformacoesDeEnvios $envio1, InformacoesDeEnvios $envio2)
    {
        $isEquals = true;

        if ($envio1->nome != $envio2->nome) {
            $isEquals = false;
        }
        if ($envio1->email != $envio2->email) {
            $isEquals = false;
        }
        if ($envio1->telefone != $envio2->telefone) {
            $isEquals = false;
        }

        return $isEquals;
    }
}
