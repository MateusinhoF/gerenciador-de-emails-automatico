<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Nomes;
use App\Models\CorpoEmail;
use App\Models\TituloListaDeEmails;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('para_enviar', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->foreignIdFor(Nomes::class)->nullable()->references('id')->on('nomes');
            $table->foreignIdFor(CorpoEmail::class)->references('id')->on('corpo_email');
            $table->foreignIdFor(TituloListaDeEmails::class)->references('id')->on('titulo_lista_de_emails');
            $table->foreignIdFor(TituloListaDeEmails::class,'titulo_lista_de_emails_cc_id')->nullable()->references('id')->on('titulo_lista_de_emails');
            $table->foreignIdFor(TituloListaDeEmails::class,'titulo_lista_de_emails_cco_id')->nullable()->references('id')->on('titulo_lista_de_emails');
            $table->boolean('continuar_envio')->default(true);
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('para_enviar');
    }
};
