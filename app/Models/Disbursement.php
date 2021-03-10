<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disbursement extends Model
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

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function disbursementStatus() {
        return $this->belongsTo(DisbursementStatus::class);
    }

    public function disbursementDetails() {
        return $this->hasMany(DisbursementDetail::class)->with('accountTitle');
    }
    
}
