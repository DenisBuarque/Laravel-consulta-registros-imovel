<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeclarationSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'living_room',
        'bedroom',
        'kitchen',
        'bathroom',
        'garage',
        'service_area',
        'front_area',
        'funds_area',
        'left_area',
        'right_area',
        'building_area',
        'ground_area',
        'confront_front',
        'confront_right',
        'confront_left',
        'confront_funds',
        'imovel_id',
        'client_id',
        'witness_1',
        'witness_2',
        'tipo',
    ];

    protected $dates = ['deleted_at'];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function witnessOne()
    {
        return $this->belongsTo(Client::class, 'witness_1');
    }

    public function witnessTwo()
    {
        return $this->belongsTo(Client::class, 'witness_2');
    }
}
