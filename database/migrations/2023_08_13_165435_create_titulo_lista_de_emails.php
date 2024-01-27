<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('titulo_lista_de_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users');
            $table->string('titulo');
            $table->boolean('em_uso')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulo_lista_de_emails');
    }
};
