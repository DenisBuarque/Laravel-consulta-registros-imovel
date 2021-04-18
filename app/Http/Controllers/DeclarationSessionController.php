<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DeclarationSession;
use App\Client;
use App\Imovel;

class DeclarationSessionController extends Controller
{
    
    private $model;
    private $modelclients;
    private $modelimovels;

    public function __construct(DeclarationSession $model, Client $modelclients, Imovel $modelimovels)
    {
        $this->model = $model;
        $this->modelclients = $modelclients;
        $this->modelimovels = $modelimovels;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = $this->modelclients->all();
        $search = '';
        if(isset($request->search)){

            $search = $request->search;
            
            $query = $this->model;
            $columns = ['client_id'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $declarations = $query->orderBy('id','DESC')->get();

        }else{
            $declarations = $this->model->orderBy('id', 'DESC')->paginate(10);
        }
        return view('declaration.index', compact(['declarations','clients','search']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->modelclients->all();
        $imovels = $this->modelimovels->all();
        return view('declaration.create',compact(['clients','imovels']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data,[
            'living_room' => 'required',
            'bedroom' => 'required',
            'kitchen' => 'required',
            'bathroom' => 'required',
            'garage' => 'required',
            'service_area' => 'required',
            'front_area' => 'required',
            'funds_area' => 'required',
            'left_area' => 'required',
            'right_area' => 'required',
            'building_area' => 'required',
            'ground_area' => 'required',
            'imovel_id' => 'required',
            'client_id' => 'required',
            'witness_1' => 'required',
            'witness_2' => 'required',
        ])->validate();

        if($this->model->create($data)) {
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('declaration.index');
        }else{
            $request->session()->flash('erro', 'Erro ao inserir registro!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clients = $this->modelclients->all();
        $imovels = $this->modelimovels->all();
        
        $declaration = $this->model->find($id);
        if($declaration){
            return view('declaration.show', compact(['declaration','clients','imovels']));
        }

        $request->session()->flash('erro', 'Não conseguimos encontrar o que procura!');
        return redirect()->route('declaration.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $clients = $this->modelclients->all();
        $imovels = $this->modelimovels->all();
        $declaration = $this->model->find($id);
        if($declaration){
            return view('declaration.edit', compact(['declaration','clients','imovels']));
        }
        $request->session()->flash('erro', 'Não conseguimos encontrar o que procura!');
        return redirect()->route('declaration.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        Validator::make($data,[
            'living_room' => 'required',
            'bedroom' => 'required',
            'kitchen' => 'required',
            'bathroom' => 'required',
            'garage' => 'required',
            'service_area' => 'required',
            'front_area' => 'required',
            'funds_area' => 'required',
            'left_area' => 'required',
            'right_area' => 'required',
            'building_area' => 'required',
            'ground_area' => 'required',
            'imovel_id' => 'required',
            'client_id' => 'required',
            'witness_1' => 'required',
            'witness_2' => 'required',
        ])->validate();

        $declaration = $this->model->find($id);
        if($declaration)
        {
            $request->session()->flash('alert','Registro alterado com sucesso!');
            return redirect()->route('declaration.index');
        }
        $request->session()->flash('aeero','Registro não encontrado!');
        return redirect()->route('declaration.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
