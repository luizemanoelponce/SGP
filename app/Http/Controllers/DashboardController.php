<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Patrimonio;
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

        if( $items[0] == 1 && $items[1] == 1 ){
            $status = 'Sucesso';
        } else {
            $status = "Falha!";
        }

        return redirect()->route('dashboardEdita', ['id' => $request->id,  'status' => $status ]);
    }

    public function dashboardAdiciona(){
        $categorias = $this->categorias;

        return view('dashboard-adiciona-item', [
            'categorias' => $categorias,
        ]);

    }

    public function dashboardAdicionar(Request $request){

        $user = Auth::user();

        $item = Item::create([
            'nome' => $request->nome,
            'status' => 1,
            'localizacao' => $request->localizacao,
            'data_de_aquisicao' => $request->data_de_aquisicao,
            'id_categoria' => $request->id_categoria,
            'id_usuario_criacao' => $user->id,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $num_patrimonio = Patrimonio::where('id_categoria', $request->id_categoria)
                                ->orderByDesc('numero')
                                ->limit(1)
                                ->get();

        $num_patrimonio = $num_patrimonio[0]->numero + 1;

        $patrimonio = Patrimonio::create([
            "id_categoria" => $request->id_categoria,
            "id_item" => $item["id"],
            "numero" => $num_patrimonio
        ]);

        return redirect()->route('dashboardEdita', ['id' => $item["id"]]);
    }
}
