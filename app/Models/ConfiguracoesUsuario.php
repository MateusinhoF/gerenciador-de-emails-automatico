<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracoesUsuario extends Model
{
    use HasFactory;

    protected $table = 'configuracoes_usuario';

    protected $fillable = [
        'user_id',
        'email',
        'senha'
    ];

    public static function Equals(ConfiguracoesUsuario $configuracoesUsuario1, ConfiguracoesUsuario $configuracoesUsuario2)
    {
        $isEquals = true;

        if ($configuracoesUsuario1->email != $configuracoesUsuario2->email) {
            $isEquals = false;
        }

        return $isEquals;
    }

    public function users(){
        return $this->hasOne(User::class);
    }

}
