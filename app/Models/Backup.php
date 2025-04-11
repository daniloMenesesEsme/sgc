<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = [
        'nome',
        'tipo',
        'caminho',
        'tamanho',
        'status',
        'observacoes',
        'data_execucao',
        'frequencia',
        'horario',
        'ativo',
        'dias_semana',
        'dia_mes',
        'proximo_backup',
        'ultimo_backup'
    ];

    protected $casts = [
        'data_execucao' => 'datetime',
        'ativo' => 'boolean',
        'dias_semana' => 'array',
        'proximo_backup' => 'datetime',
        'ultimo_backup' => 'datetime'
    ];

    /**
     * Determina o próximo horário de backup com base na frequência
     * @return \DateTime
     */
    public function calcularProximoBackup()
    {
        $agora = now();
        $horario = $this->horario ? \Carbon\Carbon::parse($this->horario) : \Carbon\Carbon::parse('23:00');
        
        // Definir hora, minuto e segundo do horário especificado
        $proximo = $agora->copy()->setTime($horario->hour, $horario->minute, 0);
        
        // Se o horário já passou hoje, agendar para o próximo dia ou período
        if ($proximo->lt($agora)) {
            $proximo->addDay();
        }
        
        // Ajustar conforme a frequência
        if ($this->frequencia === 'semanal') {
            $diasSemana = $this->dias_semana ?: [1]; // Segunda-feira por padrão
            
            // Encontrar o próximo dia da semana correspondente
            while (!in_array($proximo->dayOfWeek, $diasSemana)) {
                $proximo->addDay();
            }
        } elseif ($this->frequencia === 'mensal') {
            $diaDoMes = $this->dia_mes ?: 1; // Dia 1 por padrão
            
            // Avançar para o mês atual ou próximo e definir o dia
            $proximo->day($diaDoMes);
            
            // Se a data resultante for no passado, avançar para o próximo mês
            if ($proximo->lt($agora)) {
                $proximo->addMonth();
                $proximo->day(min($diaDoMes, $proximo->daysInMonth));
            }
        }
        
        return $proximo;
    }
}
