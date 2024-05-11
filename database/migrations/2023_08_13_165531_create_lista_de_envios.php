<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TituloListaDeEnvios;
use App\Models\Envios;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lista_de_envios', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users');
            $table->foreignIdFor(TituloListaDeEnvios::class)->references('id')->on('titulo_lista_de_envios');
            $table->foreignIdFor(Envios::class)->references('id')->on('envios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_de_envios');
    }
};
