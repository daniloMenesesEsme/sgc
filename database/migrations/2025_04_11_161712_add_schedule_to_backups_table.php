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
        Schema::table('backups', function (Blueprint $table) {
            $table->string('frequencia')->nullable()->comment('diario, semanal, mensal');
            $table->time('horario')->nullable()->comment('Horário para execução');
            $table->boolean('ativo')->default(true)->comment('Indica se o agendamento está ativo');
            $table->json('dias_semana')->nullable()->comment('Dias da semana (para backups semanais)');
            $table->unsignedTinyInteger('dia_mes')->nullable()->comment('Dia do mês (para backups mensais)');
            $table->dateTime('proximo_backup')->nullable()->comment('Data e hora do próximo backup agendado');
            $table->dateTime('ultimo_backup')->nullable()->comment('Data e hora do último backup bem-sucedido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backups', function (Blueprint $table) {
            $table->dropColumn([
                'frequencia',
                'horario',
                'ativo',
                'dias_semana',
                'dia_mes',
                'proximo_backup',
                'ultimo_backup'
            ]);
        });
    }
};
