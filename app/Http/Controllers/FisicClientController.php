<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Respect\Validation\Validator as v;
use App\Client;
use App\Imovel;

class FisicClientController extends Controller
{
    
    private $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->model->all();
        return view('clients.fisic.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*if(!v::cpf()->validate($request->cpf)){
            $request->session()->flash('erro','CPF inválido!');
            return redirect()->back();
        }*/

        $vc = v::digit()->cpf()->validate($request->cpf);
        
        $data = $request->all();
        Validator::make($data, [
            'name' => 'required|string|unique:clients|max:100',
            'cpf' => 'required|cpf|string|unique:clients|max:11',
            'rg' => 'required|string|unique:clients',
            'ssp' => 'required',
            'civil_state' => 'required',
            'address' => 'required|string|max:256',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'profession' => 'required|string|max:50',
            'nationality' => 'required|string|max:50',
        ])->validate();

        if($this->model->create($data)){

            if($request->new == "S"){
                $request->session()->flash('alert', 'Registro inserido com sucesso!');
                return redirect()->route('clients.fisic.create');
            }else{
                $request->session()->flash('alert', 'Registro inserido com sucesso!');
                return redirect()->route('clients.index');
            }

        }else{
            $request->session()->flash('erro', 'Erro ao inserir o registro!');  // mensagem de alerta
            return redirect()->back();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = $this->model->all();
        $client = Client::find($id);
        if($client){
            return view('clients.fisic.edit', compact(['client','list']));
        }

        session()->flash('erro', 'Registro não encontrado!');
        return redirect()->route('clients.index');  
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
        Validator::make($data, [
            'name' => 'required|string|max:100',
            'cpf' => 'required|string|unique:clients|max:11|cpf',
            'rg' => 'required|string|unique:clients',
            'ssp' => 'required',
            'civil_state' => 'required',
            'address' => 'required|string|max:256',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'profession' => 'required|string|max:50',
            'nationality' => 'required|string|max:50',
        ])->validate();

        $client = $this->model->find($id);
        if(isset($client))
        {
            if($client->update($data)){
                $request->session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('clients.index');
            }else{
                $request->session()->flash('alert', 'Erro ao alterar o registro!');  // mensagem de alerta
                return redirect()->back();
            }
        }

        return redirect()->route('clients.index');
    }

}
