<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $table = 'emails';

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'telefone'
    ];

    public static function Equals(Emails $email1, Emails $email2)
    {
        $isEquals = true;

        if ($email1->nome != $email2->nome) {
            $isEquals = false;
        }
        if ($email1->email != $email2->email) {
            $isEquals = false;
        }
        if ($email1->telefone != $email2->telefone) {
            $isEquals = false;
        }

        return $isEquals;
    }
}
