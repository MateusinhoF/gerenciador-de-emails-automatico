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
        Schema::create('nomes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users');
            $table->string('nome1');
            $table->string('nome2')->nullable();
            $table->string('nome3')->nullable();
            $table->string('nome4')->nullable();
            $table->string('nome5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomes');
    }
};
