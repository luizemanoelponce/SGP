<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

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

        dd($data);

    }

}
