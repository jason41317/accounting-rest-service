<?php

namespace App\Models;

use App\Models\BaseModel;

class Bank extends BaseModel
{
  protected $guarded = ['id'];
  protected $hidden = [
    'created_at',
    'deleted_at',
    'updated_at',
    'created_by',
    'updated_by',
    'deleted_by'
  ];

  // for audit
  public $isAuditable = true;
  public function auditing()
  {
    $auditing = [];
    $auditing['alias'] = 'Bank';
    $auditing['key'] = $this->name;
    return $auditing;
  }
  // end for audit
  
  public function disbursements()
  {
    return $this->hasMany(Disbursement::class);
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }

  public function accountTitle()
  {
    return $this->belongsTo(AccountTitle::class);
  }
}
