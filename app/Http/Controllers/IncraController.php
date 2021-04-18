<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Incra;
use App\Client;

class IncraController extends Controller
{
    private $incra;
    private $clients;

    public function __construct(Incra $incra, Client $clients)
    {
        $this->incra = $incra;
        $this->clients = $clients;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = $this->clients->all();
        
        $search = '';
        if(isset($request->search)){
            $search = $request->search;
            $query = $this->incra;
            $columns = ['client_id'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $documents = $query->orderBy('id','DESC')->get();

        }else{
            $documents = $this->incra->orderBy('id', 'DESC')->paginate(10);
        }
        return view('incra.index', compact(['documents','clients','search']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->clients->all();
        return view('incra.create',compact(['clients']));
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
            'client_id' => 'required',
            'denominacao' => 'required|string|max:255',
            'localization' => 'required|string|max:255',
            'total_area' => 'required|string|max:10',
            'county' => 'required|string|max:100',
            'zona' => 'required|string|max:10',
            'state' => 'required|string|max:2',
            'nature' => 'required',
            'destiny' => 'required|string|max:255',
            'amount_people' => 'required|integer',
            'salary_portfolio' => 'required|integer',
            'salary_not' => 'required|integer',
            'family_labor' => 'required|integer',
            'improvement' => 'required',
            'use_area' => 'required',
        ])->validate();

        if($this->incra->create($data)){
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('incra.index');
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
        $clients = $this->clients->all();
        $incra = $this->incra->find($id);
        if($incra) {
            return view('incra.show', compact(['incra','clients']));
        }
        $request->session()->flash('erro', 'Não encontramos o que procura!');
        return view('incra.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $clients = $this->clients->all();
        $incra = $this->incra->find($id);
        if($incra) {
            return view('incra.edit', compact(['incra','clients']));
        }
        $request->session()->flash('erro', 'Não encontramos o incra!');
        return view('incra.index');
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
            'client_id' => 'required',
            'denominacao' => 'required|string|max:255',
            'localization' => 'required|string|max:255',
            'total_area' => 'required|string|max:10',
            'county' => 'required|string|max:100',
            'zona' => 'required|string|max:10',
            'state' => 'required|string|max:2',
            'nature' => 'required',
            'destiny' => 'required|string|max:255',
            'amount_people' => 'required|integer',
            'salary_portfolio' => 'required|integer',
            'salary_not' => 'required|integer',
            'family_labor' => 'required|integer',
            'improvement' => 'required',
            'use_area' => 'required',
        ])->validate();

        $incra = $this->incra->find($id);
        if($incra)
        {
            if($incra->update($data)){
                $request->session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('incra.index');
            }else{
                $request->session()->flash('alert', 'Erro ao alterar o registro!');
                return redirect()->back();
            }
        }

        return redirect()->route('incra.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $incra = $this->incra->find($id);
        if($incra):
            $incra->delete();
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
        else:
            $request->session()->flash('erro', 'Erro ao excluir o sucesso!');
        endif;

        return redirect()->route('incra.index');
    }
}
