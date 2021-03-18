<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
