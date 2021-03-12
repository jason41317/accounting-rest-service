<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function businessStyle() {
        return $this->belongsTo(BusinessStyle::class);
    }

    public function businessType() {
        return $this->belongsTo(BusinessType::class);
    }

    public function contracts() {
        return $this->hasMany(Contract::class);
    }
}
