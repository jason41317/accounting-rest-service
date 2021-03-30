<?php

namespace App\Models;

use App\Models\BaseModel;


class Rdo extends BaseModel
{
    protected $guarded = ['id'];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
