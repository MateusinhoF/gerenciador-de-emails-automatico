<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TituloListaDeEmails;
use App\Models\Emails;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lista_de_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TituloListaDeEmails::class)->references('id')->on('titulo_lista_de_emails');
            $table->foreignIdFor(Emails::class)->references('id')->on('emails');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_de_emails');
    }
};
