<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptMail extends Model
{
    protected $fillable = [
        'name','email','subject','message'
    ];
}
