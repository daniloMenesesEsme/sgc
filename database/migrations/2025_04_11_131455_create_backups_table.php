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
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo'); // 'banco' ou 'sistema'
            $table->string('caminho');
            $table->string('tamanho');
            $table->string('status'); // 'pendente', 'concluido', 'falhou'
            $table->text('observacoes')->nullable();
            $table->timestamp('data_execucao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
