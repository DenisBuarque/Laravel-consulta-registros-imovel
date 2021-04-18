<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface; //lembrar de registra no Provider\AppServiceProvider.php
use App\Declaration;

class DeclarationController extends Controller
{

    protected $model;

    public function __construnt(Declaration $model)
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
        return view('consultations.declaration.index');
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

        return view('consultations.declaration.calculate', compact(['venal_value']));
    }
}
