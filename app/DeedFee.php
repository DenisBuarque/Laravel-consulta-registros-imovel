<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeedFee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vl_referencia','emolumento','selo','vl_total',
    ];

    protected $dates = ['deleted_at'];
}
