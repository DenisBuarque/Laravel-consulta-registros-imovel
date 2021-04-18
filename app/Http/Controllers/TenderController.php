<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Tender;
use App\Client;

class TenderController extends Controller
{
    private $terder;
    private $client;

    public function __construct(Tender $tender, Client $client)
    {
        $this->tender = $tender;
        $this->client = $client;
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
            
            $query = $this->tender;
            $columns = ['client_id'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $tenders = $query->orderBy('id','DESC')->get();

        }else{
            $tenders = $this->tender->orderBy('id', 'DESC')->paginate(5);
        }
        $clients = $this->client->all();
        //$tenders = $this->tender->paginate(5);
        return view('tenders.index',compact('tenders','clients','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'client_id' => 'required'
        ]);

        if($this->tender->create($data)){
            $request->session()->flash('alert','Registro adicionado com sucesso!');
            return redirect()->back();
        }else{
            $request->session()->flash('erro','Erro ao adicionar o registro!');
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
        $tender = $this->tender->find($id);
        if($tender){
            if($tender->delete()){
                $request->session()->flash('alert','Registro excluído com sucesso!');
                return redirect()->route('tenders.index');
            }else{
                $request->session()->flash('erro','Erro ao excluir o registro!');
                return redirect()->back();
            }
        }

        $request->session()->flash('erro','Não encontramos o que procura!');
        return redirect()->route('tenders.index');
    }
}
