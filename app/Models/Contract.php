<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
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

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'contract_services', 'contract_id', 'service_id');
    }

    public function charges() {
        return $this->belongsToMany(Charge::class, 'contract_charges', 'contract_id', 'charge_id')->withPivot('amount')->with('schedules');
        // return $this->hasMany(ContractCharge::class)->with(['charge','schedules']);
    }

    public function schedules()
    {
        return $this->belongsToMany(Month::class, 'contract_charge_schedules', 'contract_id', 'month_id');
    }

    public function files() {
        return $this->hasMany(ContractFile::class)->with('documentType');
    }

    public function taxType() {
        return $this->belongsTo(TaxType::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }    
        
    public function contractStatus() {
        return $this->belongsTo(ContractStatus::class);
    }

    public function getGroupedFilesAttribute() {
        return $this->files->groupBy(['document_type_id' => function($item) {
            return $item['document_type_id'];
        }]);
    }
}
