<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    public function professor() {
        return $this->belongsTo(Professor::class);
    }
    
    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }
    
    protected $fillable = ['titulo', 'descricao', 'preco', 'categoria_id', 'professor_id',
    ];
}
