<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Atributos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_nome_atributo',
        'id_item',
        'valor',
        'id_usuario_criador',
        'id_usuario_ultima_atualizacao',
    ];

    public $timestamps = true;

    public function showAtributosItem($item){
            
        $atributo = DB::table('atributos')
            ->join('nome_atributos', 'atributos.id_nome_atributo', '=', 'nome_atributos.id')
            ->select('atributos.*', 'nome_atributos.nome_do_atributo as nome_do_atributo')
            ->orderBy('nome_do_atributo')
            ->where('atributos.id_item', $item)
            ->get();

        return $atributo;
    }
}
