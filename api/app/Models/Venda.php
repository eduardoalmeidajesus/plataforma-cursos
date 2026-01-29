<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['curso_id', 'cliente_id', 'valor', 'condicao_pagamento', 'quantidade_parcelas',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
