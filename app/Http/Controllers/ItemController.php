<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Atributos;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function showByCategorias($id){

        $items = Item::getItemsForCategorias($id); 
        return $items;

    }

    public function show($id){

        $item = Item::getItemsAtributosAndHitorico($id);
        return $item;

    }

    public function edit($data){

        $user = Auth::user();

        $update_item = Item::where(['id' => $data->id_item])
            ->update([
                'nome' => $data->nome,
                'localizacao' => $data->localizacao,
                'data_de_aquisicao' => $data->data_de_aquisicao,
                'id_categoria' => $data->id_categoria,
                'id_usuario_ultima_atualizacao' => $user->id,
                'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $indices = explode("-", $data->indices_atributos);
        foreach ($indices as $indice) {
            $idsRef = explode('|', $indice);

            if (count($idsRef) == 2 ){
                
                $update_atributo = Atributos::where('id_nome_atributo', $idsRef[0])
                        ->where('id_item', $idsRef[1])
                        ->update([
                        'valor' => $data->$indice,
                        ]);

            }

            if (count($idsRef) == 3 ){
                
                $update_atributo = Atributos::create([
                    'id_nome_atributo' =>  $idsRef[0],
                    'id_item' =>  $idsRef[1],
                    'valor' => $data->$indice,
                    'id_usuario_criador' => $user->id
                ]);
                        
            }
        }

        return [$update_item, $update_atributo];
    }

}
