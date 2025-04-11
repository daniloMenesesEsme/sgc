<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamanho extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'ativo'
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class)
            ->withPivot('preco')
            ->withTimestamps();
    }
}
