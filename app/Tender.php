<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'venal_value',
        'portion',
        'client_id',
        'imovel_id',
        'iptu',
        'condominium',
        'deed_fee',
        'itbi',
        'registration_fee',
        'certificaty',
        'letter',
        'fees',
        'total_value',
    ];

    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }
}
