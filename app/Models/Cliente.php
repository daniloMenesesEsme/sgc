<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo',
        'nome_razao_social',
        'nome_fantasia',
        'cpf_cnpj',
        'rg_ie',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'telefone',
        'celular',
        'email',
        'site',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}
