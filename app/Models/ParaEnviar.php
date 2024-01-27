<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParaEnviar extends Model
{
    use HasFactory;

    protected $table = 'para_enviar';

    protected $fillable = [
        'user_id',
        'titulo',
        'nomes_id',
        'corpo_email_id',
        'titulo_lista_de_emails_id',
        'titulo_lista_de_emails_cc_id',
        'titulo_lista_de_emails_cco_id',
        'continuar_envio',
        'data_inicio',
        'data_fim'
    ];

    public static function Equals(ParaEnviar $paraEnviar1, ParaEnviar $paraEnviar2)
    {
        $isEquals = true;

        if ($paraEnviar1->titulo != $paraEnviar2->titulo) {
            $isEquals = false;
        }
        if ($paraEnviar1->nomes_id != $paraEnviar2->nomes_id) {
            $isEquals = false;
        }
        if ($paraEnviar1->corpo_email_id != $paraEnviar2->corpo_email_id) {
            $isEquals = false;
        }
        if ($paraEnviar1->titulo_lista_de_emails_id != $paraEnviar2->titulo_lista_de_emails_id) {
            $isEquals = false;
        }
        if ($paraEnviar1->titulo_lista_de_emails_cc_id != $paraEnviar2->titulo_lista_de_emails_cc_id) {
            $isEquals = false;
        }
        if ($paraEnviar1->titulo_lista_de_emails_cco_id != $paraEnviar2->titulo_lista_de_emails_cco_id) {
            $isEquals = false;
        }

        return $isEquals;
    }

    public function nomes(){
        return $this->hasMany(Nomes::class);
    }

    public function corpoEmail(){
        return $this->hasMany(CorpoEmail::class);
    }

    public function tituloListaDeEmails(){
        return $this->hasMany(TituloListaDeEmails::class);
    }

    public function tituloListaDeEmailsCC(){
        return $this->hasMany(TituloListaDeEmails::class);
    }

    public function tituloListaDeEmailsCCo(){
        return $this->hasMany(TituloListaDeEmails::class);
    }
}
