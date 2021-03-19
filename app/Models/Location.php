<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes, SecureDelete;

    protected $guarded = ['id'];

    public function rdo()
    {
        return $this->belongsTo(Rdo::class);
    }

    public function contracts()
    {
        return $this->hasMany(Location::class);
    }
}
