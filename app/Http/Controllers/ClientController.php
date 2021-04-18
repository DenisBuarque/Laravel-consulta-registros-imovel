<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Client;

class ClientController extends Controller
{
    
    private $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = '';
        if(isset($request->search)){

            $search = $request->search;
            
            $query = $this->model;
            $columns = ['name','company'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $clients = $query->orderBy('id','DESC')->get();

        }else{
            $clients = $this->model->orderBy('id', 'DESC')->paginate(10);
        }
        return view('clients.index', compact(['clients','search']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.fisic.create');
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
        Validator::make($data, [
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:256',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'phone' => 'required|string|max:9',
        ])->validate();

        if($this->model->create($data)){
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('clients.index');
        }else{
            $request->session()->flash('erro', 'Erro ao inserir o registro!');  // mensagem de alerta
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $client = Client::find($id);
        if($client){
            return view('clients.show', compact('client'));
        }
        $request->session()->flash('erro', 'Registro não encontrado!');
        return redirect()->route('clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        if($client){
            return view('clients.fisic.edit', compact('client'));
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
            'address' => 'required|string|max:256',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'phone' => 'required|string|max:9',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $client = Client::find($id);
        if($client){
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
            $client->delete();
        }else{
            $request->session()->flash('erro', 'Erro ao excluído o registro!');
        }
        return redirect()->route('clients.index');
    }
}
