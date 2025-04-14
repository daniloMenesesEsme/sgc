<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';
    
    protected $fillable = [
        'tipo',
        'nome_razao_social',
        'nome_fantasia',
        'cpf_cnpj',
        'rg_ie',
        'im',
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
        'contato_nome',
        'contato_email',
        'contato_telefone',
        'categoria',
        'fornece_tecido',
        'fornece_tinta',
        'fornece_papel',
        'fornece_outros',
        'produtos_fornecidos',
        'condicoes_pagamento',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'fornece_tecido' => 'boolean',
        'fornece_tinta' => 'boolean',
        'fornece_papel' => 'boolean',
        'fornece_outros' => 'boolean',
        'ativo' => 'boolean',
    ];

    /**
     * Implementação de "exclusão lógica" usando o campo ativo
     */
    public function delete()
    {
        $this->ativo = false;
        return $this->save();
    }

    /**
     * Retorna somente fornecedores ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Retorna fornecedores que fornecem tecidos
     */
    public function scopeTecidos($query)
    {
        return $query->where('fornece_tecido', true);
    }

    /**
     * Retorna fornecedores que fornecem tintas
     */
    public function scopeTintas($query)
    {
        return $query->where('fornece_tinta', true);
    }

    /**
     * Retorna fornecedores que fornecem papéis
     */
    public function scopePapeis($query)
    {
        return $query->where('fornece_papel', true);
    }

    /**
     * Relação com os produtos que esse fornecedor fornece
     */
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    /**
     * Relação com as compras feitas para esse fornecedor
     */
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
} 