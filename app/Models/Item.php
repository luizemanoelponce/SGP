<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Nome_atributo;
use App\Models\Atributos;
use App\Models\User;



class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'status',
        'localizacao',
        'data_de_aquisicao',
        'id_usuario_criacao',
        'id_usuario_atualizacao',
        'id_categoria',
    ];

    public function getItemsForCategorias($id){
        $items = DB::table('items')
            ->join('categorias', 'items.id_categoria', '=', 'categorias.id')
            ->join('users', 'items.id_usuario_criacao', '=', 'users.id')
            ->join('patrimonios', 'items.id', '=', 'patrimonios.id_item')
            ->select('items.*', 'categorias.nome as categoria_nome', 'categorias.prefixo as prefixo' , 'users.name as criador_nome', 'patrimonios.numero as patrimonio')
            ->orderBy('categoria_nome')
            ->orderBy('nome')
            ->where('items.status', 1)
            ->where('items.id_categoria', $id)
            ->get();

        return $items;
    }

    public function getItemsAtributosAndHitorico($id){

        $items = DB::table('items')
            ->join('categorias', 'items.id_categoria', '=', 'categorias.id')
            ->join('users', 'items.id_usuario_criacao', '=', 'users.id')
            ->join('patrimonios', 'items.id', '=', 'patrimonios.id_item')
            ->select('items.*', 'categorias.nome as categoria_nome', 'categorias.prefixo as prefixo' , 'users.name as criador_nome', 'patrimonios.numero as patrimonio')
            ->orderBy('categoria_nome')
            ->orderBy('nome')
            ->where('items.id', $id)
            ->where('items.status', 1)
            ->get();
        
        $atributos = Atributos::showAtributosItem($id);

        if(!isset($atributos[0])){

            $atributos = Nome_atributo::where('id_categoria', $items[0]->id_categoria)->get();

        }

        $ultimaAtualizacao = [];

        if(!empty($items[0]->id_usuario_ultima_atualizacao)){

            $ultimaAtualizacao = User::find($items[0]->id_usuario_ultima_atualizacao);

        }

        $dados = [$items, $atributos, $ultimaAtualizacao];

        return $dados;
    }
}
