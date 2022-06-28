<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Atributos;
use Illuminate\Support\Facades\Auth;
use App\Models\Historico;


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

        $item_antes = Item::find($data->id_item);
        $atributos_antes = Atributos::showAtributosItem($data->id_item);


        $update_item = Item::where(['id' => $data->id_item])
            ->update([
                'nome' => $data->nome,
                'localizacao' => $data->localizacao,
                'data_de_aquisicao' => $data->data_de_aquisicao,
                'id_categoria' => $data->id_categoria,
                'id_usuario_ultima_atualizacao' => $user->id,
                'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $item_depois = Item::find($data->id_item);

        if($update_item){

            $item_antes = "
                Nome: $item_antes->nome <br>
                Localização: $item_antes->localizacao <br>
                Data de Aquisição: $item_antes->data_de_aquisicao <br>
                ID_Categoria: $item_antes->id_categoria <br>
            ";

            $item_depois = "
                Nome: $item_depois->nome <br>
                Localização: $item_depois->localizacao <br>
                Data de Aquisição: $item_depois->data_de_aquisicao <br>
                ID_Categoria: $item_depois->id_categoria <br>
            ";

            $RegHistoricoItem = Historico::create([
                'id_item' => $data->id_item,
                'descricao' => '<strong> Item atualizado: de: </strong><br>'.  str_replace(',', '<br>', $item_antes) . '<br> <strong>para:</strong><br> ' . str_replace(',', '<br>', $item_depois) ,
                'id_usuario_criador' => Auth::user()->id,
            ]);    
        }


        if($data->indices_atributos){
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

            $atributos_depois = Atributos::showAtributosItem($data->id_item);

            $atributos_antes_transformado = '';
            $atributos_depois_transformado = '';

            if($update_item){
                
                foreach($atributos_antes as $i){
                    $atributos_antes_transformado = $atributos_antes_transformado . "$i->nome_do_atributo: $i->valor <br> "; 
                }

                foreach($atributos_depois as $i){
                    $atributos_depois_transformado = $atributos_depois_transformado . "$i->nome_do_atributo: $i->valor <br> "; 
                }

                $RegHistoricoItem = Historico::create([
                    'id_item' => $data->id_item,
                    'descricao' => '<strong> Atributos Atualizados: de: </strong><br>'.  str_replace(',', '<br>',$atributos_antes_transformado) . '<br> <strong>para:</strong><br> ' . str_replace(',', '<br>', $atributos_depois_transformado) ,
                    'id_usuario_criador' => Auth::user()->id,
                ]);    
            }
            
        } else {
            $update_atributo = '';
        }


        return [$update_item, $update_atributo];
    }

}
