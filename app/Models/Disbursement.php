<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disbursement extends Model
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

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function disbursementStatus() {
        return $this->belongsTo(DisbursementStatus::class);
    }

    public function disbursementDetails() {
        return $this->hasMany(DisbursementDetail::class)->with('accountTitle');
    }

    public function approvedByPersonnel() {
        return $this->belongsTo(Personnel::class, 'approved_by', 'id');
    }
    
}
