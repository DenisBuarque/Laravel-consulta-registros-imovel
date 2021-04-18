<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\UtilsRepositoryInterface; //lembrar de registra no Provider\AppServiceProvider.php
use App\Transfer;
use App\RegistrationFee; // Taxa de registro
use App\DeedFee; // Taxa de escritura
use App\Client;
use App\Imovel;

class TransferController extends Controller
{
    private $model;
    private $client;
    private $imovel;

    public function __construct(Transfer $model, Client $client, Imovel $imovel)
    {
        $this->model = $model;
        $this->client = $client;
        $this->imovel = $imovel;
    }
    
    public function create()
    {
        return view('consultations.transfer.incash.index');
    }

    public function store(Request $request, UtilsRepositoryInterface $utils)
    {
        $data = $request->all();
        Validator::make($data, [
            'venal_value' => 'required',
        ])->validate();
        
        $venal_value = $utils->formatMoney($request->venal_value);
        $itbi_value = ($venal_value*2)/100;
        $iptu_debit = $utils->formatMoney($request->iptu_debit ? $request->iptu_debit : 0);
        $debit_condominium = $utils->formatMoney($request->debit_condominium ? $request->debit_condominium : 0);
        $onus_certificate = 56;

        // Verifica a taxa de registro (registration fee)
        if($venal_value < 56933.73){
            $registration_fee = 1541.39;
        }elseif($venal_value > 124742.46){
            $registration_fee = 3041.29;
        }else{
            $consultation_registration_fee = RegistrationFee::select("*")->where('ate_valor', '>', $venal_value)->orderBy('id', 'ASC')->first();
            $registration_fee = $consultation_registration_fee->custo_total;
        }

        // Verifica a taxa de escritura (deed fee)
        if($venal_value < 6.40){
            $deed_fee = 36.74;
        }elseif($venal_value > 175392.87){
            $deed_fee = 4329.85;
        }else{
            $consultation_deed_fee = DeedFee::select("*")->where('vl_referencia', '>', $venal_value)->orderBy('id', 'ASC')->first();
            $deed_fee = $consultation_deed_fee->vl_total;
        }

        $total = $itbi_value + $iptu_debit + $debit_condominium + $onus_certificate + $registration_fee + $deed_fee;

        $fees = ($total*30)/100; // honorarios

        $investiment_value = $total + $fees;

        $clients = $this->client->all();
        $imovels = $this->imovel->all();

        return view('consultations.transfer.incash.calculate', compact(
            ['venal_value','itbi_value','iptu_debit','debit_condominium','registration_fee','onus_certificate','fees','investiment_value','deed_fee','clients','imovels']
        ));
    }

}
