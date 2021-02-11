<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function contracts() {
        return $this->belongsToMany(Contract::class, 'contract_services', 'service_id', 'contract_id');
 	}

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
