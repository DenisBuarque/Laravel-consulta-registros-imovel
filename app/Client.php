<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    public function imovel()
    {
        return $this->hasMany(Imovel::class);
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function certificate()
    {
        return $this->hasMany(Certificate::class);
    }

    public function declaratoinsession()
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

    //assessor transforma o title em minsculo e coloca primeira letra em maisculo 
    public function getNameAttribute($value)
    {
        return ucwords(mb_strtolower($value, 'UTF-8')); 
    }

    public function getCompanyAttribute($value)
    {
        return ucwords(mb_strtolower($value, 'UTF-8')); 
    }

    public function Incra()
    {
        return $this->hasMany(Incra::class);
    }
}
