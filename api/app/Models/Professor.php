<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    public function cursos() {
        return $this->hasMany(Curso::class);
    }
    
    protected $fillable = ['nome', 'email'];

}
