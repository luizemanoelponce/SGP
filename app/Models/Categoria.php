<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'status',
        'id_usuario_criacao',
        'id_usuario_atualizacao',
        'prefixo'
    ];
}
