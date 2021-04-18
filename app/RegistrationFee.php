<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationFee extends Model
{
    protected $fillable = [
        'vl_ref','codigo','ate_valor','custo_total',
    ];
}
