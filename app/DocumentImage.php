<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentImage extends Model
{
    protected $fillable = [
        'document_id','path'
    ];

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
