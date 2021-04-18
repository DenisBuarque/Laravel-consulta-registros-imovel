<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface;
use App\RegistrationFee;

class RegistrationFeeController extends Controller
{
    private $model;

    public function __construct(RegistrationFee $model)
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
        $registrationfees = $this->model->orderBy('id','DESC')->paginate(10);
        return view('registrationfee.index', compact('registrationfees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registrationfee.create');
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
            'vl_ref' => 'required',
            'codigo' => 'required',
            'ate_valor' => 'required',
            'custo_total' => 'required',
        ])->validate();

        $data['vl_ref'] = $utils->formatMoney($request->vl_ref);
        $data['ate_valor'] = $utils->formatMoney($request->ate_valor);
        $data['custo_total'] = $utils->formatMoney($request->custo_total);
        
        if($this->model->create($data)){
            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('registrationfee.index');
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
        $registrationfee = $this->model->find($id);
        if($registrationfee){
            return view('registrationfee.edit',compact('registrationfee'));
        }
        $request->session()>flash('erro','Não encontramos o que procura!');
        return redirect()->route('registrationfee.index');
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
            'vl_ref' => 'required',
            'codigo' => 'required',
            'ate_valor' => 'required',
            'custo_total' => 'required',
        ])->validate();

        $data['vl_ref'] = $utils->formatMoney($request->vl_ref);
        $data['ate_valor'] = $utils->formatMoney($request->ate_valor);
        $data['custo_total'] = $utils->formatMoney($request->custo_total);

        $registrationfee = $this->model->find($id);
        if(isset($registrationfee))
        {
            if($registrationfee->update($data)){
                session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('registrationfee.index');
            }else{
                session()->flash('alert', 'Erro ao alterar o registro!');
                return redirect()->back();
            }
        }

        return redirect()->route('registrationfee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $registrationfee = $this->model->find($id);
        if($registrationfee)
        {
            $request->session()->flash('alert','Registro excluído com sucesso!');
            $registrationfee->delete();
        }else{
            $request->session()->flash('erro','Erro ao excluir o registro!');
        }
        return redirect()->route('registrationfee.index');
    }
}
