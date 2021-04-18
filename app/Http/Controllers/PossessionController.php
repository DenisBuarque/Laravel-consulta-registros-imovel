<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface; //lembrar de registra no Provider\AppServiceProvider.php
use App\Possession;
use App\DeedFee; // Taxa de registro

class PossessionController extends Controller
{

    protected $model;

    public function __construnt(Possession $model)
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
        return view('consultations.possession.index');
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
            'venal_value' => 'required',
        ])->validate();

        $venal_value = $utils->formatMoney($request->venal_value);

        // Verifica a taxa de escritura (deed fee)
        if($venal_value < 6.40){
            $deed_fee = 36.74;
        }elseif($venal_value > 175392.87){
            $deed_fee = 4329.85;
        }else{
            $consultation_deed_fee = DeedFee::select("*")->where('vl_referencia', '>', $venal_value)->orderBy('id', 'ASC')->first();
            $deed_fee = $consultation_deed_fee->vl_total;
        }

        $fees = ($venal_value * 1)/100; // honorarios

        $total_value = $deed_fee + $fees;

        return view('consultations.possession.calculate', compact(['venal_value','deed_fee','fees','total_value']));
    }
}
