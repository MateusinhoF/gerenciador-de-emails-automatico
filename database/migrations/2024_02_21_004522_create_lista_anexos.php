<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Anexos;
use App\Models\VinculadorAnexos;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lista_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->foreignIdFor(VinculadorAnexos::class)->references('id')->on('vinculador_anexos');
            $table->foreignIdFor(Anexos::class)->references('id')->on('anexos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_anexos');
    }
};
