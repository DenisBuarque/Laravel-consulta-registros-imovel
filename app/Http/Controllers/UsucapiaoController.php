<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface; //lembrar de registra no Provider\AppServiceProvider.php
use App\Usucapiao;

class UsucapiaoController extends Controller
{
    protected $model;

    public function __construnt(Usucapiao $model)
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
        return view('consultations.usucapiao.index');
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
            'fees' => 'required',
        ])->validate();

        $venal_value = $utils->formatMoney($request->venal_value);
        $fees = $utils->formatMoney($request->fees);
        
        $rate = ($venal_value * 30)/100; // Taxa de registro usucapiao

        $total_value = $fees + $rate;

        $agent = ($venal_value * 10)/100;

        $payment = $total_value + $agent;

        return view('consultations.usucapiao.calculate', compact(
            ['venal_value','fees','rate','agent','payment']
        ));
    }

}
