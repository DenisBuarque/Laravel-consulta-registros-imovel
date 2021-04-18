<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface;
use App\DeedFee;

class DeedFeeController extends Controller
{
    private $model;

    public function __construct(DeedFee $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deedfees = $this->model->orderBy('id','DESC')->paginate(10);
        return view('deedfee.index', compact('deedfees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deedfee.create');
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
            'vl_referencia' => 'required',
            'emolumento' => 'required',
            'selo' => 'required',
            'vl_total' => 'required',
        ])->validate();

        $data['vl_referencia'] = $utils->formatMoney($request->vl_referencia);
        $data['emolumento'] = $utils->formatMoney($request->emolumento);
        $data['selo'] = $utils->formatMoney($request->selo);
        $data['vl_total'] = $utils->formatMoney($request->vl_total);
        
        if($this->model->create($data)){
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('deedfee.index');
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
        $deedfee = $this->model->find($id);
        if($deedfee){
            return view('deedfee.edit',compact('deedfee'));
        }
        $request->session()>flash('erro','Não encontramos o que procura!');
        return redirect()->route('deedfee.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, UtilsRepositoryInterface $utils)
    {
        $data = $request->all();
        Validator::make($data, [
            'vl_referencia' => 'required',
            'emolumento' => 'required',
            'selo' => 'required',
            'vl_total' => 'required',
        ])->validate();

        $data['vl_referencia'] = $utils->formatMoney($request->vl_referencia);
        $data['emolumento'] = $utils->formatMoney($request->emolumento);
        $data['selo'] = $utils->formatMoney($request->selo);
        $data['vl_total'] = $utils->formatMoney($request->vl_total);

        $deedfee = $this->model->find($id);
        if(isset($deedfee))
        {
            if($deedfee->update($data)){
                session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('deedfee.index');
            }else{
                session()->flash('alert', 'Erro ao alterar o registro!');
                return redirect()->back();
            }
        }

        return redirect()->route('deedfee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $deedfee = $this->model->find($id);
        if($deedfee)
        {
            $request->session()->flash('alert','Registro excluído com sucesso!');
            $deedfee->delete();
        }else{
            $request->session()->flash('erro','Erro ao excluir o registro!');
        }
        return redirect()->route('deedfee.index');
    }
}
