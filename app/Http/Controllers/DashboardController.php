<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Patrimonio;
use App\Models\Categoria;
use App\Models\Nome_atributo;
use App\Models\Historico;
use App\Models\TarefaPeriodo;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TarefaController;


class DashboardController extends Controller
{

    public $categorias;

    public function __construct(){

        $this->categorias = CategoriaController::index();

    }
    public function dashboardHome(Request $request){

        $categorias = $this->categorias;

        $tarefas = TarefaController::index();

        if($request->id){

            return view('dashboard', [
                'items' => json_encode(ItemController::showByCategorias($request->id), JSON_UNESCAPED_UNICODE),
                'categorias' => $categorias,
                'tarefas' => '' 
            ]);

        } else {

            return view('dashboard', [
                'items' => '',
                'categorias' => $categorias,
                'tarefas' => $tarefas
            ]);

        }
    }

    public function dashboardVer(Request $request){


        $categorias = $this->categorias;
        $items = ItemController::show($request->id);
        $tarefas = TarefaController::getTarefasPorItem($request->id);

        if(count($items[0]) > 0){
            
            return view('dashboard-ver-item', [
                'items' => json_encode($items, JSON_UNESCAPED_UNICODE),
                'categorias' => $categorias,
                'tarefas' => $tarefas
    
            ]);

        } else {
            return redirect()->route('dashboardHome');
        }
    }

    public function dashboardEdita(Request $request){

        $categorias = $this->categorias;
        $items = ItemController::show($request->id);
        $tarefas = TarefaController::getTarefasPorItem($request->id);

        if(count($items[0]) > 0){
            
            return view('dashboard-editar-item', [
                'items' => json_encode($items, JSON_UNESCAPED_UNICODE),
                'categorias' => $categorias,
                'tarefas' => $tarefas
    
            ]);

        } else {
            return redirect()->route('dashboardHome');
        }
    }

    public function dashboardEditar(Request $request){

        $items = ItemController::edit($request);

        if( $items[0] == 1 && $items[1] == true ){
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
            
        ]);

        $num_patrimonio = Patrimonio::where('id_categoria', $request->id_categoria)
                                ->orderByDesc('numero')
                                ->limit(1)
                                ->get();

        if(isset($num_patrimonio[0])){
            $num_patrimonio = $num_patrimonio[0]->numero + 1;
        } else {
            $num_patrimonio = 1;
        }
        

        $patrimonio = Patrimonio::create([
            "id_categoria" => $request->id_categoria,
            "id_item" => $item["id"],
            "numero" => $num_patrimonio
        ]);

        $historico = Historico::create([
            'id_item' => $item["id"],
            'descricao' =>  'Item Criado',
            'id_usuario_criador' => Auth::user()->id
        ]);

        return redirect()->route('dashboardEdita', ['id' => $item["id"]]);
    }

    public function dashboardAdicionaCategoria(){

        $categorias = $this->categorias;

        return view('dashboard-adiciona-categoria', [
            'categorias' => $categorias,
        ]);
    }

    public function dashboardAdicionarCategoria(Request $request){

        $user = Auth::user();

        $categoria = Categoria::create([
            'nome' => $request->nome,
            'status' => 1,
            'id_usuario_criacao' => $user->id,
            'prefixo' => strtoupper($request->prefixo),
        ]);

        return redirect()->route('dashboardAdicionaAtributoCategoria', ['id' => $categoria["id"]]);
    }

    public function dashboardAdicionaAtributoCategoria(Request $request){

        $categorias = $this->categorias;

        if($request->id){
            return view('dashboard-adiciona-atributo-categoria', [
                'categorias' => $categorias,
                'id' => $request->id
            ]);
        } else {
            return view('dashboard-adiciona-atributo-categoria', [
                'categorias' => $categorias,
                'id' => ''
            ]);
        }
    }

    public function dashboardAdicionarAtributoCategoria(Request $request){
        
        $categorias = $this->categorias;

        $user = Auth::user();

        $atributo = Nome_atributo::create([
            'id_categoria' => $request->id_categoria,
            'nome_do_atributo' => $request->nome,
            'status' => 1,
            'id_usuario_criador' => $user->id,
        ]);

        return view('dashboard-adiciona-atributo-categoria', [
            'categorias' => $categorias,
            'atributo' => $atributo,
            'id' => $atributo['id_categoria'],
        ]);
    }

    public function dashboardTarefaVer(Request $request){

        $tarefa = TarefaController::show($request->id);
        
        $categorias = $this->categorias;

        if(isset($tarefa[0])){

            return view('dashboard-ver-tarefa', [
                'categorias' => $categorias,
                'tarefas' => $tarefa 
            ]);

        } else {

            return redirect()->route('dashboardHome');

        }

    }

    public function dashboardTarefaConcluir(Request $request){

        $tarefa = TarefaController::concluirTarefa($request->id);

        return redirect()->route('dashboardTarefaVer', ['id' => $request->id]);

    }

    public function dashboardAdicionaTarefa(Request $request){

        $periodos = TarefaPeriodo::all();

        $categorias = $this->categorias;

        return view('dashboard-adiciona-tarefa', [
            'categorias' => $categorias,
            'id_item' => $request->id,
            'periodos' => $periodos
        ]);

    }

    public function dashboardAdicionarTarefa(Request $request){

        if($request->id_item){

            $tarefa = TarefaController::AdicionaTarefaItem($request);

            if( $tarefa['id'] ){
                $status = 'Sucesso';
            } else {
                $status = "Falha!";
            }
    
            return redirect()->route('dashboardAdicionaTarefa', ['id' => $request->id_item,  'status' => $status ]);

        } else {

            $tarefa = TarefaController::AdicionarTarefa($request);

            if( $tarefa ){
                $status = 'Sucesso';
            } else {
                $status = "Falha!";
            }
    
            return redirect()->route('dashboardAdicionaTarefa', ['id' => '',  'status' => $status ]);

        }

    }

}

