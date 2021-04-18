<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name','descriptoin',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
