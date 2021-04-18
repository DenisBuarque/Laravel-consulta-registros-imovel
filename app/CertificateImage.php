<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateImage extends Model
{
    protected $fillable = [
        'certificate_id','path'
    ];

    public function certificate()
    {
        return $this->hasMany(Certificate::class);
    }
}
