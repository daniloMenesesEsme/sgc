<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'preco_custo',
        'preco_venda',
        'estoque_minimo',
        'estoque_atual',
        'unidade_medida',
        'imagem',
        'ativo',
    ];

    protected $casts = [
        'preco_custo' => 'decimal:2',
        'preco_venda' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    public function getImagemUrlAttribute()
    {
        return $this->imagem ? asset('storage/' . $this->imagem) : null;
    }

    public function getStatusEstoqueAttribute()
    {
        if ($this->estoque_atual <= 0) {
            return 'danger';
        } elseif ($this->estoque_atual <= $this->estoque_minimo) {
            return 'warning';
        }
        return 'success';
    }

    public function tamanhos()
    {
        return $this->belongsToMany(Tamanho::class)
            ->withPivot('preco')
            ->withTimestamps();
    }
}
