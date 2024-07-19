<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Nomes;
use App\Models\Mensagem;
use App\Models\TituloListaDeEnvios;
use App\Models\VinculadorAnexos;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('para_enviar', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users');
            $table->string('titulo');
            $table->foreignIdFor(Nomes::class)->nullable()->references('id')->on('nomes');
            $table->foreignIdFor(Mensagem::class)->references('id')->on('mensagem');
            $table->foreignIdFor(TituloListaDeEnvios::class)->references('id')->on('titulo_lista_de_envios');
            $table->foreignIdFor(TituloListaDeEnvios::class,'titulo_lista_de_envios_cc_id')->nullable()->references('id')->on('titulo_lista_de_envios');
            $table->foreignIdFor(TituloListaDeEnvios::class,'titulo_lista_de_envios_cco_id')->nullable()->references('id')->on('titulo_lista_de_envios');
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
