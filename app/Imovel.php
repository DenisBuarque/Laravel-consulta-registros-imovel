<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imovel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'type_imovel',
        'address',
        'number',
        'cep',
        'district',
        'city',
        'state',
        'venal_value',
        'book',
        'sheet',
        'iptu',
        'registration',
        'rip',
        'name_allotment',
        'number_allotment',
        'block_allotment',
        'name_building',
        'number_block',
        'number_apartment',
        'ccir',
        'itr',
        'incra',
        'name_farm',
        'latitude',
        'longitude',
    ];

    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function certificate()
    {
        return $this->hasMany(Certificate::class);
    }

    public function declarationsession()
    {
        return $this->hasMany(DeclarationSession::class);
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class);
    }

    public function tender()
    {
        return $this->hasMany(Tender::class);
    }

    public function Incra()
    {
        return $this->hasMany(Incra::class);
    }
}
