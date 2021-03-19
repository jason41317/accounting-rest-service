<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
    use HasFactory, SoftDeletes, SecureDelete;
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

    public function billings() {
        return $this->hasMany(Billing::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function getChargeBalancesAttribute() {
        $chargeBalances = DB::select(
            'SELECT
                A.charge_id,
                A.name,
                SUM(IFNULL(A.debit,0)) - SUM(IFNULL(A.credit,0)) AS remaining_balance,
                0 as amount_paid
            FROM
            (
            SELECT 
                    bc.charge_id,
                    ch.name, 
                    SUM(bc.amount) as debit, 
                    0 as credit 
                FROM billing_charges as bc 
                LEFT JOIN billings as b ON bc.billing_id = b.id
                LEFT JOIN contracts as c ON c.id = b.contract_id
                LEFT JOIN charges as ch ON ch.id = bc.charge_id
                WHERE c.id = ' . $this->id . '
                AND ISNULL(b.deleted_at)
                GROUP BY bc.charge_id 
                UNION ALL
                SELECT
                    pc.charge_id,
                    ch.name,
                    0 as debit,
                    SUM(pc.amount) as credit 
                FROM payment_charges as pc 
                LEFT JOIN payments as p ON p.id = pc.payment_id
                LEFT JOIN contracts as c ON c.id = p.contract_id
                LEFT JOIN charges as ch ON ch.id = pc.charge_id
                WHERE c.id = ' . $this->id . ' 
                AND ISNULL(p.deleted_at)
                GROUP BY pc.charge_id
            ) AS A
            GROUP BY A.charge_id
            HAVING remaining_balance != 0
        ');
            
        return $chargeBalances;
    }

    public function assignedPersonnel() {
        return $this->belongsTo(Personnel::class, 'assigned_to', 'id');
    }

    public function approvedByPersonnel() {
        return $this->belongsTo(Personnel::class, 'approved_by', 'id');
    }
}
