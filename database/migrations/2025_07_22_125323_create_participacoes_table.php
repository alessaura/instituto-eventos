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
        Schema::create('participacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->datetime('data_participacao');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Evitar participações duplicadas
            $table->unique(['pessoa_id', 'evento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participacoes');
    }
};
