<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'registry',
        'craft',
        'certificate',
        'imovel_id',
        'book',
        'sheet',
        'transcription',
        'date_registry',
        'description',
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

    public function certificateimage()
    {
        return $this->belongsTo(CertificateImage::class);
    }

    public function getDateRegistryAttribute($value)
    {
        $date = date_create($value);
        return date_format($date,'d/m/Y');
    }

    public function getDateRegistryUsaAttribute($value)
    {
        $date = date_create($value);
        return date_format($date,'Y-m-d');
    }
}
