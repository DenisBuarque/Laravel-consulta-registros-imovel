<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface;
use App\Receipt;
use App\Imovel;
use App\Client;

class ReceiptController extends Controller
{
    private $model;
    private $modelclient;
    private $modelimovel;

    public function __construct(Receipt $model, Client $modelclient, Imovel $modelimovel)
    {
        $this->model = $model;
        $this->modelclient = $modelclient;
        $this->modelimovel = $modelimovel;
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
            $columns = ['client_id'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $receipts = $query->orderBy('id','DESC')->get();

        }else{
            $receipts = $this->model->orderBy('id', 'DESC')->paginate(5);
        }

        $clients = $this->modelclient->all();
        return view('receipt.index', compact(['receipts','search','clients']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->modelclient->all();
        $imovels = $this->modelimovel->all();
        return view('receipt.create',compact(['clients','imovels']));
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
            'total_value' => 'required',
            'client_id' => 'required',
            'imovel_id' => 'required',
        ])->validate();

        $data['total_value'] = $utils->formatMoney($request->total_value);

        if($this->model->create($data)){
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('receipt.index');
        }else{
            $request->session()->flash('erro', 'Erro ao inserir o registro!');
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $receipt = $this->model->find($id);
        if($receipt){
            $request->session()->flash('alert', 'Registro excluído com sucesso');
            $receipt->delete();
            return redirect()->route('receipt.index');
        }else{
            $request->session()->flash('erro', 'Erro ao excluir o registro');
        }
        
        return redirect()->route('receipt.index');

    }
}
