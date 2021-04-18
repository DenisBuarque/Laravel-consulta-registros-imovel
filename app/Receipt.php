<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'total_value','client_id','imovel_id'
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
