<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nome_atributo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categoria',
        'nome_do_atributo'
    ];

    public $timestamps = true;
}
