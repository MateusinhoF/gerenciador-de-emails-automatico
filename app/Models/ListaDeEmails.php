<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDeEmails extends Model
{
    use HasFactory;

    protected $table = 'lista_de_emails';

    protected $fillable = [
        'titulo_lista_de_emails_id',
        'emails_id'
    ];

    public static function Equals(ListaDeEmails $lista1, ListaDeEmails $lista2)
    {
        $isEquals = true;

        if ($lista1->titulo_lista_de_emails_id != $lista2->titulo_lista_de_emails_id) {
            $isEquals = false;
        }
        if ($lista1->emails_id != $lista2->emails_id) {
            $isEquals = false;
        }

        return $isEquals;
    }

    public function tituloListaDeEmails(){
        return $this->hasMany(TituloListaDeEmails::class);
    }

    public function emails(){
        return $this->hasMany(Emails::class);
    }
}
