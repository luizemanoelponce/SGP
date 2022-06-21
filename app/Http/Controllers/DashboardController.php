<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoriaController;

class DashboardController extends Controller
{

    public $categorias;

    public function __construct(){

        $this->categorias = CategoriaController::index();

    }
    public function dashboardHome(Request $request){

        $categorias = $this->categorias;

        if($request->id){

            return view('dashboard', [
                'items' => json_encode(ItemController::showByCategorias($request->id), JSON_UNESCAPED_UNICODE),
                'categorias' => $categorias,
            ]);

        } else {

            return view('dashboard', [
                'items' => '',
                'categorias' => $categorias,
            ]);

        }
    }

    public function dashboardVer(Request $request){

        $categorias = $this->categorias;
        $items = ItemController::show($request->id);

        if(count($items[0]) > 0){
            
            return view('dashboard-ver-item', [
                'items' => json_encode($items, JSON_UNESCAPED_UNICODE),
                'categorias' => $categorias,
    
            ]);

        } else {
            return redirect()->route('dashboardHome');
        }
    }

    public function dashboardEdita(Request $request){

        $categorias = $this->categorias;
        $items = ItemController::show($request->id);

        if(count($items[0]) > 0){
            
            return view('dashboard-editar-item', [
                'items' => json_encode($items, JSON_UNESCAPED_UNICODE),
                'categorias' => $categorias,
    
            ]);

        } else {
            return redirect()->route('dashboardHome');
        }
    }

    public function dashboardEditar(Request $request){

        $items = ItemController::edit($request);

    }
}
