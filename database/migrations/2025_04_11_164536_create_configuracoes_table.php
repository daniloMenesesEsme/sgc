<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('chave')->unique()->comment('Chave da configuração');
            $table->text('valor')->nullable()->comment('Valor da configuração');
            $table->text('descricao')->nullable()->comment('Descrição da configuração');
            $table->timestamps();
        });
        
        // Inserir configuração padrão para o caminho de backup
        DB::table('configuracoes')->insert([
            'chave' => 'backup_caminho_padrao',
            'valor' => 'backups',
            'descricao' => 'Caminho padrão para salvar os backups',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};
