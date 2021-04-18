<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface; //lembrar de registra no Provider\AppServiceProvider.php
use App\Constrution;

class ConstructionController extends Controller
{

    protected $model;

    public function __construnt(Construction $model)
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
        return view('consultations.construction.index');
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
            'area' => 'required|numeric',
            'cub' => 'required',
        ])->validate();

        $area = $request->area;
        $cub = $utils->formatMoney($request->cub);

        $calculate_cub = $area * $cub;

        $value_calculo_cub = 0; // Cálcula o custo unitário base da construção
        if($area < 100){
            $value_calculo_cub = ($calculate_cub * 4)/100;
        }elseif($area > 100 && $area < 200){
            $value_calculo_cub = ($calculate_cub * 8)/100;
        }elseif($area > 200 && $area < 300){
            $value_calculo_cub = ($calculate_cub * 14)/100;
        }else{
            $value_calculo_cub = ($calculate_cub * 20)/100;
        }

        $inss_patrimonial = ($value_calculo_cub * 20)/100;
        $inss_segurado = ($value_calculo_cub * 8)/100;
        $rat = ($value_calculo_cub * 3)/100;
        $outros = ($value_calculo_cub * 5.8)/100;

        $total_payment = $inss_patrimonial + $inss_segurado + $rat + $outros;

        return view('consultations.construction.calculate', compact(
            ['area','cub','value_calculo_cub','inss_patrimonial','inss_segurado','rat','outros','total_payment']
        ));
    }
}
