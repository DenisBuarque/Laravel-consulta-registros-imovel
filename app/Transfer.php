<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'venal_value', 'iptu_debit', 'debit_condominium',
    ];

}
