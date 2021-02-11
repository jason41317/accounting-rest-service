<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function services() {
        return $this->belongsToMany(Service::class, 'contract_services', 'contract_id', 'service_id');
    }

    public function contractCharges() {
        return $this->hasMany(ContractCharge::class)->with(['charge','schedules']);
    }

    public function files() {
        return $this->hasMany(ContractFile::class)->with('documentType');
    }

    public function getGroupedFilesAttribute() {
        return $this->files->groupBy(['document_type_id' => function($item) {
            return $item['document_type_id'];
        }]);
    }
}
