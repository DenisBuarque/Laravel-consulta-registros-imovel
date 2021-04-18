<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incra extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'denominacao',
        'localization',
        'total_area',
        'county',
        'zona',
        'state',
        'latitude',
        'logitude',
        'nature',
        'division_country',
        'destiny',
        'dismemberment_area',
        'anexo_area',
        'area_add',
        'amount_family',
        'amount_people',
        'salary_portfolio',
        'salary_not',
        'family_labor',
        'litigation',
        'improvement',
        'use_area',
        'used_area',
        'animal_category',
        'amount_animal',
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
