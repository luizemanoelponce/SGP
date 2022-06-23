<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nome_atributo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categoria',
        'nome_do_atributo',
        'status',
        'id_usuario_criador',
        'id_usuario_ultima_atualizacao',
    ];

    public $timestamps = true;
}
