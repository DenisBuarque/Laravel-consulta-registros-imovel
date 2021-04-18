<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface; //lembrar de registra no Provider\AppServiceProvider.php
use App\Inventory;

class InventoryController extends Controller
{
    private $model;

    public function __construct(Inventory $model)
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
        return view('consultations.inventory.index');
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
        Validator::make($data,[
            'venal_value' => 'required',
            'fees' => 'required',
            'ufesp' => 'required',
        ])->validate();

        $venal_value = $utils->formatMoney($request->venal_value);
        $fees = $utils->formatMoney($request->fees);
        $ufesp = $utils->formatMoney($request->ufesp);

        $custas = 0;
        if($venal_value <= 50000.00){
            $custas = 10 * $ufesp;
        }elseif($venal_value >= 50001.00 && $venal_value <= 500000.00){
            $custas = 100 * $ufesp;
        }elseif($venal_value >= 500001.00 && $venal_value <= 2000000.00){
            $custas = 300 * $ufesp;
        }elseif($venal_value >= 2000001.00 && $venal_value <= 5000000.00){
            $custas = 1000 * $ufesp;
        }elseif($venal_value > 5000001.00){
            $custas = 3000 * $ufesp;
        }

        $total_value = $fees + $custas;

        $agent = ($total_value * 15)/100;

        $payment = $total_value + $agent;

        return view('consultations.inventory.calculate', compact(
            ['venal_value','fees','ufesp','custas','agent','payment']
        ));
    }
    
}
