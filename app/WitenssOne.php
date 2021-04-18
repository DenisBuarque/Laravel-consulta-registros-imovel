<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WitnessOne extends Model
{
    protected $fillable = [
        'people',
        'name',
        'cpf',
        'rg',
        'ssp',
        'company',
        'cnpj',
        'profession',
        'nationality',
        'civil_state',
        'spouse',
        'address',
        'number',
        'cep',
        'district',
        'city',
        'state',
        'phone',
        'email',
    ];

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
