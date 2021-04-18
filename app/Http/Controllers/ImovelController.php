<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface;
use App\Imovel;
use App\Client;

class ImovelController extends Controller
{
    private $model;

    public function __construct(Imovel $model)
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
            $columns = ['address','district','city'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $immobiles = $query->orderBy('id','DESC')->get();

        }else{
            $immobiles = $this->model->orderBy('id', 'DESC')->paginate(5);
        }
        return view('imovel.index', compact(['immobiles','search']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        return view('imovel.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UtilsRepositoryInterface $utils)
    {
        $data = $request->all();
        Validator::make($data, [
            'client_id' => 'required',
            'type_imovel' => 'required',
            'address' => 'required|string|max:256',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'venal_value' => 'required',
        ])->validate();

        //converte o valor para formato USA
        $data['venal_value'] = $utils->formatMoney($request->venal_value);

        if($this->model->create($data)){
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('imovel.index');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $clients = Client::all();
        $imovel = Imovel::find($id);
        if($imovel):
            return view('imovel.edit', compact(['imovel','clients']));
        endif;
        
        $request->session()->flash('erro', 'Não encontramos o imóvel!');
        return view('imovel.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UtilsRepositoryInterface $utils, $id)
    {
        $data = $request->all();
        Validator::make($data, [
            'client_id' => 'required',
            'type_imovel' => 'required',
            'address' => 'required|string|max:256',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:2',
            'venal_value' => 'required',
        ])->validate();

        //converte o valor para formato USA
        $data['venal_value'] = $utils->formatMoney($request->venal_value);
        
        $imovel = $this->model->find($id);
        if(isset($imovel))
        {
            if($imovel->update($data)){
                $request->session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('imovel.index');
            }else{
                $request->session()->flash('alert', 'Erro ao alterar o registro!');  // mensagem de alerta
                return redirect()->back();
            }
        }

        return redirect()->route('imovel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $imovel = $this->model->find($id);
        if($imovel):
            $imovel->delete();
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
        else:
            $request->session()->flash('erro', 'Erro ao excluir o sucesso!');
        endif;

        return redirect()->route('imovel.index');
    }
}
