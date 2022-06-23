<?php

namespace App\Http\Controllers;

use App\Models\Historico;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoricoController extends Controller
{
    public $categorias;

    public function __construct(){

        $this->categorias = CategoriaController::index();

    }
    public function AdicionaHistorico(Request $request){
        $categorias = $this->categorias;

        if(!isset($request->id)){
            return redirect()
            ->back();
        }

        return view('dashboard-adiciona-historico', [
            'categorias' => $categorias,
            'id' => $request->id
        ]);
        
    }

    public function AdicionarHistorico(Request $request){
        
        $historico =  Historico::create([
            'id_item' => $request->id_item,
            'descricao' => nl2br($request->descricao),
            'id_usuario_criador' => Auth::user()->id
        ]);

        if( $historico['id'] ){
            $status = 'Sucesso';
        } else {
            $status = "Falha!";
        }

        return redirect()->route('dashboardEdita', ['id' => $request->id_item,  'status' => $status ]);
    }
}
