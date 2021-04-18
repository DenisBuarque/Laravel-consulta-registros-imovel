<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'imovel_id','seller','buyer','witness_1','witness_2',
    ];

    protected $dates = ['deleted_at'];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'buyer');
    }

    public function sellers()
    {
        return $this->belongsTo(Client::class, 'seller');
    }

    public function witnessOne()
    {
        return $this->belongsTo(Client::class, 'witness_1');
    }

    public function witnessTwo()
    {
        return $this->belongsTo(Client::class, 'witness_2');
    }

    public function documentimage()
    {
        return $this->belongsTo(DocumentImage::class);
    }
}
