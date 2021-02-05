<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function businessStyle() {
        return $this->belongsTo(BusinessStyle::class);
    }

    public function businessType() {
        return $this->belongsTo(BusinessType::class);
    }
}
